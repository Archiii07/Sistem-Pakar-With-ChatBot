<?php
include __DIR__ . '/../auth.php';
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'koneksi.php';

// Initialize chat history if not set
if (!isset($_SESSION['chat_history'])) {
    $_SESSION['chat_history'] = [];
}

// Function to perform forward chaining inference
function forwardChaining($conn, $selected_symptoms)
{
    if (empty($selected_symptoms)) {
        return "Silakan pilih gejala terlebih dahulu.";
    }

    // Prepare placeholders for IN clause
    $placeholders = implode(',', array_fill(0, count($selected_symptoms), '?'));

    // Query to get all matching diseases with count of matched symptoms
    $sql = "
        SELECT a.kd_penyakit, COUNT(DISTINCT a.kd_gejala) AS matched_symptom_count
        FROM tbl_aturan a
        WHERE a.kd_gejala IN ($placeholders)
        GROUP BY a.kd_penyakit
    ";

    $stmt = $conn->prepare($sql);
    $stmt->execute($selected_symptoms);
    $matched_results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (count($matched_results) > 0) {
        // For each disease, get the total symptom count for that disease
        $disease_ids = array_column($matched_results, 'kd_penyakit');
        $placeholders_diseases = implode(',', array_fill(0, count($disease_ids), '?'));

        $sql_total_per_disease = "
            SELECT kd_penyakit, COUNT(DISTINCT kd_gejala) AS total_symptom_count
            FROM tbl_aturan
            WHERE kd_penyakit IN ($placeholders_diseases)
            GROUP BY kd_penyakit
        ";

        $stmt_total = $conn->prepare($sql_total_per_disease);
        $stmt_total->execute($disease_ids);
        $total_symptoms = $stmt_total->fetchAll(PDO::FETCH_ASSOC);

        // Map total symptom counts by disease id
        $total_symptom_count_map = [];
        foreach ($total_symptoms as $row) {
            $total_symptom_count_map[$row['kd_penyakit']] = $row['total_symptom_count'];
        }

        $response = "Berdasarkan gejala yang Anda pilih, berikut kemungkinan penyakit:<br><br>";

        // Get all disease names first
        $disease_names = [];
        foreach ($matched_results as $result) {
            $kd_penyakit = $result['kd_penyakit'];
            $stmt = $conn->prepare("SELECT nama_penyakit FROM tbl_informasi WHERE kd_penyakit = ?");
            $stmt->execute([$kd_penyakit]);
            $disease = $stmt->fetch(PDO::FETCH_ASSOC);
            $disease_names[$kd_penyakit] = $disease ? htmlspecialchars($disease['nama_penyakit']) : "Nama penyakit tidak ditemukan";
        }

        // Build response with all matching diseases and calculate match percentage based on symptom count
        foreach ($matched_results as $result) {
            $kd_penyakit = $result['kd_penyakit'];
            $matched_symptom_count = $result['matched_symptom_count'];
            $total_symptom_count = $total_symptom_count_map[$kd_penyakit] ?? 1; // avoid division by zero

            // Calculate symptom count match percentage
            $symptom_count_percentage = ($matched_symptom_count / $total_symptom_count) * 100;

            $match_percentage = round($symptom_count_percentage, 2);

            if ($match_percentage > 100) {
                $match_percentage = 100;
            }

            $response .= "<strong>" . $disease_names[$kd_penyakit] . "</strong> - ";
            $response .= "Kecocokan: " . $match_percentage . "%<br>";
        }

        // Sort diseases by match percentage descending to find highest match
        usort($matched_results, function ($a, $b) use ($total_symptom_count_map) {
            $a_total = $total_symptom_count_map[$a['kd_penyakit']] ?? 1;
            $b_total = $total_symptom_count_map[$b['kd_penyakit']] ?? 1;
            $a_ratio = $a['matched_symptom_count'] / $a_total;
            $b_ratio = $b['matched_symptom_count'] / $b_total;
            return $b_ratio <=> $a_ratio;
        });

        $top_disease_id = $matched_results[0]['kd_penyakit'];
        $response .= "<br>Penyakit dengan kecocokan tertinggi adalah <strong>" . $disease_names[$top_disease_id] . "</strong>.<br>";
        $response .= "Apakah Anda ingin melihat detail penyakit tersebut? (ya atau tidak)";

        return $response;
    } else {
        return "Maaf, tidak ditemukan penyakit yang cocok dengan gejala yang Anda pilih.";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['selected_symptoms'])) {
        $selected_symptoms = $_POST['selected_symptoms'];

        // Fetch symptom descriptions for selected symptoms
        $placeholders = implode(',', array_fill(0, count($selected_symptoms), '?'));
        $stmt = $conn->prepare("SELECT gejala FROM tbl_gejala WHERE kd_gejala IN ($placeholders) ORDER BY gejala ASC");
        $stmt->execute($selected_symptoms);
        $symptom_descriptions = $stmt->fetchAll(PDO::FETCH_COLUMN);

        // Add user message to chat history with symptom descriptions instead of codes
        $user_message = "Saya merasakan gejala: " . implode(", ", $symptom_descriptions);
        $_SESSION['chat_history'][] = ['sender' => 'user', 'message' => htmlspecialchars($user_message)];

        // Get AI response using forward chaining
        $ai_response = forwardChaining($conn, $selected_symptoms);

        // Add AI response to chat history
        $_SESSION['chat_history'][] = ['sender' => 'ai', 'message' => $ai_response];

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } elseif (isset($_POST['custom_message']) && trim($_POST['custom_message']) !== '') {
        // Handle custom message input
        $custom_message = trim($_POST['custom_message']);
        $_SESSION['chat_history'][] = ['sender' => 'user', 'message' => htmlspecialchars($custom_message)];

        // Enhanced response for custom messages with symptom and disease help
        $lower_msg = strtolower($custom_message);
        $help_response = '';

        // Check if last AI message was a disease prediction to ask for detail
        $last_ai_message = '';
        for ($i = count($_SESSION['chat_history']) - 1; $i >= 0; $i--) {
            if ($_SESSION['chat_history'][$i]['sender'] === 'ai') {
                $last_ai_message = $_SESSION['chat_history'][$i]['message'];
                break;
            }
        }

        // Detect if last AI message was a disease prediction
        $disease_predicted = false;
        $predicted_disease_name = '';
        if (preg_match('/Penyakit dengan kecocokan tertinggi adalah <strong>(.*?)<\/strong>/', $last_ai_message, $matches)) {
            $disease_predicted = true;
            $predicted_disease_name = strip_tags($matches[1]);
        }

        // Normalize slang and informal expressions
        $slang_map = [
            'gak' => 'tidak',
            'ga' => 'tidak',
            'nggak' => 'tidak',
            'iya' => 'ya',
            'yoi' => 'ya',
            'sip' => 'ya',
            'oke' => 'ya',
            'ok' => 'ya',
            'makasih' => 'terima kasih',
            'makasi' => 'terima kasih',
            'thx' => 'terima kasih',
            'halo' => 'halo',
            'hai' => 'hai',
            'hallo' => 'hallo',
            'pagi' => 'selamat pagi',
            'siang' => 'selamat siang',
            'sore' => 'selamat sore',
            'malam' => 'selamat malam',
            'apa kabar' => 'apa kabar',
            'gejala' => 'gejala',
            'sakit' => 'sakit',
            'penyakit' => 'penyakit',
            'clear' => 'clear',
            'reset' => 'reset',
            'help' => 'help',
            'ya' => 'ya',
            'tidak' => 'tidak',
            'yes' => 'ya',
            'no' => 'tidak',
        ];

        // Replace slang in user message
        $words = preg_split('/\s+/', $lower_msg);
        $normalized_words = [];
        foreach ($words as $word) {
            $normalized_words[] = $slang_map[$word] ?? $word;
        }
        $normalized_msg = implode(' ', $normalized_words);

        // If user types 'clear' or 'reset', clear chat history
        if (in_array($normalized_msg, ['clear', 'reset'])) {
            $_SESSION['chat_history'] = [];
            session_regenerate_id(true);
            $help_response = "Chat telah dibersihkan. Silakan mulai percakapan baru.";
        }
        // If user types 'help', show help keywords
        elseif ($normalized_msg === 'help') {
            $help_response = "Anda dapat mengetik kata kunci berikut untuk berinteraksi dengan chatbot:\n";
            $help_response .= "- 'gejala' : Memilih gejala yang Anda rasakan untuk diagnosis penyakit.\n";
            $help_response .= "- 'clear' atau 'reset' : Membersihkan riwayat chat.\n";
            $help_response .= "- 'ya' atau 'tidak' : Menanggapi pertanyaan detail penyakit.\n";
            $help_response .= "- Ucapan sapaan seperti 'halo', 'hai', dll.\n";
            $help_response .= "Silakan ketik gejala atau pertanyaan Anda.";
        }
        // If last AI message was disease prediction and user says yes/iya, show disease details
        elseif ($disease_predicted && (strpos($normalized_msg, 'ya') !== false)) {
            // Fetch disease details from tbl_informasi by disease name
            try {
                $stmt = $conn->prepare("SELECT deskripsi, pencegahan FROM tbl_informasi WHERE nama_penyakit = ?");
                $stmt->execute([$predicted_disease_name]);
                $disease_details = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($disease_details) {
                    $description = nl2br(htmlspecialchars($disease_details['deskripsi']));
                    $prevention = nl2br(htmlspecialchars($disease_details['pencegahan']));
                    $help_response = "<strong>Deskripsi Penyakit:</strong><br>" . $description . "<br><br><strong>Pencegahan:</strong><br>" . $prevention;
                } else {
                    $help_response = "Maaf, detail penyakit tidak ditemukan.";
                }
            } catch (PDOException $e) {
                $help_response = "Terjadi kesalahan saat mengambil detail penyakit.";
            }
        } elseif ($disease_predicted && (strpos($normalized_msg, 'tidak') !== false)) {
            // User declined to see details
            $help_response = "Baik, jika Anda membutuhkan bantuan lain, silakan tanyakan.";
        } elseif (strpos($normalized_msg, 'gejala') !== false || strpos($normalized_msg, 'sakit') !== false || strpos($normalized_msg, 'penyakit') !== false) {
            // Build symptom selection form HTML
            $symptom_form_html = '<form method="post" action="" class="symptom-selection-form">';
            $symptom_form_html .= '<fieldset><legend class="text-sm font-semibold mb-2">Pilih Gejala yang Anda Rasakan:</legend>';
            $symptom_form_html .= '<div class="grid grid-cols-2 gap-2 max-h-60 overflow-y-auto" style="max-height: 15rem; overflow-y: auto;">';

            // Fetch symptoms from database for selection
            try {
                $stmt = $conn->prepare("SELECT kd_gejala, gejala FROM tbl_gejala ORDER BY gejala ASC");
                $stmt->execute();
                $symptoms = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                die("Error fetching symptoms: " . $e->getMessage());
            }

            foreach ($symptoms as $symptom) {
                $symptom_form_html .= '<label class="inline-flex items-center space-x-2 text-sm">';
                $symptom_form_html .= '<input type="checkbox" name="selected_symptoms[]" value="' . htmlspecialchars($symptom['kd_gejala']) . '" class="form-checkbox h-4 w-4 text-blue-600" />';
                $symptom_form_html .= '<span>' . htmlspecialchars($symptom['gejala']) . '</span>';
                $symptom_form_html .= '</label>';
            }
            $symptom_form_html .= '</div></fieldset>';
            $symptom_form_html .= '<div class="mt-3 flex justify-end space-x-2">';
            $symptom_form_html .= '<button type="submit" class="symptom-submit bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Kirim</button>';
            $symptom_form_html .= '<button type="button" class="symptom-cancel bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Batal</button>';
            $symptom_form_html .= '</div></form>';

            $help_response = "Kalau mau tau penyakit berdasarkan gejala, pilih gejala yang kamu rasain dari daftar di bawah ya. Nanti aku bantu analisis kemungkinan penyakitnya.<br>" . $symptom_form_html;
        } else {
            // Separate greetings, thank yous, and fallback responses with slang and varied phrases
            $greetings = ['halo', 'hai', 'hallo', 'selamat pagi', 'selamat siang', 'selamat sore', 'selamat malam', 'apa kabar', 'bro', 'sis', 'gan', 'bos', 'halo bro', 'halo sis'];
            $thank_yous = ['terima kasih', 'makasih', 'makasi', 'thx', 'thanks', 'thank you', 'makasih ya', 'makasih banget'];
            $affirmations = ['ya', 'iya', 'yoi', 'sip', 'oke', 'ok', 'betul', 'bener', 'setuju'];
            $negations = ['tidak', 'gak', 'ga', 'nggak', 'enggak', 'no', 'ndak'];

            $response = '';

            // Check greetings
            foreach ($greetings as $greet) {
                if (strpos($normalized_msg, $greet) !== false) {
                    $response = "Halo! Ada yang bisa aku bantu, bro?";
                    break;
                }
            }

            // Check thank yous
            if ($response === '') {
                foreach ($thank_yous as $thank) {
                    if (strpos($normalized_msg, $thank) !== false) {
                        $response = "Sama-sama! Senang bisa bantu, ya.";
                        break;
                    }
                }
            }

            // Check affirmations
            if ($response === '') {
                foreach ($affirmations as $affirm) {
                    if (strpos($normalized_msg, $affirm) !== false) {
                        $response = "Sip, aku catat ya.";
                        break;
                    }
                }
            }

            // Check negations
            if ($response === '') {
                foreach ($negations as $neg) {
                    if (strpos($normalized_msg, $neg) !== false) {
                        $response = "Oke, aku paham kok.";
                        break;
                    }
                }
            }

            // If no matches, fallback response
            if ($response === '') {
                // Detect if user is asking a question (ends with ? or contains question words)
                $question_words = ['apa', 'kenapa', 'bagaimana', 'dimana', 'kapan', 'siapa', 'mengapa', 'gimana', 'kok'];
                $is_question = false;
                if (substr(trim($custom_message), -1) === '?') {
                    $is_question = true;
                } else {
                    foreach ($question_words as $qw) {
                        if (strpos($normalized_msg, $qw) !== false) {
                            $is_question = true;
                            break;
                        }
                    }
                }

                if ($is_question) {
                    $response = "Hmm, itu pertanyaan bagus. Aku coba cari tahu ya...";
                } else {
                    $response = "Maaf, aku belum ngerti nih. Bisa jelasin lagi atau ketik 'help' buat info lebih lanjut.";
                }
            }

            $help_response = $response;
        }

        $_SESSION['chat_history'][] = ['sender' => 'ai', 'message' => $help_response];

        // Redirect to avoid form resubmission
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }

    // Clear chat history
    if (isset($_POST['clear_chat'])) {
        $_SESSION['chat_history'] = [];
        session_regenerate_id(true);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    }
}

// Fetch symptoms from database for selection (for initial page load, not used in form anymore)
try {
    $stmt = $conn->prepare("SELECT kd_gejala, gejala FROM tbl_gejala ORDER BY kd_gejala");
    $stmt->execute();
    $symptoms = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching symptoms: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dr. Bot - Asisten Kesehatan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #4338ca;
            --secondary: #10b981;
            --accent: #f59e0b;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            overflow: hidden;
        }

        .chat-container {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-radius: 1rem;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .chat-header {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .chat-messages {
            scrollbar-width: thin;
            scrollbar-color: var(--primary) #f1f1f1;
            flex-grow: 1;
            overflow-y: auto;
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background-color: var(--primary);
            border-radius: 20px;
        }

        .user-message {
            background-color: var(--primary);
            color: white;
            border-top-right-radius: 0;
            max-width: 80%;
            margin-left: auto;
        }

        .ai-message {
            background-color: white;
            border-top-left-radius: 0;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            max-width: 80%;
            margin-right: auto;
        }

        .typing-indicator span {
            display: inline-block;
            width: 8px;
            height: 8px;
            margin-right: 3px;
            background-color: #9ca3af;
            border-radius: 50%;
            animation: bounce 1.4s infinite ease-in-out both;
        }

        .typing-indicator span:nth-child(1) {
            animation-delay: -0.32s;
        }

        .typing-indicator span:nth-child(2) {
            animation-delay: -0.16s;
        }

        @keyframes bounce {

            0%,
            80%,
            100% {
                transform: scale(0);
            }

            40% {
                transform: scale(1);
            }
        }

        .symptom-grid {
            scrollbar-width: thin;
            scrollbar-color: var(--primary) #f1f1f1;
        }

        .symptom-item:hover {
            background-color: #eff6ff;
            transition: background-color 0.2s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.3);
        }

        .send-btn:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }
    </style>
</head>

<body class="bg-gray-50">
    <div class="chat-container bg-white">
        <!-- Chat header -->
        <div class="chat-header p-4 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <img src="https://img.icons8.com/color/96/000000/health-checkup.png" alt="Dr. Bot" class="w-10 h-10">
                <div>
                    <h2 class="text-white font-semibold text-lg">Dr. Bot</h2>
                    <p class="text-xs text-indigo-100">Asisten Kesehatan Digital</p>
                </div>
            </div>
            <div class="flex items-center space-x-2">
                <button id="reset-chat" class="p-2 rounded-full hover:bg-indigo-500 transition-colors" title="Reset Percakapan">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Chat status -->
        <div class="bg-green-600 text-white text-xs px-4 py-1 flex items-center">
            <span class="relative flex h-2 w-2 mr-2">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-300 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-400"></span>
            </span>
            Online - Siap membantu
        </div>

        <!-- Chat messages -->
        <div id="chat-box" class="chat-messages p-4 space-y-4">
            <!-- Initial greeting -->
            <div class="ai-message rounded-lg p-3">
                <div class="flex items-start space-x-2">
                    <img src="https://miro.medium.com/v2/resize:fit:1400/1*I9KrlBSL9cZmpQU3T2nq-A.jpeg" alt="AI" class="w-8 h-8 rounded-full">
                    <div>
                        <p class="font-medium text-indigo-600 text-xs">Dr. Bot</p>
                        <p class="text-gray-800">Halo! Saya Dr. Bot, asisten kesehatan digital Anda. Saya bisa membantu mendiagnosis gejala yang Anda rasakan. Silakan pilih gejala atau tanyakan apa saja!</p>
                    </div>
                </div>
            </div>

            <?php if (!empty($_SESSION['chat_history'])): ?>
                <?php
                $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'Anda';
                ?>
                <?php foreach ($_SESSION['chat_history'] as $chat): ?>
                    <div class="<?php echo $chat['sender'] === 'user' ? 'user-message' : 'ai-message'; ?> rounded-lg p-3">
                        <?php if ($chat['sender'] === 'ai'): ?>
                            <div class="flex items-start space-x-2">
                                <img src="https://miro.medium.com/v2/resize:fit:1400/1*I9KrlBSL9cZmpQU3T2nq-A.jpeg" alt="AI" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-medium text-indigo-600 text-xs">Dr. Bot</p>
                                    <div class="text-gray-800"><?php echo $chat['message']; ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="flex items-start space-x-2">
                                <img src="https://img.icons8.com/color/48/000000/user-male-circle--v1.png" alt="User" class="w-8 h-8 rounded-full">
                                <div>
                                    <p class="font-medium text-white text-xs"><?php echo $username; ?></p>
                                    <p class="text-white"><?php echo $chat['message']; ?></p>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- Typing indicator -->
            <div id="typing-indicator" class="ai-message rounded-lg p-3" style="display:none;">
                <div class="flex items-center space-x-2">
                    <img src="https://miro.medium.com/v2/resize:fit:1400/1*I9KrlBSL9cZmpQU3T2nq-A.jpeg" alt="AI" class="w-8 h-8 rounded-full">
                    <div class="flex space-x-1">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Message input -->
        <form method="post" action="" class="p-4 bg-white border-t border-gray-200 flex items-center space-x-2">
            <input type="text" name="custom_message" id="custom_message" placeholder="Ketik pesan Anda..." autocomplete="off"
                class="input-field flex-grow border border-gray-300 rounded-full py-2 px-4 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            <button type="submit" class="send-btn text-white bg-indigo-600 hover:bg-indigo-700 rounded-full p-2 transition-transform">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                </svg>
            </button>
        </form>
    </div>

    <script>
        // Scroll to bottom of chat
        function scrollToBottom() {
            const chatBox = document.getElementById('chat-box');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        // Show typing indicator when form is submitted
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            document.getElementById('typing-indicator').style.display = 'flex';
            scrollToBottom();
        });

        // Reset chat functionality
        document.getElementById('reset-chat').addEventListener('click', function() {
            fetch(window.location.href, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'clear_chat=1'
            }).then(() => {
                window.location.reload();
            });
        });

        // Handle symptom form interactions
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('symptom-submit')) {
                e.preventDefault();
                const form = e.target.closest('form');
                if (!form) return;

                // Check if at least one symptom is selected
                const checkedSymptoms = form.querySelectorAll('input[type="checkbox"]:checked');
                if (checkedSymptoms.length === 0) {
                    alert('Silakan pilih setidaknya satu gejala!');
                    return;
                }

                // Submit the form
                const formData = new FormData(form);
                fetch(window.location.href, {
                    method: 'POST',
                    body: formData,
                }).then(() => {
                    window.location.reload();
                });
            } else if (e.target.classList.contains('symptom-cancel')) {
                e.preventDefault();
                const form = e.target.closest('form');
                if (form) form.remove();
            } else if (e.target.classList.contains('detail-btn')) {
                e.preventDefault();
                const diseaseName = e.target.dataset.disease;
                const input = document.getElementById('custom_message');
                input.value = 'detail ' + diseaseName;
                form.dispatchEvent(new Event('submit'));
            }
        });

        // Initial scroll to bottom
        scrollToBottom();
    </script>
</body>

</html>