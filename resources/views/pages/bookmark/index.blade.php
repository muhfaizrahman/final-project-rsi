<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        <h1 class="font-bold text-4xl mb-4">Lowongan Tersimpan</h1>
        
        <main class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- List Lowongan --}}
            <section class="lg:col-span-2">
                @forelse($jobs as $job)

                    @php
                        $linkParams = ['job_id' => $job->id];
                        $isSelected = (isset($selectedJobId) && $selectedJobId == $job->id);
                        $borderClass = $isSelected ? 'border-[#7E794B] ring-2 ring-[#7E794B]' : 'border-gray-200 hover:border-[#7E794B]';
                    @endphp

                    <a href="{{ url()->current() . '?' . http_build_query($linkParams) }}" class="block transition duration-150 ease-in-out">

                    <div class="relative border {{ $borderClass }} p-4 mb-4 rounded-lg shadow-sm flex items-center justify-between bg-white cursor-pointer">
                            <div class="flex space-x-4 items-center">
                                <div class="flex items-center justify-center size-24">
                                    <img class="object-cover rounded-full overflow-hidden border-2 border-gray-100" src="{{ $job->company->profile_photo_url ?? asset('assets/images/default-profile-picture.jpg') }}" alt="">
                                </div>
                                <div>
                                    <h3 class="font-bold text-lg">{{ $job->title }}</h3>
                                    <p class="">{{ $job->company->name }}</p>
                                    <span class="text-sm text-gray-600">{{ $job->city }}, {{ $job->country }} ({{ $job->workMethod->name }})</span>
            
                                </div>
                            </div>
                            {{-- Bookmark Toggle --}}
                            <form action="{{ route('toggleBookmark', $job->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button type="submit"
                                        class="p-2 cursor-pointer rounded-lg hover:bg-gray-100 transition duration-150 focus:outline-none z-10">
                                    <i class="bi bi-bookmark-fill text-2xl text-[#7E794B]"></i>
                                </button>
                            </form>
                    </div>
                </a>
                @empty
                    <p class="text-gray-600 p-4 bg-white rounded-lg shadow-sm">Tidak ada pekerjaan yang ditemukan.</p>
                @endforelse
            </section>
            
            {{-- Detail Lowongan --}}
            <aside class="lg:col-span-1 sticky top-8 h-fit">
                @if(isset($selectedJob) && $selectedJob)
                <div class="border border-gray-300 p-6 rounded-lg shadow-lg space-y-6 bg-white">
                    {{-- Menggunakan data dari $selectedJob --}}
                    
                    <div>
                        <h3 class="font-bold text-xl">{{ $selectedJob->title }}</h3>
                        <p class="text-gray-700">{{ $selectedJob->company->name }}</p>
                        <span class="text-sm text-gray-500">{{ $selectedJob->city }}, {{ $selectedJob->country }} ({{ $selectedJob->workMethod->name }})</span>
                    </div>
                    
                    <div>
                        <h3>Job Description:</h3>
                        <p>{{ $selectedJob->description }}</p>
                    </div>

                    <div>
                        <h3>Requirements:</h3>
                        <p>{{ $selectedJob->requirements }}</p>
                    </div>

                    <div class="flex font-bold space-x-4 pt-4">
                        <a href="{{ route('applicationFormPage', $selectedJob->id) }}" class="flex-1 text-center px-4 py-3 bg-[#7E794B] hover:bg-[#6e6a3f] text-white rounded-lg transition duration-150">Apply Now</a>
                    </div>
                </div>
                @else
                <div class="p-6 text-center text-gray-500 bg-white rounded-lg shadow-lg">
                    <p>Klik salah satu lowongan di sebelah kiri untuk melihat detailnya.</p>
                </div>
                @endif
            </aside>
        </main>
    </div>
</body>
</html>