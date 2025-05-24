<?php include './pages/header.php'; ?>
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <!-- Introduction Section -->
  <div class="bg-gradient-to-br from-white to-blue-50 rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100">
    <div class="p-8">
      <div class="flex items-center mb-4">
        <div class="bg-blue-100 p-3 rounded-full mr-4">
          <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">1. Pendahuluan</h2>
      </div>
      <p class="text-gray-600 leading-relaxed mb-4">
        Penyakit kulit merupakan salah satu masalah kesehatan yang sering terjadi dan memerlukan diagnosis yang tepat untuk penanganan yang efektif. Sistem pakar berbasis kecerdasan buatan dapat membantu dalam mendiagnosis penyakit kulit secara cepat dan akurat.
      </p>
      <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r">
        <p class="text-blue-700 font-medium">
          <span class="font-bold">Forward Chaining</span> bekerja dengan mencocokkan fakta-fakta awal dengan aturan yang ada untuk menghasilkan kesimpulan.
        </p>
      </div>
    </div>
  </div>

  <!-- Forward Chaining Method Section -->
  <div class="bg-gradient-to-br from-white to-purple-50 rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100">
    <div class="p-8">
      <div class="flex items-center mb-4">
        <div class="bg-purple-100 p-3 rounded-full mr-4">
          <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">2. Metode Forward Chaining</h2>
      </div>
      <p class="text-gray-600 leading-relaxed mb-6">
        Forward Chaining merupakan salah satu teknik penalaran dalam sistem pakar yang bekerja secara progresif, dari fakta menuju kesimpulan. Proses ini dimulai dengan mengumpulkan data gejala dari pengguna, kemudian membandingkannya dengan basis aturan yang telah ditentukan hingga mencapai kesimpulan diagnosis.
      </p>

      <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
        <span class="bg-purple-200 text-purple-800 rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">1</span>
        Tahapan Forward Chaining:
      </h3>

      <div class="grid md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
          <div class="text-purple-600 mb-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
          </div>
          <h4 class="font-bold text-gray-800 mb-2">Input Gejala</h4>
          <p class="text-gray-600 text-sm">Pengguna memasukkan gejala yang dialami.</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
          <div class="text-purple-600 mb-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
            </svg>
          </div>
          <h4 class="font-bold text-gray-800 mb-2">Pencocokan Aturan</h4>
          <p class="text-gray-600 text-sm">Sistem mencocokkan gejala dengan basis aturan.</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
          <div class="text-purple-600 mb-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
            </svg>
          </div>
          <h4 class="font-bold text-gray-800 mb-2">Inferensi</h4>
          <p class="text-gray-600 text-sm">Sistem menambahkan fakta baru hingga mencapai kesimpulan.</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300">
          <div class="text-purple-600 mb-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
          </div>
          <h4 class="font-bold text-gray-800 mb-2">Hasil Diagnosis</h4>
          <p class="text-gray-600 text-sm">Sistem memberikan hasil akhir berupa jenis penyakit kulit.</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Implementation Section -->
  <div class="bg-gradient-to-br from-white to-indigo-50 rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100">
    <div class="p-8">
      <div class="flex items-center mb-4">
        <div class="bg-indigo-100 p-3 rounded-full mr-4">
          <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">3. Implementasi Sistem Pakar</h2>
      </div>
      <p class="text-gray-600 leading-relaxed mb-6">
        Untuk membangun sistem pakar diagnosa penyakit kulit, diperlukan beberapa komponen utama:
      </p>

      <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:transform hover:-translate-y-1 transition duration-300">
          <div class="text-indigo-600 mb-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
            </svg>
          </div>
          <h4 class="font-bold text-gray-800 mb-2">Basis Pengetahuan</h4>
          <p class="text-gray-600 text-sm">Berisi fakta dan aturan tentang penyakit kulit serta gejala-gejalanya.</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:transform hover:-translate-y-1 transition duration-300">
          <div class="text-indigo-600 mb-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path>
            </svg>
          </div>
          <h4 class="font-bold text-gray-800 mb-2">Mesin Inferensi</h4>
          <p class="text-gray-600 text-sm">Melakukan pencocokan gejala dengan aturan menggunakan Forward Chaining.</p>
        </div>

        <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:transform hover:-translate-y-1 transition duration-300">
          <div class="text-indigo-600 mb-3">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5M7.188 2.239l.777 2.897M5.136 7.965l-2.898-.777M13.95 4.05l-2.122 2.122m-5.657 5.656l-2.12 2.122"></path>
            </svg>
          </div>
          <h4 class="font-bold text-gray-800 mb-2">Antarmuka Pengguna</h4>
          <p class="text-gray-600 text-sm">Sistem interaktif untuk memasukkan gejala dan menerima diagnosa.</p>
        </div>
      </div>

      <h3 class="text-xl font-semibold text-gray-700 mb-4 flex items-center">
        <span class="bg-indigo-200 text-indigo-800 rounded-full w-6 h-6 flex items-center justify-center mr-2 text-sm">2</span>
        Contoh Aturan dalam Sistem:
      </h3>

      <div class="bg-gray-800 rounded-xl p-5 mb-4 overflow-x-auto">
        <pre class="text-green-400 text-sm font-mono">
<span class="text-gray-400">// Rule 1</span>
<span class="text-yellow-300">if</span> (<span class="text-blue-300">kulit_memerah</span> <span class="text-yellow-300">&&</span> <span class="text-blue-300">gatal</span> <span class="text-yellow-300">&&</span> <span class="text-blue-300">bercak_kering</span>) {
    <span class="text-purple-300">diagnosis</span> = <span class="text-green-300">"Eksim"</span>;
}

<span class="text-gray-400">// Rule 2</span>
<span class="text-yellow-300">if</span> (<span class="text-blue-300">kulit_bersisik</span> <span class="text-yellow-300">&&</span> <span class="text-blue-300">berminyak</span> <span class="text-yellow-300">&&</span> <span class="text-blue-300">rambut_rontok</span>) {
    <span class="text-purple-300">diagnosis</span> = <span class="text-green-300">"Dermatitis Seboroik"</span>;
}</pre>
      </div>
    </div>
  </div>

  <!-- Pros and Cons Section -->
  <div class="bg-gradient-to-br from-white to-pink-50 rounded-2xl shadow-lg overflow-hidden mb-8 border border-gray-100">
    <div class="p-8">
      <div class="flex items-center mb-4">
        <div class="bg-pink-100 p-3 rounded-full mr-4">
          <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">4. Keunggulan dan Kelemahan</h2>
      </div>

      <div class="grid md:grid-cols-2 gap-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-green-100">
          <div class="flex items-center mb-4">
            <div class="bg-green-100 p-2 rounded-full mr-3">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700">Keunggulan:</h3>
          </div>
          <ul class="space-y-3">
            <li class="flex items-start">
              <svg class="flex-shrink-0 w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Proses penalaran logis yang mudah diimplementasikan.</span>
            </li>
            <li class="flex items-start">
              <svg class="flex-shrink-0 w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Cocok untuk sistem dengan aturan yang eksplisit dan terstruktur.</span>
            </li>
            <li class="flex items-start">
              <svg class="flex-shrink-0 w-5 h-5 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
              </svg>
              <span class="text-gray-600">Cepat dalam memberikan hasil diagnosis berdasarkan data input.</span>
            </li>
          </ul>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-red-100">
          <div class="flex items-center mb-4">
            <div class="bg-red-100 p-2 rounded-full mr-3">
              <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
            </div>
            <h3 class="text-xl font-semibold text-gray-700">Kelemahan:</h3>
          </div>
          <ul class="space-y-3">
            <li class="flex items-start">
              <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="text-gray-600">Bergantung pada basis aturan yang telah dibuat, kurang fleksibel terhadap kasus baru.</span>
            </li>
            <li class="flex items-start">
              <svg class="flex-shrink-0 w-5 h-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
              </svg>
              <span class="text-gray-600">Tidak mampu menangani ketidakpastian secara langsung seperti metode berbasis probabilistik.</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Conclusion Section -->
  <div class="bg-gradient-to-br from-white to-teal-50 rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="p-8">
      <div class="flex items-center mb-4">
        <div class="bg-teal-100 p-3 rounded-full mr-4">
          <svg class="w-6 h-6 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
          </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-800">5. Kesimpulan</h2>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-sm border border-teal-100">
        <p class="text-gray-600 leading-relaxed">
          Metode <strong class="text-teal-600">Forward Chaining</strong> dalam sistem pakar dapat membantu dalam diagnosis penyakit kulit dengan cara yang sistematis dan berbasis aturan. Dengan pengembangan basis pengetahuan yang lengkap dan akurat, sistem ini dapat menjadi alat bantu yang efektif bagi tenaga medis maupun masyarakat dalam mengenali penyakit kulit sejak dini.
        </p>
      </div>
    </div>
  </div>
</div>