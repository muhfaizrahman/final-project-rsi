<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="flex flex-col lg:flex-row">

    @include('components.sidebar')
    
    <section class="flex-1 flex flex-col">
        @include('components.header-company')
        
        <main class="flex-1 p-8  main-content">
            <h2 class="text-3xl font-bold text-black mb-4">
                Manajemen Lowongan
            </h2>
            <!-- Start: Template Card Lowongan untuk Foreach -->
            <!-- Anda hanya perlu mengulang block div ini menggunakan foreach di Laravel -->
            <div class="job-card bg-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out border border-gray-100 mb-4">
                <div class="flex items-center justify-between space-x-4">
                    
                    <!-- Detail Pekerjaan -->
                    <div class="flex items-center space-x-4 flex-1 min-w-0">
                        <!-- Logo Perusahaan (Diganti dengan placeholder/mock logo) -->
                        <div class="w-12 h-12 flex-shrink-0">
                            <!-- Menggunakan SVG sederhana untuk simulasi logo McDonald's -->
                            <svg class="w-full h-full text-yellow-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-5 8h10c0 2.21-1.79 4-4 4s-4-1.79-4-4zm4 6c-3.866 0-7-3.134-7-7h2c0 2.76 2.24 5 5 5s5-2.24 5-5h2c0 3.866-3.134 7-7 7z"/>
                            </svg>
                        </div>
    
                        <!-- Judul dan Lokasi -->
                        <div class="flex-1 overflow-hidden">
                            <p class="text-lg font-semibold text-gray-900 truncate">
                                Posisi: Financial Analyst
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                McDonald's
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                Malang, Indonesia (<span class="font-medium text-gray-600">on-site</span>)
                            </p>
                        </div>
                    </div>
    
                    <!-- Aksi dan Status -->
                    <div class="flex items-center space-x-6 flex-shrink-0">
                        <!-- Tombol Lihat Pendaftar -->
                        <button class="text-sm font-medium text-blue-600 hover:text-blue-800 transition duration-150 focus:outline-none">
                            Lihat pendaftar
                        </button>
    
                        <!-- Toggle Lowongan (Aktif/Non-aktif) -->
                        <div class="flex items-center">
                            <label for="toggle-job-1" class="relative inline-flex items-center cursor-pointer">
                                <!-- Input Checkbox -->
                                <input type="checkbox" value="" id="toggle-job-1" class="sr-only peer" checked onclick="toggleJobStatus(this)">
                                
                                <!-- Track (Background) -->
                                <div class="w-11 h-6 bg-inactive-red peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-active-green"></div>
                                
                                <!-- Anda bisa menambahkan label status di sini jika mau, tapi saya biarkan kosong seperti gambar -->
                                <!-- <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Aktif</span> -->
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End: Template Card Lowongan untuk Foreach -->
    
    
            <!-- Contoh Beberapa Card Lowongan (Hanya untuk ilustrasi) -->
            <!-- Di Laravel, Anda akan mengganti ini dengan loop Anda -->
            <div class="job-card bg-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out border border-gray-100 mb-4">
                <div class="flex items-center justify-between space-x-4">
                    <div class="flex items-center space-x-4 flex-1 min-w-0">
                        <div class="w-12 h-12 flex-shrink-0">
                            <svg class="w-full h-full text-yellow-500" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.477 2 2 6.477 2 12s4.477 10 10 10 10-4.477 10-10S17.523 2 12 2zm-5 8h10c0 2.21-1.79 4-4 4s-4-1.79-4-4zm4 6c-3.866 0-7-3.134-7-7h2c0 2.76 2.24 5 5 5s5-2.24 5-5h2c0 3.866-3.134 7-7 7z"/></svg>
                        </div>
                        <div class="flex-1 overflow-hidden">
                            <p class="text-lg font-semibold text-gray-900 truncate">
                                Posisi: Graphic Designer
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                Tokopedia
                            </p>
                            <p class="text-sm text-gray-500 truncate">
                                Jakarta, Indonesia (<span class="font-medium text-gray-600">remote</span>)
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-6 flex-shrink-0">
                        <button class="text-sm font-medium text-blue-600 hover:text-blue-800 transition duration-150 focus:outline-none">
                            Lihat pendaftar
                        </button>
                        <div class="flex items-center">
                            <label for="toggle-job-2" class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" value="" id="toggle-job-2" class="sr-only peer" onclick="toggleJobStatus(this)">
                                <div class="w-11 h-6 bg-inactive-red peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-red-300 dark:peer-focus:ring-red-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-active-green"></div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Akhir Contoh -->
            
    
        </main>
    </section>
    <!-- Konten Utama (Kanan) -->

    <script>
        // toggleJobStatus
        function toggleJobStatus(element) {
            const isChecked = element.checked;
            console.log(`Lowongan diubah status menjadi: ${isChecked ? 'Aktif' : 'Non-aktif'}`);
            // Di Laravel, Anda akan mengirim permintaan AJAX di sini untuk memperbarui database
        }

        // Logika untuk menampilkan/menyembunyikan sidebar di mobile
        const sidebar = document.getElementById('sidebar');

        function toggleSidebar() {
            if (sidebar.classList.contains('-translate-x-full')) {
                sidebar.classList.remove('-translate-x-full');
            } else {
                sidebar.classList.add('-translate-x-full');
            }
        }

        // Sembunyikan sidebar overlay jika mengklik di luar sidebar (untuk mobile)
        document.addEventListener('click', function(event) {
            const isClickInside = sidebar.contains(event.target) || event.target.closest('.lg\:hidden');
            
            if (!isClickInside && window.innerWidth < 1024 && !sidebar.classList.contains('-translate-x-full')) {
                // Di mobile, jika sidebar terbuka dan klik di luar, tutup sidebar
                if(event.target.tagName !== 'BUTTON' && event.target.closest('.lg\\:hidden') === null) {
                     sidebar.classList.add('-translate-x-full');
                }
            }
        });
        
        // Atur posisi konten utama agar tidak tertutup sidebar di mobile
        window.addEventListener('resize', function() {
            if (window.innerWidth >= 1024) {
                sidebar.classList.remove('-translate-x-full');
            }
        });
    </script>
</body>
</html>