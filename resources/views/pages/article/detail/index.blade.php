<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="container mx-auto px-4 py-12 max-w-6xl">

        <div class="mb-8 grid grid-cols-4 gap-8">
            <h1 class="text-4xl font-extrabold mb-2 text-black col-span-3">{{ $article->title }}</h1>
            <div class="flex space-y-4 flex-col col-span-1 border-l-2 px-4">
                <div class="flex flex-col">
                    <span><strong>Date:</strong></span>
                    <span>{{ $article->created_at->format('d F Y') }}</span>
                </div>
                <div class="flex flex-col">
                    <span><strong>Category:</strong></span>
                    <span> {{ $article->category->name ?? 'Uncategorized' }}</span>
                </div>
            </div>
        </div>

        <div class="w-full h-[550px] rounded-xl shadow-lg mb-6 overflow-hidden flex items-center justify-center">
            <img src="{{ $article->image_thumbnail_url ?? asset('assets/images/default_article.png') }}" alt="{{ $article->title }}" class="w-full object-cover">
        </div>

        <div class="grid grid-cols-4 gap-8">
            
            {{-- Article Content --}}
            <div class="lg:col-span-3 space-y-8">
                <div class="prose max-w-none leading-relaxed">
                    <p>{{ $article->content }}</p>
                </div>
            </div>

            {{-- Author --}}
            <aside class="lg:col-span-1">
                <div class="px-4 border-l-2">
                    <h3 class="text-xl font-bold mb-1">Author</h3>
                    <h4 class="text-lunaris-green font-semibold mb-3">{{ $article->author }}</h4>
                    <p class="text-sm">{{ $article->author_bio }}</p>
                </div>
            </aside>
            
            {{-- Coment Section --}}
            <div class="col-span-4 pt-8 border-t-2">
                <h2 class="text-2xl font-bold mb-4">Comments</h2>
                
                <form action="{{ route('storeComment', $article) }}" method="POST" class="border border-gray-300 rounded-lg">
                    @csrf
                    <div class="flex items-center">
                        <input type="text" name="content" placeholder="Ketik pesan Anda..."  value="{{ old('content') }}"
                            class="flex-1 p-3 rounded-lg focus:ring-[#7E794B] focus:border-[#7E794B]" required>
                        <button type="submit" class="p-3 hover:bg-white text-white rounded-lg transition duration-150 cursor-pointer">
                            <i class="bi bi-send-fill text-lg text-[#7E794B]"></i>
                        </button>
                    </div>
                    @error('content')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </form>

                {{-- Existing Comment --}}
                <div class="space-y-4 mt-8">
                    @forelse($comments as $comment)
                        <div id="comment-container-{{ $comment->id }}" class="relative group border-b border-gray-100 pb-3">
                            
                            <!-- Isi Komentar (Displayed by default) -->
                            <div id="comment-display-{{ $comment->id }}">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="font-semibold text">{{ $comment->user->profile->full_name }}</p>
                                        <p class="mt-1 text-sm">{{ $comment->content }}</p>
                                    </div>
                                    
                                    <span class="text-xs text-gray-400 flex-shrink-0 ml-4">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                            </div>

                            <!-- Form Edit (Hidden by default, hanya muncul jika tombol Edit ditekan) -->
                            <div id="comment-edit-form-{{ $comment->id }}" class="hidden mt-2 mb-8">
                                <form action="{{ route('updateComment', $comment) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <textarea name="content" rows="3" class="w-full p-2 border border-gray-300 rounded-lg focus:ring-gray-500 text-sm" required>{{ $comment->content }}</textarea>
                                    <div class="flex justify-end space-x-2 mt-2">
                                        <button type="submit" class="bg-[#7E794B] hover:bg-[#6e6a3f] text-white px-3 py-1 text-sm rounded-md transition cursor-pointer">Simpan</button>
                                        <button type="button" onclick="toggleEdit({{ $comment->id }})" class="bg-gray-300 text-gray-800 px-3 py-1 text-sm rounded-md hover:bg-gray-400 transition cursor-pointer">Batal</button>
                                    </div>
                                </form>
                            </div>

                            <!-- Tombol Aksi (Edit/Hapus) - Hanya untuk pemilik komentar -->
                            @if(Auth::id() === $comment->user_id)
                                <div class="absolute right-0 bottom-3 flex space-x-1 opacity-0 group-hover:opacity-100 transition duration-150">
                                    <!-- Tombol Edit -->
                                    <button onclick="toggleEdit({{ $comment->id }})" title="Edit Komentar" class="text-gray-500 hover:text-[#7E794B] p-1 text-sm cursor-pointer">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    
                                    <!-- Form Hapus -->
                                    <form action="{{ route('deleteComment', $comment) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus komentar ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" title="Hapus Komentar" class="text-gray-500 hover:text-red-500 p-1 text-sm cursor-pointer">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endif

                        </div>
                    @empty
                        <p class="text-gray-500">Belum ada komentar.</p>
                    @endforelse
                </div>
            </div>
            
            
        </div>
        
        {{-- Related Content --}}
        <div class="mt-16 border-t-2 pt-8">
            <h2 class="text-3xl font-bold text-center mb-8">Related Contents</h2>
            <div class="flex flex-wrap justify-center gap-6">
                @forelse($relatedArticles as $relatedArticle)
                    <a href="{{ route('showArticle', $relatedArticle) }}" class="relative rounded-lg shadow-md overflow-hidden w-full sm:w-64 block group">
                        <img class="w-full object-cover transform group-hover:scale-105 transition duration-300" src="{{ $relatedArticle->image_thumbnail_url ?? asset('assets/images/default_article.png') }}" alt="{{ $relatedArticle->title }}">
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/50 to-transparent p-4 flex flex-col justify-end text-white">
                            <p class="line-clamp-2">{{ $relatedArticle->title }}</p>
                        </div>
                    </a>
                @empty
                    <p class="text-gray-500">Tidak ada artikel terkait lainnya dalam kategori yang sama.</p>
                @endforelse
            </div>
        </div>

    </div>

<script>
    function toggleEdit(commentId) {
        const displayDiv = document.getElementById(`comment-display-${commentId}`);
        const editForm = document.getElementById(`comment-edit-form-${commentId}`);
        
        if (displayDiv && editForm) {
            displayDiv.classList.toggle('hidden');
            editForm.classList.toggle('hidden');
            
            if (!editForm.classList.contains('hidden')) {
                editForm.querySelector('textarea').focus();
            }
        }
    }
</script>
</body>
</html>