<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="flex flex-col lg:flex-row">

    @include('components.sidebar')
    
    <section class="flex-1 flex flex-col">
        @include('components.header-company')
        
        <main class="flex-1 p-8 main-content">
             @if(session('success'))
                <div class="p-4 mb-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-3xl font-bold text-black mb-4">
                Manajemen Lowongan
            </h2>
            
            @forelse ($jobs as $job)
                <div class="job-card bg-white p-4 sm:p-6 rounded-xl shadow-lg hover:shadow-xl transition duration-300 ease-in-out border border-gray-100 mb-4">
                    <div class="flex items-center justify-between space-x-4">
                        
                        <!-- Detail Pekerjaan -->
                        <div class="flex items-center space-x-4 flex-1 min-w-0">
                            <!-- Logo Perusahaan (Diganti dengan placeholder/mock logo) -->
                            <div class="size-20 flex-shrink-0">
                                <img src="{{ auth()->user()->company?->profile_photo_url 
                                ? asset('storage/' . auth()->user()->company->profile_photo_url) 
                                : asset('assets/images/default-profile-picture.jpg') }}" alt="User Avatar" class="rounded-full object-cover border-2 border-gray-300">
                            </div>
        
                            <!-- Judul dan Lokasi -->
                            <div class="flex-1 overflow-hidden">
                                <p class="text-lg font-semibold text-gray-900 truncate">
                                    Posisi: {{ $job->title }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $job->company->company_name }}
                                </p>
                                <p class="text-sm text-gray-500 truncate">
                                    {{ $job->company->city }}, {{ $job->company->country }} (<span class="font-medium text-gray-600">{{ $job->workMethod->name }}</span>)
                                </p>
                            </div>
                        </div>
        
                        <!-- Aksi dan Status -->
                        <div class="flex items-center space-x-6 flex-shrink-0">
                            <!-- Tombol Lihat Pendaftar -->
                            <a href="{{ route('companyApplicantsPage', ['job' => $job->id]) }}" class="text-sm font-medium hover:underline">
                                Lihat pendaftar
                            </a>
        
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
            @empty
                <p>Belum ada lowongan yang dibuat</p>
            @endforelse
    
        </main>
    </section>

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