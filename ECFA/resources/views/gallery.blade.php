@extends('layouts.app')

@section('title', 'Gallery - Visual Legacy | ECFA')

@section('content')
<!-- Hero Section -->
<section class="relative overflow-hidden bg-brand-dark py-16 text-white border-b border-white/5">
    <div class="absolute inset-0 opacity-5" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 200px; filter: grayscale(100%);"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-brand-dark via-brand-dark/80 to-transparent"></div>

    <div class="relative mx-auto max-w-6xl px-4 text-center z-10">
        <span class="inline-flex items-center gap-2 rounded-full bg-brand-gold/10 px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.2em] text-brand-gold ring-1 ring-brand-gold/20 mb-6 shadow-lg shadow-brand-gold/5">
            <span class="w-1.5 h-1.5 rounded-full bg-brand-gold animate-pulse"></span>
            Official Archive
        </span>
        <h1 class="text-4xl font-black tracking-tighter md:text-6xl uppercase italic">
            Visual <span class="text-brand-gold">Legacy</span>
        </h1>
        <p class="mx-auto mt-4 max-w-xl text-sm text-slate-400 font-bold uppercase tracking-widest">
            Witness the intensity, discipline, and glory of East Champaran Fencing.
        </p>
    </div>
</section>

<!-- Main Gallery Section (Alpine.js powered) -->
<section class="py-16 bg-slate-50 min-h-screen" x-data="{
    open: false,
    currentImg: '',
    currentTitle: '',
    activeCategory: 'All',
    show(url, title) {
        this.currentImg = url;
        this.currentTitle = title;
        this.open = true;
        document.body.style.overflow = 'hidden';
    },
    close() {
        this.open = false;
        document.body.style.overflow = 'auto';
    }
}">
    <div class="mx-auto max-w-7xl px-5">

        <!-- Category Filters -->
        <div class="mb-12 flex flex-wrap justify-center gap-3">
            <template x-for="cat in ['All', 'Tournaments', 'Training', 'General']">
                <button
                    @click="activeCategory = cat"
                    :class="activeCategory === cat ? 'bg-brand-dark text-brand-gold shadow-xl border-brand-dark' : 'bg-white text-slate-500 border-slate-200 hover:border-slate-300'"
                    class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest border transition-all duration-300"
                    x-text="cat">
                </button>
            </template>
        </div>

        @if($galleryItems->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-[2rem] border border-slate-200 border-dashed p-16 text-center shadow-sm">
                <div class="w-20 h-20 mx-auto bg-slate-50 rounded-full flex items-center justify-center mb-4">
                    <svg class="w-10 h-10 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <h3 class="text-xl font-black text-slate-800 uppercase tracking-tight">Gallery is Empty</h3>
                <p class="text-slate-500 mt-2 font-medium">No media assets have been uploaded to the archive yet.</p>
            </div>
        @else
            <!-- Photo Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($galleryItems as $item)
                    <!-- Photo Card -->
                    <article
                        x-show="activeCategory === 'All' || activeCategory === '{{ $item->category }}'"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100"
                        class="group relative bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden hover:shadow-2xl transition-all duration-500 cursor-pointer flex flex-col"
                        x-on:click="show('{{ $item->url }}', '{{ $item->title }}')">

                        <!-- Image Wrapper -->
                        <div class="relative aspect-square sm:aspect-[4/3] overflow-hidden bg-slate-100 w-full">
                            <!-- Actual Cloudinary Image -->
                            <img src="{{ $item->url }}" alt="{{ $item->title }}" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                            <!-- Hover Overlay with Zoom Icon -->
                            <div class="absolute inset-0 bg-brand-dark/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                                <div class="bg-white/90 backdrop-blur-sm text-brand-dark rounded-full p-4 transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-xl">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </div>
                            </div>

                            <!-- Category Badge positioned on image -->
                            <div class="absolute top-4 left-4">
                                <span class="bg-white/95 backdrop-blur shadow-lg text-slate-800 px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-widest">
                                    {{ $item->category ?? 'General' }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-lg font-black text-slate-900 tracking-tight uppercase line-clamp-1 mb-1">{{ $item->title }}</h3>

                            @if($item->description)
                                <p class="text-xs text-slate-500 font-medium line-clamp-2 leading-relaxed mb-4 flex-1">{{ $item->description }}</p>
                            @else
                                <p class="text-xs text-slate-300 italic mb-4 flex-1">No description provided.</p>
                            @endif

                            <div class="pt-4 border-t border-slate-50 flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-slate-50 flex items-center justify-center text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $item->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-16 flex justify-center">
                {{ $galleryItems->links() }}
            </div>
        @endif
    </div>

    <!-- Fullscreen Lightbox Modal -->
    <template x-if="open">
        <div class="fixed inset-0 z-[200] flex items-center justify-center bg-slate-950/95 backdrop-blur-md p-4 sm:p-8"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             x-on:keydown.escape.window="close()">

            <!-- Close Button -->
            <button x-on:click="close()" class="absolute right-6 top-6 sm:right-8 sm:top-8 text-white/50 hover:text-brand-gold bg-white/5 hover:bg-white/10 rounded-full p-3 transition-all transform hover:rotate-90 z-[210]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>

            <!-- Image Container -->
            <div class="max-w-6xl w-full flex flex-col items-center justify-center" x-on:click.away="close()">
                <div class="relative group">
                    <img :src="currentImg" class="max-h-[80vh] w-auto max-w-full rounded-[1rem] sm:rounded-[2rem] shadow-2xl border border-white/10 object-contain">
                </div>
                <!-- Title below image -->
                <h2 class="mt-6 text-lg sm:text-2xl font-black text-white tracking-widest uppercase text-center px-4" x-text="currentTitle"></h2>
            </div>
        </div>
    </template>
</section>
@endsection
