<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <main class="p-6">
        
        @if(session('success'))
            <div class="p-4 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="relative h-96 overflow-hidden rounded-lg">
            <img src="{{ asset('assets/images/default_event.png') }}" alt="Sewing Class" class="w-full h-full object-cover">
            
            <div class="absolute inset-0 bg-black/50 p-6 flex flex-col">
                
                <a href="{{ route('eventPage') }}" class="inline-flex items-center text-white text-sm bg-[#7E794B] hover:bg-[#6e6a3f] bg-opacity-50 hover:bg-opacity-70 px-4 py-2 mb-20 rounded-lg transition duration-150 w-fit">
                    <i class="bi bi-arrow-left mr-2"></i> Back
                </a>
                
                <div class="text-white space-y-2">
                    <h1 class="text-4xl font-extrabold tracking-wide">{{ $event->title }}</h1>
                    <p class="text-lg text-gray-200">by {{ $event->company->name }}</p>
                </div>
            </div>
            
            <div class="absolute right-6 top-1/2 transform -translate-y-1/2 bg-white p-6 rounded-xl shadow-2xl space-y-4 w-sm">
                <div>
                    <h3 class="font-bold text-lg text-black">Date and Time</h3>
                    <p class="text-sm text-gray-700">{{ $event->event_datetime->format('H:i a, d M Y') }}</p>
                </div>

                <div>
                    <h3 class="font-bold text-lg text-black">Location</h3>
                    <p class="text-sm text-gray-700 mb-8">{{ $event->location }}</p>
                </div>
                
                @if(Auth::check() && $isRegistered)
                    <button class="w-full mt-4 py-3 bg-gray-500 text-white font-bold rounded-lg cursor-not-allowed" disabled>
                        Registered
                    </button>
                @else
                    <a href="{{ route('eventFormPage', $event) }}" 
                    class="w-full mt-4 py-3 bg-[#27B000] hover:bg-[#1B7A00] text-white font-bold rounded-lg transition duration-150 text-center block">
                        Join Here
                    </a>
                @endif
            </div>
        </div>

        <div class="container mx-auto px-4 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                
                <section class="lg:col-span-2 space-y-6">
                    <div class="text-gray-700 leading-relaxed">
                        <h2 class="text-2xl font-bold text-black mb-2">Deskripsi</h2>
                        <p>{{ $event->description }}</p>
                    </div>
                    
                    <div class="pt-6">
                        <h2 class="text-2xl font-bold mb-2 text-black">How I contact the organizer with any question?</h2>
                        <p class="text-black">Please send your email to <span class="text-[#9D00FF] font-bold hover:underline cursor-pointer">{{ $event->company_email }}</span></p>
                    </div>
                </section>
                
                <aside class="lg:col-span-1 space-y-6 lg:pt-0 pt-6">
                    
                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold mb-3 text-black">Event Location</h3>
                        <p class="">{{ $event->location }}</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-md">
                        <h3 class="text-xl font-bold mb-3 text-black">Time</h3>
                        <p class="text-gray-700">{{ $event->event_datetime->format('H:i a, d M Y') }}</p>
                    </div>

                </aside>
            </div>
        </div>

        <div class="container mx-auto px-4 py-12">
            <h2 class="text-3xl font-bold text-center border-t pt-6 mb-8">See other events</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($relatedEvents as $relatedEvent)
                    <div class="bg-white rounded-lg shadow-lg border border-gray-100 hover:shadow-xl transition duration-300">
                        <img class="w-full h-48 object-cover rounded-lg" src="{{ $relatedEvent->image_url ?? asset('assets/images/default_event.png') }}" alt="{{ $event->title }}">
                        
                        <div class="p-4 flex flex-col h-full">
                            <h3 class="text-xl font-bold mb-2">{{ $relatedEvent->title }}</h3>
                            <p class="text-gray-600 text-sm">{{ $relatedEvent->location }}</p>
                            <p class="text-gray-600 text-sm mb-8">{{ $relatedEvent->event_datetime->format('H:i a, d M Y') }}</p>
                            <a href="{{ route('eventDetailPage', $relatedEvent) }}" 
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
        </div>
        
    </main>
</body>
</html>