<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="max-w-6xl mx-auto py-8 px-4 sm:px-6 lg:px-8 space-y-8">
        <h1 class="text-4xl font-bold mb-4">Chatting</h1>
        
        <main class="grid grid-cols-1 lg:grid-cols-3 gap-8 h-[70vh]">
            
            <div class="lg:col-span-1 space-y-4 pr-2">
                @forelse($threads as $threadItem)
                    @php
                        $isSelected = $selectedThread && $selectedThread->id === $threadItem->id;
                        $bgColor = $isSelected ? 'bg-white shadow-md ring-2 ring-[#7E794B]' : 'bg-white hover:bg-gray-50 shadow-sm';
                        $latestMessage = $threadItem->messages->last();
                    @endphp
                
                    <a href="{{ route('showDetailChat', $threadItem) }}" class="block p-4 rounded-xl border border-gray-200 transition duration-150 {{ $bgColor }}">
                        <div class="flex items-center space-x-4">
                            <div class="flex-shrink-0 size-12 bg-gray-300 rounded-full flex items-center justify-center">
                                <i class="bi bi-person text-xl text-gray-600"></i>
                            </div>
                            <div>
                                <p class="font-semibold text-lg">{{ $threadItem->company->name ?? 'Perusahaan Tidak Dikenal' }}</p>
                                <p class="text-sm text-gray-600 truncate max-w-[200px]">
                                    {{ $latestMessage ? Str::limit($latestMessage->content, 30) : 'Belum ada pesan.' }}
                                </p>
                            </div>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500 p-4 bg-white rounded-xl shadow-sm">Belum ada percakapan. Mulai chat dari halaman lowongan.</p>
                @endforelse
            </div>
            
            <div class="lg:col-span-2 bg-white rounded-xl shadow-xl flex flex-col border border-gray-200 h-[530px] mb-8">
                @if($selectedThread)
                    <div class="p-4 border-b border-gray-200 flex items-center space-x-4">
                        <div class="flex-shrink-0 size-10 bg-gray-300 rounded-full flex items-center justify-center">
                            <i class="bi bi-person text-lg text-gray-600"></i>
                        </div>
                        <h2 class="font-bold text-xl">{{ $selectedThread->company->name ?? 'Perusahaan Tidak Dikenal' }}</h2>
                    </div>
                    
                    <div class="flex-1 p-4 space-y-4 overflow-y-auto custom-scrollbar">
                        @forelse($messages as $message)
                            @php
                                // Tentukan apakah pesan dikirim oleh Pelamar atau Perusahaan
                                $isApplicant = $message->sender_type === 'applicant';
                                $alignment = $isApplicant ? 'justify-end' : 'justify-start';
                                $bubbleClasses = $isApplicant 
                                    ? 'bg-[#7E794B] text-white rounded-br-none' 
                                    : 'bg-gray-100 text-gray-800 rounded-tl-none';
                            @endphp
                            
                            <div class="flex {{ $alignment }}">
                                <div class="max-w-xs sm:max-w-md lg:max-w-lg p-3 rounded-xl shadow {{ $bubbleClasses }}">
                                    <p class="text-sm">{{ $message->content }}</p>
                                    <span class="text-xs opacity-75 block text-right mt-1">
                                        {{ $message->created_at->format('H:i') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-gray-500 py-10">
                                Mulai percakapan dengan mengirim pesan pertama.
                            </div>
                        @endforelse
                    </div>
                    
                    <form action="{{ route('sendChat', $selectedThread) }}" method="POST" class="p-4 border-t border-gray-200">
                        @csrf
                        <div class="flex items-center space-x-3">
                            <input type="text" name="content" placeholder="Ketik pesan Anda..." 
                                class="flex-1 p-3 border border-gray-300 rounded-lg focus:ring-[#7E794B] focus:border-[#7E794B]" required>
                            <button type="submit" class="p-3 hover:bg-gray-100 text-white rounded-lg transition duration-150 cursor-pointer">
                                <i class="bi bi-send-fill text-lg text-[#7E794B]"></i>
                            </button>
                        </div>
                        @error('content')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </form>
                @else
                    <div class="flex items-center justify-center h-full text-gray-500">
                        <p>Pilih salah satu percakapan dari daftar di sebelah kiri.</p>
                    </div>
                @endif
            </div>
            
        </main>
    </div>
</body>
</html>