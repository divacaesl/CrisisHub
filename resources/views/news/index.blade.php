@extends('layouts.public')

@section('title', 'Berita & Update — CrisisHub')
@section('description', 'Informasi kebencanaan dan distribusi bantuan terbaru di seluruh Indonesia.')

@section('content')
<!-- HERO SECTION -->
<section class="relative pt-32 pb-20 bg-slate-50 dark:bg-[#0f172a] overflow-hidden transition-colors duration-300">
    <div class="absolute inset-0 pointer-events-none">
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-purple-600/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-blue-600/5 rounded-full blur-3xl"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-purple-600/15 border border-purple-600/25 rounded-full mb-4 fade-up">
            <i class="fas fa-newspaper text-purple-600 dark:text-purple-400 text-xs"></i>
            <span class="text-purple-600 dark:text-purple-400 text-sm font-semibold">Pusat Informasi</span>
        </div>
        <h1 class="text-4xl sm:text-5xl font-black text-slate-900 dark:text-white mb-6 fade-up" style="animation-delay: 0.1s">
            Berita & <span class="text-purple-600 dark:text-purple-400">Update</span>
        </h1>
        <p class="text-slate-600 dark:text-slate-400 text-lg max-w-2xl mx-auto mb-10 fade-up" style="animation-delay: 0.2s">
            Dapatkan informasi terkini seputar situasi kebencanaan, distribusi bantuan, relawan, dan fitur terbaru dari CrisisHub.
        </p>
    </div>
</section>

<!-- NEWS GRID -->
<section class="py-20 bg-white dark:bg-[#0a0f1e] transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($newsList as $id => $item)
            <div class="news-card news-card-item premium-card-glow group fade-up" style="animation-delay: {{ $loop->index * 0.1 }}s">
                <div class="relative overflow-hidden h-56">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    <div class="absolute inset-0 bg-gradient-to-t from-[#0f172a] via-transparent to-transparent opacity-80"></div>
                    <div class="absolute top-4 left-4">
                        <span class="px-3 py-1.5 bg-{{ $item['color'] }}-600/90 text-white text-xs font-bold rounded-lg shadow-lg backdrop-blur-sm">{{ $item['tag'] }}</span>
                    </div>
                </div>
                <div class="p-6 flex flex-col justify-between" style="min-height: 280px;">
                    <div>
                        <div class="flex items-center gap-4 text-xs text-slate-500 dark:text-slate-400 mb-3">
                            <span class="flex items-center gap-1.5"><i class="fas fa-calendar-alt text-{{ $item['color'] }}-500"></i> {{ $item['date'] }}</span>
                            <span class="flex items-center gap-1.5"><i class="fas fa-clock text-{{ $item['color'] }}-500"></i> {{ $item['read'] }}</span>
                        </div>
                        <h3 class="text-slate-900 dark:text-white font-bold text-xl leading-snug mb-3 group-hover:text-{{ $item['color'] }}-600 dark:group-hover:text-{{ $item['color'] }}-400 transition-colors line-clamp-2">
                            <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true"></span>
                                {{ $item['title'] }}
                            </a>
                        </h3>
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed mb-4 line-clamp-3">
                            {{ $item['summary'] }}
                        </p>
                    </div>
                    <div class="flex items-center justify-between pt-4 border-t border-slate-100 dark:border-white/5">
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400 flex items-center gap-2">
                            <div class="w-6 h-6 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center">
                                <i class="fas fa-newspaper text-slate-400 dark:text-slate-300 text-[10px]"></i>
                            </div>
                            Sumber: {{ $item['author'] }}
                        </span>
                        <a href="{{ $item['url'] }}" target="_blank" rel="noopener noreferrer" class="text-{{ $item['color'] }}-600 dark:text-{{ $item['color'] }}-400 text-sm font-bold flex items-center gap-1 group-hover:gap-2 transition-all relative z-10">
                            Baca <i class="fas fa-external-link-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection

@section('head')
<style>
    .news-card {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(0, 0, 0, 0.05);
        border-radius: 20px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }
    .dark .news-card {
        background: rgba(15,23,42,0.8);
        border: 1px solid rgba(255,255,255,0.07);
    }
    .premium-card-glow:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.08), 0 0 20px rgba(168, 85, 247, 0.1);
        border-color: rgba(168, 85, 247, 0.3);
    }
    .dark .premium-card-glow:hover {
        box-shadow: 0 25px 50px rgba(0,0,0,0.5), 0 0 30px rgba(168, 85, 247, 0.15);
        border-color: rgba(168, 85, 247, 0.4);
    }
</style>
@endsection
