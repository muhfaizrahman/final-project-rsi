<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="min-h-screen p-4 sm:p-8">

    <main class="max-w-3xl mx-auto p-4">

        <div class="mb-4">
            <a href="{{ route('companyDashboardPage') }}" class="text-sm text-gray-600 hover:text-gray-800">← Kembali ke Lowongan</a>
        </div>

        <h1 class="text-3xl font-bold text-black mb-8">Pendaftar Lowongan</h1>
        
        <div class="flex items-start space-x-4 mb-8">
            <div class="p-4 sm:p-6 rounded-xl transition duration-300 ease-in-out border border-gray-100 mb-4">
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
                            <p class="text-lg font-semibold truncate">
                                Posisi: {{ $job->title }}
                            </p>
                            <p class="text-sm truncate">
                                {{ $job->company->company_name }}
                            </p>
                            <p class="text-sm truncate">
                                {{ $job->company->city }}, {{ $job->company->country }} (<span class="font-medium">{{ $job->workMethod->name }}</span>)
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

        @forelse($applications as $application)
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="size-20 flex-shrink-0">
                        <img src="{{ $application->user->profile?->profile_photo_url 
                        ? asset('storage/' . $application->user->profile?->profile_photo_url) 
                        : asset('assets/images/default-profile-picture.jpg') }}" alt="User Avatar" class="w-full h-full object-cover rounded-full overflow-hidden border-2 border-gray-300">
                    </div>
                    
                    <div class="flex flex-col space-y-1">
                        <p class="text-base font-bold text-gray-900 leading-snug">{{ $application->user->profile?->full_name }}</p>
                        <p class="text-sm text-gray-600 leading-snug">{{ $application->applicant_email }}</p>
                        <a href="{{ route('profilePage', $application->user) }}" class="text-xs hover:underline font-medium mt-1 inline-block">Profile Pelamar</a>
                    </div>
                </div>

                <div class="ml-4 flex-shrink-0">
                    <a href="{{ route('viewApplicantCV', $application) }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-lg bg-yellow-700/10 hover:bg-yellow-700/20 text-yellow-800 transition duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <div class="bg-white p-8 rounded-xl shadow-lg text-center">
                <p class="text-gray-600">Belum ada pendaftar untuk lowongan ini.</p>
            </div>
        @endforelse

    </main>

</body>
</html>