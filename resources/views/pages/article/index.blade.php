<!DOCTYPE html>
<html lang="en">
@include('components.head')
<body>
    @include('components.header')
    <div class="container mx-auto px-42 py-12">
    
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-12 items-center">
            
            {{-- Main Image --}}
            @if($featuredArticle)
            <a href="{{ route('showArticle', $featuredArticle) }}" class="relative block h-96 overflow-hidden rounded-xl shadow-lg group">
                <img src="{{ $featuredArticle->image_thumbnail_url ?? asset('assets/images/default_article.png') }}" alt="{{ $featuredArticle->title }}" 
                    class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                <div class="absolute inset-0 bg-gradient-to-t from-black via-black/40 to-transparent p-6 flex flex-col justify-end">
                    <h2 class="text-2xl font-bold text-white mb-2">{{ $featuredArticle->title }}</h2>
                    <p class="text-sm text-gray-200 line-clamp-2">{{ $featuredArticle->content }}</p>
                    <div class="flex justify-end">
                        <span class="mt-3 text-xs text-white font-semibold border border-white px-4 py-2 rounded-lg w-fit hover:bg-white hover:text-black transition">Read</span>
                    </div>
                </div>
            </a>
            @endif

            {{-- Side Top Image --}}
            <div class="space-y-6">
                @forelse($sidebarArticles as $sidebarArticle)
                <a href="{{ route('showArticle', $sidebarArticle) }}" class="relative block h-44 overflow-hidden rounded-xl shadow-lg group">
                    <img src="{{ $sidebarArticle->image_thumbnail_url ?? asset('assets/images/default_article.png') }}" alt="{{ $sidebarArticle->title }}" 
                        class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                    <div class="absolute inset-0 bg-black/40 bg-opacity-40 p-4 flex flex-col justify-end">
                        <h3 class="text-lg font-bold text-white">{{ $sidebarArticle->title }}</h3>
                    </div>
                </a>
                @empty
                <div class="h-44 flex items-center justify-center bg-gray-100 rounded-xl">No sidebar articles.</div>
                @endforelse
            </div>
        </div>
        
        {{-- Latest Insights --}}
        <h2 class="text-3xl font-bold mb-6">Latest Insights</h2>

        <div class="grid grid-cols-1 gap-8">
            @forelse($latestArticles as $article)
                <div class="flex space-x-6">
                    <div class="flex-shrink-0 h-48 rounded-lg overflow-hidden w-1/3 border border-gray-100 shadow-md flex items-center justify-center">
                        <img src="{{ $article->image_thumbnail_url ?? asset('assets/images/default_article.png') }}" alt="{{ $article->title }}" class="w-full object-cover transform hover:scale-105 transition duration-300">
                    </div>
                    <div class="p-6 flex flex-col justify-between w-2/3 bg-white rounded-lg border border-gray-100 shadow-md ">
                        <div>
                            <h3 class="text-xl font-bold mb-3">{{ $article->title }}</h3>
                            <p class="text-gray-600 mb-4 line-clamp-3">{{ $article->content }}</p>
                        </div>
                        <div class="flex justify-end">
                            <a href="{{ route('showArticle', $article) }}" class="text-sm text-lunaris-green font-semibold hover:underline w-fit border border-gray-300 px-3 py-1 rounded-md hover:bg-gray-100 transition">Read</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="lg:col-span-2 text-gray-500">Tidak ada artikel terbaru.</p>
            @endforelse
        </div>
        
        <div class="mt-8 justify-center text-black items-center font-semibold">
            {{ $latestArticles->links() }}
        </div>
        
    </div>
</body>
</html>