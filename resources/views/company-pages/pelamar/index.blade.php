<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body class="min-h-screen p-4 sm:p-8">

    <header class="bg-white p-4 shadow-md flex justify-between items-center rounded-lg max-w-5xl mx-auto mb-8">
        <div class="flex items-center space-x-6">
            <span class="text-xl font-bold text-gray-800">Lunaris</span>
            <nav class="hidden sm:flex space-x-4">
                <a href="#" class="text-gray-600 hover:text-green-600 font-medium">Lowongan</a>
                <a href="#" class="text-gray-600 hover:text-green-600 font-medium">Artikel</a>
                <a href="#" class="text-gray-600 hover:text-green-600 font-medium">Event</a>
            </nav>
        </div>
        <div class="flex space-x-3 text-gray-700">
            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-gray-200 hover:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <button class="w-8 h-8 flex items-center justify-center rounded-full bg-yellow-600 hover:bg-yellow-700 text-white">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </button>
        </div>
    </header>

    <main class="max-w-3xl mx-auto p-4">

        <div class="mb-4">
            <a href="{{ route('companyHomePage') }}" class="text-sm text-gray-600 hover:text-gray-800">← Kembali ke Lowongan</a>
        </div>

        <h1 class="text-xl font-bold text-gray-800 mb-8">Pendaftar Lowongan</h1>
        
        <div class="flex items-start space-x-4 mb-8">
            <div class="w-16 h-16 flex-shrink-0">
                @if($company->logo_url)
                    <img src="{{ asset($company->logo_url) }}" alt="{{ $company->name }}" class="w-full h-full object-cover rounded-lg">
                @else
                    <div class="w-full h-full bg-gray-300 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                @endif
            </div>
            
            <div>
                <p class="text-lg font-bold text-gray-900 leading-tight">Posisi: {{ $job->title }}</p>
                <p class="text-sm text-gray-600">{{ $company->name }}</p>
                <p class="text-sm text-gray-500">{{ $job->city }}, {{ $job->country }} ({{ $job->workMethod->name }})</p>
            </div>
        </div>

        @forelse($applications as $application)
            <div class="bg-white p-6 rounded-xl shadow-lg border border-gray-100 flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 flex items-center justify-center rounded-full bg-gray-300 flex-shrink-0">
                        @if($application->user->profile && $application->user->profile->profile_photo_url)
                            <img src="{{ asset($application->user->profile->profile_photo_url) }}" alt="{{ $application->first_name }}" class="w-full h-full object-cover rounded-full">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        @endif
                    </div>
                    
                    <div>
                        <p class="text-base font-semibold text-gray-900 leading-snug">{{ $application->first_name }} {{ $application->last_name }}</p>
                        @if($application->user->profile)
                            @php
                                $education = $application->user->profile->educations()->latest()->first();
                            @endphp
                            @if($education)
                                <p class="text-sm text-gray-600 leading-snug">{{ $education->degree }} at {{ $education->institution_name }}</p>
                            @else
                                <p class="text-sm text-gray-600 leading-snug">{{ $application->applicant_email }}</p>
                            @endif
                        @else
                            <p class="text-sm text-gray-600 leading-snug">{{ $application->applicant_email }}</p>
                        @endif
                        <a href="#" class="text-xs text-green-700 hover:text-green-500 font-medium mt-1 inline-block">Profile Lunaris</a>
                    </div>
                </div>

                <div class="ml-4 flex-shrink-0">
                    @if($application->cv_url)
                        <a href="{{ asset($application->cv_url) }}" target="_blank" class="w-10 h-10 flex items-center justify-center rounded-lg bg-yellow-700/10 hover:bg-yellow-700/20 text-yellow-800 transition duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </a>
                    @else
                        <div class="w-10 h-10 flex items-center justify-center rounded-lg bg-gray-200 text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                            </svg>
                        </div>
                    @endif
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