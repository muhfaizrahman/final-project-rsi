<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="icon" href="{{ asset('assets/images/app-logo.png') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 ">
    @include('components.header')
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        
        {{-- Background Photo --}}
        <div class="rounded-lg shadow-xl h-48 sm:h-64 relative overflow-hidden">
            <img src="{{ auth()->user()->profile->background_photo_url 
            ? asset('storage/' . auth()->user()->profile->background_photo_url)
            : asset('assets/images/default-background.jpg') }}" alt="Header Background" class="w-full h-full object-cover opacity-100">

            <div class="absolute top-1/2 transform -translate-y-1/2 left-8 sm:left-16 flex items-center">
                {{-- Profile Photo --}}
                <div class="w-28 h-28 sm:w-36 sm:h-36 rounded-full border-4 border-white shadow-lg overflow-hidden">
                    <img src="{{ auth()->user()->profile->profile_photo_url 
                    ? asset('storage/' . auth()->user()->profile->profile_photo_url) 
                    : asset('assets/images/default-profile-picture.jpg') }}" alt="Profile Photo" class="w-full h-full object-cover">
                </div>
            </div>
        </div>

        <div class="px-4 sm:px-0">
            <div class="flex items-center mb-8 space-x-3">
                <div class="flex flex-col">
                    <h1 class="text-4xl font-bold text-gray-900">{{ auth()->user()->profile->full_name }}</h1>
                    <p class="text-lg text-gray-600">{{ auth()->user()->profile->city }}, {{ auth()->user()->profile->country }}</p>
                </div>
                <a class="text-white bg-[#7E794B] hover:bg-[#6B6840] px-5 py-2 rounded-full" href="{{ route('editProfilePage') }}">Edit</a>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">

                    {{-- Short Bio --}}
                    <div class="bg-white p-6 rounded-lg shadow-md space-y-8">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Short Bio</h2>
                            <p class="text-gray-700 leading-relaxed">
                                {{ auth()->user()->profile->biography }}
                            </p>
                        </div>

                        {{-- Skills --}}
                        <div>
                            <h2 class="text-2xl font-bold text-gray-800 mb-4">Skills</h2>
                            {{-- Skill Item --}}
                            <div class="flex flex-wrap gap-3">
                            @foreach (auth()->user()->profile->skills as $skill)
                                <span class="bg-gray-100 text-black text-sm font-medium px-3 py-1 rounded-xl shadow-md">{{ $skill->name }}</span>
                            @endforeach
                            </div>
                        </div>
                    </div>


                    {{-- Experience --}}
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Experience</h2>
                        @foreach (auth()->user()->profile->experiences as $experience)
                            {{-- Experience Item --}}
                            <div class="flex items-center">
                                <span class="flex items-center justify-center size-24 mr-4 border-2 border-gray-100 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/images/default-experience.png') }}" class="object-cover" alt="Experience Icon">
                                </span>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $experience->experience_title }} - {{ $experience->organization_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($experience->start_date)->year }} - {{ \Carbon\Carbon::parse($experience->end_date)->year }}</p>
                                </div>
                            </div>
                            <p class="text-gray-700 whitespace-pre-line mb-4">
                                {{ $experience->description }}
                            </p>
                            <div class="w-full border border-gray-200 mb-4"></div>
                        @endforeach

                    </div>

                    {{-- Education --}}
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-6">Education</h2>
                        @foreach (auth()->user()->profile->educations as $education)
                            <div class="flex items-center mb-4">
                                <span class="flex items-center justify-center size-16 mr-4 border-2 border-gray-100 rounded-full overflow-hidden">
                                    <img src="{{ asset('assets/images/default-education.png') }}" class="object-cover" alt="Education Icon">
                                </span>
                                <div>
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $education->institution_name }}</h3>
                                    <p class="text-sm text-gray-500">{{ \Carbon\Carbon::parse($education->start_date)->year }} - {{ \Carbon\Carbon::parse($education->end_date)->year }}</p>
                                </div>
                            </div>
                            <div class="w-full border border-gray-200 mb-4"></div>
                        @endforeach
                    </div>

                </div>

                {{-- Contact Person --}}
                <div class="lg:col-span-1 space-y-8">
                    <div class="bg-white p-6 rounded-lg shadow-md sticky top-8">
                        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Contact</h2>
                        <div class="space-y-4">
                            <div class="flex items-center space-x-3">
                                <span class="size-12 rounded-full border-2 border-gray-100 flex items-center justify-center">
                                    <i class="bi bi-envelope text-2xl text-center"></i>
                                </span>
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-medium">Email</span>
                                    <span class="text-gray-800">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="size-12 rounded-full border-2 border-gray-100 flex items-center justify-center">
                                    <i class="bi bi-telephone text-2xl text-center"></i>
                                </span>
                                <div class="flex flex-col">
                                    <span class="text-gray-800 font-medium">Phone</span>
                                    <span class="text-gray-800">{{ auth()->user()->profile->phone ?? '' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>

</body>
</html>