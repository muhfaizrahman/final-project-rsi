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
                                <form id="toggle-form-{{ $job->id }}" action="{{ route('toggleStatus', $job) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <!-- Input Hidden untuk mengirim status yang dituju (true/false) -->
                                    <input type="hidden" name="is_active" value="{{ $job->is_active ? 0 : 1 }}">

                                    <label for="toggle-job-{{ $job->id }}" class="relative inline-flex items-center cursor-pointer">
                                        <!-- Input Checkbox UI -->
                                        <!-- Tambahkan status CHECKED berdasarkan $job->is_active -->
                                        <input type="checkbox" 
                                            value="1" 
                                            id="toggle-job-{{ $job->id }}" 
                                            class="sr-only peer" 
                                            {{ $job->is_active ? 'checked' : '' }} 
                                            onchange="document.getElementById('toggle-form-{{ $job->id }}').submit()">
                                        
                                        <!-- Track (Background) - Sesuaikan kelas Tailwind untuk warna aktif/non-aktif -->
                                        <div class="w-11 h-6 bg-red-400 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-green-600"></div>
                                    </label>
                                </form>
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
        function toggleJobStatus(element) {
            const isChecked = element.checked;
            console.log(`Lowongan diubah status menjadi: ${isChecked ? 'Aktif' : 'Non-aktif'}`);
        }
    </script>
</body>
</html>