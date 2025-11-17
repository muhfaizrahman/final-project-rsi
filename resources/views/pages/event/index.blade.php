<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="max-w-4xl mx-auto py-4">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if(session('warning'))
            <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('warning') }}</span>
            </div>
        @endif
    </div>
    <div class="relative">
        <div class="w-full flex justify-center items-center mt-4 rounded-lg overflow-hidden">
            <img src="{{ asset('assets/images/event-bg.png') }}" alt="event background" class="object-cover rounded-lg">
        </div>
        <div class="absolute inset-0 bg-opacity-40 flex flex-col items-center justify-center p-4">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-white text-center mb-8 tracking-wide">
                EMPOWER YOUR CAREER <br> BREAK THE BIAS
            </h1>
            
            <form action="{{ route('eventPage') }}" method="GET" class="w-full max-w-lg">
                <div class="relative">
                    <input type="search" name="search" value="{{ $search }}" placeholder="Search event here"
                        class="w-full bg-white text-black py-3 pl-5 pr-12 border border-gray-300 rounded-lg shadow-lg focus:ring-[#7E794B] focus:border-[#7E794B]">
                    <button type="submit" class="absolute right-0 top-0 mt-3 mr-4 text-gray-500 hover:text-[#7E794B]">
                        <i class="bi bi-search text-xl"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8">  
        <h2 class="text-3xl font-bold text-center mb-8">Featured Events</h2>

        {{-- Events Card --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($events as $event)
                <div class="bg-white rounded-lg shadow-lg border border-gray-100 hover:shadow-xl transition duration-300">
                    <img class="w-full h-48 object-cover rounded-lg" src="{{ $event->image_url ?? asset('assets/images/default_event.png') }}" alt="{{ $event->title }}">
                    
                    <div class="p-4 flex flex-col h-full">
                        <h3 class="text-xl font-bold mb-2">{{ $event->title }}</h3>
                        <p class="text-gray-600 text-sm">{{ $event->location }}</p>
                        <p class="text-gray-600 text-sm mb-8">{{ $event->event_datetime->format('H:i a, d M Y') }}</p>
                        <a href="{{ route('eventDetailPage', $event) }}" 
                        class="w-full block text-center mt-2 py-2 border border-[#7E794B] rounded-md text-[#7E794B] hover:text-white hover:bg-[#7E794B] transition duration-150">
                            Register
                        </a>
                    </div>
                </div>
            @empty
                <div class="lg:col-span-3 text-center py-10 text-gray-500">
                    Tidak ada event yang ditemukan.
                </div>
            @endforelse
        </div>
        
        <div class="mt-8 justify-center text-black items-center font-semibold">
            {{ $events->links() }}
        </div>
    </div>
</body>
</html>