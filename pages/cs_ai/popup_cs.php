<!-- Floating chatbot button with animation -->
<div class="fixed bottom-6 right-6 z-50">
  <button id="chatbot-toggle" class="relative group">
    <!-- Main button with pulse animation -->
    <div class="flex items-center justify-center bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-full p-4 shadow-xl hover:shadow-2xl transition-all duration-300 transform hover:scale-110">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
      </svg>
      <span class="absolute top-0 right-0 flex h-3 w-3">
        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
        <span class="relative inline-flex rounded-full h-3 w-3 bg-green-500"></span>
      </span>
    </div>

    <!-- Tooltip -->
    <div class="absolute -top-12 right-0 bg-gray-800 text-white text-xs rounded py-1 px-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200 whitespace-nowrap">
      Konsultasi Kesehatan
      <div class="absolute bottom-0 right-4 w-2 h-2 bg-gray-800 transform rotate-45 -mb-1"></div>
    </div>
  </button>
</div>

<!-- Chatbot popup with modern design -->
<div id="chatbot-popup" class="fixed bottom-24 right-6 w-96 rounded-xl shadow-2xl overflow-hidden transform transition-all duration-300 origin-bottom-right scale-0 opacity-0 z-50">
  <!-- Popup content with proper spacing -->
  <div class="bg-white h-[500px]">
    <iframe src="?pages=cs_ai" class="w-full h-full border-0"></iframe>
  </div>
</div>

<script>
  const chatbotToggle = document.getElementById('chatbot-toggle');
  const chatbotPopup = document.getElementById('chatbot-popup');
  const chatbotClose = document.getElementById('chatbot-close');

  // Toggle popup with animation
  chatbotToggle.addEventListener('click', (e) => {
    e.stopPropagation();
    if (chatbotPopup.classList.contains('scale-0')) {
      chatbotPopup.classList.remove('scale-0', 'opacity-0');
      chatbotPopup.classList.add('scale-100', 'opacity-100');
    } else {
      chatbotPopup.classList.remove('scale-100', 'opacity-100');
      chatbotPopup.classList.add('scale-0', 'opacity-0');
    }
  });

  // Close popup
  chatbotClose.addEventListener('click', () => {
    chatbotPopup.classList.remove('scale-100', 'opacity-100');
    chatbotPopup.classList.add('scale-0', 'opacity-0');
  });

  // Close when clicking outside
  document.addEventListener('click', (e) => {
    if (!chatbotPopup.contains(e.target)) {
      chatbotPopup.classList.remove('scale-100', 'opacity-100');
      chatbotPopup.classList.add('scale-0', 'opacity-0');
    }
  });

  // Prevent iframe from propagating events
  document.querySelector('iframe').addEventListener('click', (e) => {
    e.stopPropagation();
  });
</script>