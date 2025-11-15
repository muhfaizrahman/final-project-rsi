<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        <h1 class="font-bold text-4xl mb-4">Cari pekerjaan apa?</h1>
        <form action="" method="GET" class="border flex justify-between bg-white">
            <input class="flex-grow px-4 py-2" type="text" name="keyword" placeholder="Masukkan kata kunci lowongan..." value="{{ $search ?? '' }}">
            <button type="submit" class="py-2 px-4 bg-gray-200 cursor-pointer">Cari</button>
        </form>

        <main>
            {{-- List Lowongan --}}
            <section>
                @forelse($jobs as $job)
                <div class="border p-4 mb-4 rounded-lg shadow-sm flex items-center justify-between bg-white">
                    <div class="flex space-x-4 items-center">
                        <div class="flex items-center justify-center size-24">
                            <img class="object-cover" src="{{ asset('assets/images/default-experience.png') }}" alt="">
                        </div>
                        <div>
                            <h3 class="font-bold text-lg">{{ $job->title }}</h3>
                            <p class="">{{ $job->company->name }}</p>
                            <span class="text-sm text-gray-600">{{ $job->city }}, {{ $job->country }} ({{ $job->workMethod->name }})</span>
    
                        </div>
                    </div>
                    <i class="bi bi-bookmark text-3xl text-[#7E794B]"></i>
                </div>
                @empty
                    <p>Tidak ada pekerjaan yang ditemukan.</p>
                @endforelse

            </section>

            {{-- Detail Lowongan --}}
            <aside class="border p-4 rounded-lg shadow-sm space-y-4 bg-white">
                <div class="flex items-center justify-center size-24">
                    <img class="object-cover" src="{{ asset('assets/images/default-experience.png') }}" alt="">
                </div>
                <div>
                    <h3 class="font-bold text-lg">{{ $job->title }}</h3>
                    <p class="">{{ $job->company->name }}</p>
                    <span class="text-sm text-gray-600">{{ $job->city }}, {{ $job->country }} ({{ $job->workMethod->name }})</span>
                </div>
                
                <div>
                    <h3>Job Description:</h3>
                    <p>{{ $job->description }}</p>
                </div>

                <div>
                    <h3>Requirements:</h3>
                    <p>{{ $job->requirements }}</p>
                </div>

                <div class="flex font-bold space-x-4">
                    <a href="{{ route('applicationFormPage', $job->id) }}" class="px-8 py-2 bg-[#7E794B] hover:bg-[#6e6a3f] text-white rounded-lg cursor-pointer">Apply</a>
                    <button class="px-8 py-2 border border-[#DADADA] hover:bg-[#DADADA] text-[#7E794B] rounded-lg cursor-pointer">Chat</button>
                </div>
            </aside>
        </main>
    </div>
</body>
</html>