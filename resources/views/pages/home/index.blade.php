<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">

        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="font-bold text-4xl mb-4">Cari pekerjaan apa?</h1>
        
        {{-- FORM PENCARIAN & FILTER --}}
        <form action="{{ url()->current() }}" method="GET" class="space-y-4">
            {{-- Input Keyword --}}
            <div class="border border-gray-300 flex justify-between bg-white rounded-lg shadow-lg overflow-hidden">
                <input class="flex-grow px-4 py-3 focus:outline-none" type="text" name="keyword" placeholder="Masukkan kata kunci lowongan..." value="{{ $search ?? '' }}">
                <button type="submit" class="py-3 px-6 bg-[#7E794B] hover:bg-[#6e6a3f] text-white font-semibold cursor-pointer transition duration-150">Cari</button>
            </div>

            {{-- Filter Dropdowns --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                
                {{-- Filter Work Type --}}
                <select name="work_type_id" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#7E794B] bg-white">
                    <option value="">Semua Tipe Kerja</option>
                    @foreach ($workTypes as $type)
                        <option value="{{ $type->id }}" {{ $filterWorkTypeId == $type->id ? 'selected' : '' }}>
                            {{ $type->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Work Method --}}
                <select name="work_method_id" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#7E794B] bg-white">
                    <option value="">Semua Metode Kerja</option>
                    @foreach ($workMethods as $method)
                        <option value="{{ $method->id }}" {{ $filterWorkMethodId == $method->id ? 'selected' : '' }}>
                            {{ $method->name }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter City --}}
                <select name="city" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#7E794B] bg-white">
                    <option value="">Semua Kota</option>
                    @foreach ($availableCities as $city)
                        <option value="{{ $city }}" {{ $filterCity == $city ? 'selected' : '' }}>
                            {{ $city }}
                        </option>
                    @endforeach
                </select>

                {{-- Filter Industry --}}
                <select name="industry_id" class="w-full p-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-[#7E794B] bg-white">
                    <option value="">Semua Industri</option>
                    @foreach ($industries as $industry)
                        <option value="{{ $industry->id }}" {{ $filterIndustryId == $industry->id ? 'selected' : '' }}>
                            {{ $industry->name }}
                        </option>
                    @endforeach
                </select>

            </div>
        </form>

        <main class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- List Lowongan --}}
            <section class="lg:col-span-2">
                @forelse($jobs as $job)

                    @php
                        // Ambil SEMUA parameter filter aktif untuk dipertahankan saat klik card
                        $currentFilters = [
                            'keyword' => $search,
                            'work_type_id' => $filterWorkTypeId,
                            'work_method_id' => $filterWorkMethodId,
                            'city' => $filterCity,
                            'industry_id' => $filterIndustryId,
                        ];
                        // Tambahkan job_id yang baru diklik ke parameter yang ada
                        $linkParams = array_merge($currentFilters, ['job_id' => $job->id]);

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
                            <form action="{{ route('toggleBookmark', $job->id) }}" method="POST" class="flex-shrink-0">
                                @csrf
                                <button type="submit" class="p-2 cursor-pointer rounded-lg hover:bg-gray-100 transition duration-150 focus:outline-none z-10">
                                    
                                    {{-- Logika untuk menentukan apakah icon terisi atau tidak (misalnya $job->isBookmarked) --}}
                                    @if(Auth::check() && Auth::user()->isBookmarked($job->id))
                                        <i id="bookmark-icon-{{ $job->id }}" class="bi bi-bookmark-fill text-2xl text-[#7E794B]"></i>
                                    @else
                                        <i id="bookmark-icon-{{ $job->id }}" class="bi bi-bookmark text-2xl text-[#7E794B]"></i>
                                    @endif
                                    
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