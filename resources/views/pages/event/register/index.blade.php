<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="container mx-auto px-4 py-12 max-w-lg">
        <h1 class="text-3xl font-bold mb-6 text-center">Registrasi Event</h1>
        
        <div class="bg-white p-6 rounded-lg shadow-lg mb-8 border-l-4 border-[#7E794B]">
            <h2 class="text-2xl font-semibold mb-1">{{ $event->title }}</h2>
            <p class="text-gray-700 mb-1">{{ $event->company->name ?? 'Penyelenggara' }}</p>
            <p class="text-sm text-gray-500">{{ $event->location }} | {{ $event->event_datetime->format('H:i a, d M Y') }}</p>
        </div>

        <form action="{{ route('storeEventRegistration', $event) }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg space-y-5">
            @csrf
            @error('registration')
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ $message }}</span>
                </div>
            @enderror

            <div>
                <label for="full_name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" id="full_name" name="full_name" 
                    value="{{ old('full_name', $user->name ?? '') }}" 
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-[#7E794B] focus:border-[#7E794B]" required>
                @error('full_name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone_number" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                <input type="tel" id="phone_number" name="phone_number" 
                    value="{{ old('phone_number') }}" 
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-[#7E794B] focus:border-[#7E794B]" required>
                @error('phone_number')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" 
                    value="{{ old('email', $user->email ?? '') }}" 
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-[#7E794B] focus:border-[#7E794B]" required>
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            
            <button type="submit" 
                    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-lg font-medium text-white bg-[#7E794B] hover:bg-[#6e6a3f] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#7E794B] transition duration-150">
                Daftar Sekarang
            </button>
            
        </form>
    </div>
</body>
</html>