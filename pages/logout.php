<?php
session_start();
session_destroy();
header('Content-type: text/html; charset=utf-8');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout Success</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .logout-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            width: 90%;
            transform: scale(0.9);
            opacity: 0;
            animation: fadeIn 0.5s forwards;
            position: relative;
            overflow: hidden;
        }

        .logout-container::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 70%);
            transform: rotate(30deg);
        }

        @keyframes fadeIn {
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .logout-icon {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            position: relative;
        }

        .logout-icon .circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border: 3px solid #764ba2;
            border-radius: 50%;
            border-top-color: transparent;
            animation: spin 1.5s linear infinite;
        }

        .logout-icon .door {
            position: absolute;
            width: 60%;
            height: 60%;
            top: 20%;
            left: 20%;
            background: #764ba2;
            border-radius: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .logout-icon .door::after {
            content: '';
            position: absolute;
            left: 70%;
            width: 15%;
            height: 30%;
            background: #fff;
            border-radius: 50%;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        h1 {
            color: #333;
            margin-bottom: 15px;
            font-weight: 600;
        }

        p {
            color: #666;
            margin-bottom: 25px;
            font-size: 16px;
        }

        .progress-bar {
            height: 6px;
            background: #e0e0e0;
            border-radius: 3px;
            margin-bottom: 30px;
            overflow: hidden;
        }

        .progress {
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, #667eea, #764ba2);
            animation: progress 2s forwards;
            border-radius: 3px;
        }

        @keyframes progress {
            to {
                width: 100%;
            }
        }

        .btn {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.6);
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background-color: #f00;
            opacity: 0;
        }

        @media (max-width: 480px) {
            .logout-container {
                padding: 30px 20px;
            }

            .logout-icon {
                width: 80px;
                height: 80px;
            }
        }
    </style>
</head>

<body>
    <div class="logout-container">
        <div class="logout-icon">
            <div class="circle"></div>
            <div class="door"></div>
        </div>
        <h1>Logout Berhasil</h1>
        <p>Anda telah berhasil keluar. Anda akan segera diarahkan ulang.</p>
        <div class="progress-bar">
            <div class="progress"></div>
        </div>
        <a href="../" class="btn">Kembali ke Home</a>
    </div>

    <script>
        // Create confetti effect
        function createConfetti() {
            const colors = ['#667eea', '#764ba2', '#ff6b6b', '#4ecdc4', '#f7fff7'];

            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = -10 + 'px';
                confetti.style.transform = 'rotate(' + Math.random() * 360 + 'deg)';

                document.body.appendChild(confetti);

                const animationDuration = Math.random() * 3 + 2;

                confetti.style.animation = `fall ${animationDuration}s linear forwards`;

                // Create keyframes dynamically
                const style = document.createElement('style');
                style.innerHTML = `
                    @keyframes fall {
                        to {
                            transform: translateY(100vh) rotate(${Math.random() * 360}deg);
                            opacity: 0.7;
                        }
                    }
                `;
                document.head.appendChild(style);

                // Remove confetti after animation
                setTimeout(() => {
                    confetti.remove();
                    style.remove();
                }, animationDuration * 1000);
            }
        }

        // Trigger confetti after a short delay
        setTimeout(createConfetti, 500);

        // Redirect after 5 seconds
        setTimeout(() => {
            window.location.href = '../';
        }, 5000);
    </script>
</body>

</html>