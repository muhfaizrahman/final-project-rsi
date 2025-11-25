<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="flex flex-col lg:flex-row">

    @include('components.sidebar')
    
    <section class="flex-1 flex flex-col">
        @include('components.header-company')
        
        <main class="flex-1 p-8">
            @if(session('success'))
                <div class="p-4 mb-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            
            {{-- Background Photo --}}
            <div class="rounded-lg shadow-xl h-48 sm:h-64 relative overflow-hidden mb-8">
                <!-- Data Background -->
                <img src="{{ asset('storage/' . $profileUser->company->background_photo_url) 
                ?? asset('assets/images/default-background.jpg') }}" alt="Header Background" class="w-full h-full object-cover opacity-100">

                <div class="absolute top-1/2 transform -translate-y-1/2 left-8 sm:left-16 flex items-center">
                    {{-- Profile Photo (Logo) --}}
                    <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-4 border-white shadow-lg overflow-hidden">
                        <!-- Data Logo -->
                        <img src="{{ asset('storage/' . $profileUser->company->profile_photo_url) 
                        ?? asset('assets/images/default-profile-picture.jpg') }}" alt="Profile Photo" class="w-full h-full object-cover">
                    </div>
                </div>
            </div>

            <div class="px-4 sm:px-0">
                <div class="flex items-center justify-between mb-8 space-x-3">
                    <div class="flex flex-col">
                        <!-- Data Nama Perusahaan -->
                        <h1 class="text-2xl font-bold text-black">{{ $profileUser->company?->company_name }}</h1>
                        <p class="text-lg text-black">{{ $profileUser->company?->city }}, {{ $profileUser->company?->country }}</p>
                    </div>
                    <!-- Tombol Edit hanya jika user login == user profile -->
                    @if (auth()->id() == $profileUser->id)
                        <a class="text-white bg-[#7E794B] hover:bg-[#6B6840] px-5 py-2 rounded-full" href="{{ route('editCompanyProfilePage', $profileUser) }}">Edit</a>
                    @endif
                </div>
                
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2 space-y-8">

                        {{-- Short Bio (About) --}}
                        <div class="bg-white p-6 rounded-lg shadow-md space-y-8">
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800 mb-4">Tentang Perusahaan</h2>
                                <p class="text-gray-700 leading-relaxed">
                                    <!-- Data About -->
                                    {{ $profileUser->company?->about ?? 'Belum ada deskripsi perusahaan yang ditambahkan.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Placeholder untuk kolom 3 --}}
                    <div class="lg:col-span-1 space-y-8">
                        {{-- Opsional: Kontak Perusahaan atau Statistik --}}
                        <div class="bg-white p-6 rounded-lg shadow-md sticky top-8">
                            <h2 class="text-xl font-bold text-gray-800 mb-4">Kontak Utama</h2>
                            <p class="text-gray-700">Email: {{ $profileUser->email }}</p>
                            {{-- Anda bisa menambahkan informasi kontak lain jika ada di tabel profile_companies --}}
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
</body>
</html>