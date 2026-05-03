@extends('layouts.app')

@section('title', 'Association Newsroom - ECFA')

@section('content')
<!-- Custom Styles for smooth expansion -->
<style>
    [x-cloak] { display: none !important; }
    .news-card-transition {
        transition: all 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
</style>

<!-- High-End News Hero -->
<section class="relative overflow-hidden bg-slate-950 py-24 text-white">
    <div class="absolute inset-0 opacity-10"
         style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 300px; filter: grayscale(100%);">
    </div>
    <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-900/60 to-slate-950"></div>

    <div class="relative mx-auto max-w-6xl px-4 text-center">
        <span class="inline-block rounded-full bg-blue-500/10 px-4 py-1.5 text-xs font-black uppercase tracking-[0.3em] text-blue-400 ring-1 ring-blue-500/20 mb-6">Official Press</span>
        <h1 class="text-5xl font-black tracking-tighter md:text-7xl italic">Association <span class="text-amber-400">Newsroom</span></h1>
        <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-400 font-medium">The heartbeat of ECFA. Stay updated with the latest tournament results, executive decisions, and community stories.</p>
    </div>
</section>

<!-- Advanced News Command (Alpine.js Filter) -->
<section class="relative z-20 -mt-10"
         x-data="{
            search: '',
            type: 'All',
            items: {{ $news->map(function($item) {
                return [
                    'id' => $item->id,
                    'type' => $item->type,
                    'title' => strtolower($item->title),
                    'desc' => strtolower($item->description)
                ];
            })->toJson() }},
            isVisible(id) {
                const item = this.items.find(i => i.id === id);
                if (!item) return false;
                const matchesType = this.type === 'All' || item.type === this.type;
                const matchesSearch = item.title.includes(this.search.toLowerCase()) ||
                                     item.desc.includes(this.search.toLowerCase());
                return matchesType && matchesSearch;
            },
            get hasVisibleItems() {
                return this.items.some(i => this.isVisible(i.id));
            }
         }">

    <div class="mx-auto max-w-7xl px-4">
        <!-- Search & Filter Bar -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 p-6 md:p-8">
    <div class="flex flex-col gap-6">
        <!-- Live Search -->
        <div class="relative w-full group">
            <span class="absolute inset-y-0 left-0 pl-5 flex items-center text-slate-400 group-focus-within:text-blue-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </span>
            <input type="text" x-model="search" placeholder="Scan headlines or content..."
                   class="w-full bg-slate-50 border border-slate-200 rounded-2xl pl-12 pr-4 py-4 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition font-semibold text-slate-700">
        </div>

        <!-- Category Switcher (Scrollable) -->
        <div class="relative">
            <!-- Fade Effects for scrolling -->
            <div class="absolute left-0 top-0 bottom-0 w-8 bg-gradient-to-r from-white to-transparent z-10 pointer-events-none md:hidden"></div>
            <div class="absolute right-0 top-0 bottom-0 w-8 bg-gradient-to-l from-white to-transparent z-10 pointer-events-none md:hidden"></div>

            <div class="flex p-1.5 bg-slate-100 rounded-2xl overflow-x-auto no-scrollbar snap-x snap-mandatory">
                <div class="flex gap-1">
                    <template x-for="cat in ['All', 'News', 'Announcement', 'Event', 'Result', 'Achievement', 'Tournament', 'Training', 'Workshop', 'Selection', 'Notice', 'Alert', 'Recruitment', 'Ranking', 'Highlight', 'Injury']">
                        <button @click="type = cat"
                                :class="type === cat ? 'bg-white text-blue-600 shadow-md scale-105' : 'text-slate-500 hover:text-slate-900 hover:bg-white/50'"
                                class="snap-center flex-shrink-0 whitespace-nowrap py-2.5 px-6 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all duration-300 transform"
                                x-text="cat"></button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

 

        <!-- News Grid -->
        <div class="py-20">
            <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3 items-start">
                @forelse($news as $item)
                    <article x-data="{ expanded: false }"
                             x-show="isVisible({{ $item->id }})"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-4"
                             @click="expanded = !expanded"
                             :class="expanded ? 'border-blue-500 shadow-2xl ring-2 ring-blue-500/10' : 'border-slate-200'"
                             class="news-card-transition group flex flex-col bg-white rounded-[2.5rem] border p-8 shadow-sm hover:shadow-xl cursor-pointer relative overflow-hidden h-fit">

                        <div class="flex justify-between items-start mb-6">
                            <span class="bg-blue-50 text-blue-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.2em]">
                                {{ $item->type }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->created_at->format('M d, Y') }}</span>
                        </div>

                        <h3 class="text-xl font-black text-slate-900 leading-tight mb-4 group-hover:text-blue-600 transition tracking-tight italic uppercase">
                            {{ $item->title }}
                        </h3>

                        <!-- Clamped description for minimized view -->
                        <div class="relative">
                            <p class="text-slate-500 text-sm leading-relaxed whitespace-pre-line news-card-transition"
                               :class="expanded ? '' : 'line-clamp-3'">
                                {{ $item->description }}
                            </p>

                            <!-- Fade overlay when minimized -->
                            <div x-show="!expanded" class="absolute bottom-0 left-0 right-0 h-8 bg-gradient-to-t from-white to-transparent"></div>
                        </div>

                        <div class="pt-6 border-t border-slate-50 mt-6 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="h-1.5 w-1.5 rounded-full" :class="expanded ? 'bg-blue-500 animate-ping' : 'bg-emerald-500'"></div>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest" x-text="expanded ? 'Reading Full' : 'Verified Update'"></span>
                            </div>
                            <button class="text-[10px] font-black uppercase tracking-widest text-blue-600 transition-transform duration-300"
                                    :class="expanded ? 'rotate-180' : ''">
                                <span x-text="expanded ? 'Close' : 'Read Full'"></span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 inline ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-24 text-center border-2 border-dashed border-slate-200 rounded-[3rem]">
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-sm italic">The newsroom is currently quiet.</p>
                    </div>
                @endforelse

                <!-- No Search Results -->
                <div x-show="!hasVisibleItems && items.length > 0" x-cloak
                     class="col-span-full py-24 text-center border-2 border-dashed border-slate-200 rounded-[3rem]">
                    <p class="text-slate-400 font-bold uppercase tracking-widest text-sm italic">No updates found matching your search.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Media Inquiry Section -->
<section class="mx-auto max-w-6xl px-4 pb-24">
    <div class="bg-slate-900 rounded-[3rem] p-16 text-center text-white shadow-2xl relative overflow-hidden group">
        <div class="absolute -left-10 -bottom-10 h-64 w-64 rounded-full bg-blue-600/10 blur-[80px]"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-black tracking-tighter mb-4 italic uppercase">Media & Press Inquiries</h2>
            <p class="text-slate-400 max-w-xl mx-auto mb-10 font-medium leading-relaxed">Journalists and media partners seeking official quotes or imagery, please contact our PR division.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="mailto:ecfamotihari@gmail.com" class="bg-white text-slate-950 px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-amber-400 transition transform hover:-translate-y-1 shadow-xl">Contact PR Team</a>
            </div>
        </div>
    </div>
</section>
@endsection
