@extends('layouts.public')

@section('title', $newsItem['title'] . ' — CrisisHub News')
@section('description', $newsItem['summary'])

@section('content')
<!-- HERO SECTION -->
<section class="relative pt-32 pb-16 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Breadcrumbs -->
        <nav class="flex mb-8 text-sm fade-up">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('home') }}" class="text-slate-500 hover:text-red-600 dark:hover:text-red-400 transition-colors">Beranda</a>
                </li>
                <li>
                    <span class="text-slate-400 mx-2">/</span>
                </li>
                <li>
                    <a href="{{ route('news.index') }}" class="text-slate-500 hover:text-red-600 dark:hover:text-red-400 transition-colors">Berita</a>
                </li>
                <li>
                    <span class="text-slate-400 mx-2">/</span>
                </li>
                <li class="text-slate-900 dark:text-white font-medium truncate max-w-xs" aria-current="page">
                    {{ $newsItem['title'] }}
                </li>
            </ol>
        </nav>

        <div class="fade-up" style="animation-delay: 0.1s">
            <span class="inline-block px-3 py-1 bg-{{ $newsItem['color'] }}-100 dark:bg-{{ $newsItem['color'] }}-900/30 text-{{ $newsItem['color'] }}-600 dark:text-{{ $newsItem['color'] }}-400 text-xs font-bold rounded-full mb-4">
                {{ $newsItem['tag'] }}
            </span>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-slate-900 dark:text-white leading-tight mb-6">
                {{ $newsItem['title'] }}
            </h1>
            
            <div class="flex flex-wrap items-center gap-6 text-sm text-slate-500 dark:text-slate-400 border-b border-slate-200 dark:border-white/10 pb-6 mb-8">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                        <i class="fas fa-user text-slate-400 dark:text-slate-300 text-xs"></i>
                    </div>
                    <span class="font-medium text-slate-700 dark:text-slate-300">{{ $newsItem['author'] }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-calendar-alt"></i> {{ $newsItem['date'] }}, {{ $newsItem['time'] }}
                </div>
                <div class="flex items-center gap-2">
                    <i class="fas fa-clock"></i> Estimasi {{ $newsItem['read'] }}
                </div>
                
                <!-- Share Buttons -->
                <div class="ml-auto flex gap-3">
                    <button class="w-8 h-8 rounded-full bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-600 dark:text-blue-400 flex items-center justify-center transition-colors">
                        <i class="fab fa-twitter"></i>
                    </button>
                    <button class="w-8 h-8 rounded-full bg-blue-100 hover:bg-blue-200 dark:bg-blue-900/30 dark:hover:bg-blue-900/50 text-blue-800 dark:text-blue-500 flex items-center justify-center transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button class="w-8 h-8 rounded-full bg-green-100 hover:bg-green-200 dark:bg-green-900/30 dark:hover:bg-green-900/50 text-green-600 dark:text-green-400 flex items-center justify-center transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CONTENT SECTION -->
<section class="pb-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 -mt-8 relative z-10">
        <!-- Featured Image -->
        <div class="rounded-2xl overflow-hidden shadow-2xl mb-12 fade-up" style="animation-delay: 0.2s">
            <img src="{{ $newsItem['image'] }}" alt="{{ $newsItem['title'] }}" class="w-full h-auto max-h-[500px] object-cover">
        </div>

        <!-- Article Content -->
        <div class="prose prose-lg dark:prose-invert max-w-none fade-up" style="animation-delay: 0.3s">
            <div class="text-xl text-slate-600 dark:text-slate-300 font-medium leading-relaxed mb-8 italic border-l-4 border-{{ $newsItem['color'] }}-500 pl-6">
                {{ $newsItem['summary'] }}
            </div>
            
            <div class="article-body text-slate-700 dark:text-slate-300 leading-relaxed space-y-6">
                {!! $newsItem['content'] !!}
            </div>
        </div>
        
        <!-- Back Button -->
        <div class="mt-12 pt-8 border-t border-slate-200 dark:border-white/10 text-center fade-up">
            <a href="{{ route('news.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-white font-medium rounded-xl transition-colors">
                <i class="fas fa-arrow-left"></i> Kembali ke Indeks Berita
            </a>
        </div>
    </div>
</section>

<!-- RELATED NEWS -->
@if(count($relatedNews) > 0)
<section class="py-20 bg-slate-50 dark:bg-[#0f172a] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white mb-10 text-center fade-up">Berita Terkait Lainnya</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($relatedNews as $id => $item)
            <div class="news-card premium-card-glow group fade-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="relative overflow-hidden h-48">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent opacity-80"></div>
                    <div class="absolute top-3 left-3">
                        <span class="px-2.5 py-1 bg-{{ $item['color'] }}-600/90 text-white text-[10px] font-bold rounded-lg">{{ $item['tag'] }}</span>
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-center gap-3 text-xs text-slate-500 dark:text-slate-400 mb-2">
                        <span><i class="fas fa-calendar-alt text-{{ $item['color'] }}-500 mr-1"></i> {{ $item['date'] }}</span>
                    </div>
                    <h3 class="text-slate-900 dark:text-white font-bold text-base leading-snug mb-3 group-hover:text-{{ $item['color'] }}-600 dark:group-hover:text-{{ $item['color'] }}-400 transition-colors line-clamp-2">
                        <a href="{{ route('news.detail', $item['id']) }}" class="focus:outline-none">
                            <span class="absolute inset-0" aria-hidden="true"></span>
                            {{ $item['title'] }}
                        </a>
                    </h3>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

@endsection

@section('head')
<style>
    .article-body p {
        margin-bottom: 1.5em;
    }
    .article-body p:first-of-type::first-letter {
        font-size: 3.5rem;
        font-weight: 900;
        float: left;
        margin-right: 0.15em;
        line-height: 1;
        color: var(--tw-prose-headings);
    }
    .dark .article-body p:first-of-type::first-letter {
        color: white;
    }
    .news-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 16px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .dark .news-card {
        background: rgba(15,23,42,0.8);
        border: 1px solid rgba(255,255,255,0.07);
    }
    .premium-card-glow:hover {
        transform: translateY(-6px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.08), 0 0 15px rgba(168, 85, 247, 0.1);
        border-color: rgba(168, 85, 247, 0.3);
    }
    .dark .premium-card-glow:hover {
        box-shadow: 0 20px 40px rgba(0,0,0,0.5), 0 0 20px rgba(168, 85, 247, 0.15);
        border-color: rgba(168, 85, 247, 0.4);
    }
</style>
@endsection
