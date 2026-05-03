@extends('layouts.app')

@section('title', 'Athlete Training Hub - ECFA')

@section('content')
<!-- Professional Header -->
<section class="relative overflow-hidden bg-slate-900 py-20 text-white">
    <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 300px; filter: grayscale(100%);"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-indigo-900/40 to-slate-900"></div>

    <div class="relative mx-auto max-w-6xl px-4 text-center">
        <span class="inline-block rounded-full bg-blue-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.3em] text-blue-400 ring-1 ring-blue-500/20 mb-6">Knowledge Base</span>
        <h1 class="text-5xl font-black tracking-tighter md:text-7xl">Training <span class="text-amber-400">Portal</span></h1>
        <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-300">Access exclusive technical guides, rulebooks, and tactical notes curated by ECFA coaches.</p>

        @auth
            <div class="mt-8 flex items-center justify-center gap-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Active Session: <span class="text-white">{{ auth()->user()->name }}</span></p>
            </div>
        @endauth
    </div>
</section>

<main class="mx-auto max-w-7xl px-4 py-16">

    @guest
        <!-- Modern Login Gate -->
        <div class="max-w-2xl mx-auto text-center py-20 bg-white rounded-[3rem] shadow-2xl border border-slate-100 px-8">
            <div class="inline-flex h-20 w-20 items-center justify-center rounded-3xl bg-amber-50 text-amber-500 text-4xl mb-8 shadow-inner">🔒</div>
            <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-4">Restricted Access</h2>
            <p class="text-slate-500 mb-10 text-lg">The Training Library is reserved for registered ECFA athletes. Please sign in to view your learning materials.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="{{ url('/player-login') }}" class="px-10 py-4 bg-blue-600 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-blue-700 transition shadow-xl shadow-blue-600/20">Sign In to Portal</a>
                <a href="{{ url('/registration') }}" class="px-10 py-4 bg-slate-900 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-slate-800 transition">Apply for Membership</a>
            </div>
        </div>
    @endguest

    @auth
        <!-- Interactive Learning Dashboard -->
        <div x-data="{ weapon: 'All', event: '' }" class="space-y-12">

            <!-- Filter Bar -->
            <div class="flex flex-col lg:flex-row justify-between items-center gap-8 bg-white p-8 rounded-[2.5rem] shadow-xl border border-slate-100">
                <div class="w-full lg:w-auto">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Filter by Tournament</p>
                    <select x-model="event" class="w-full lg:w-72 bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-700 focus:ring-4 focus:ring-blue-100 outline-none transition">
                        <option value="">All Official Events</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->title }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full lg:w-auto">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1 text-center lg:text-left">Weapon Category</p>
                    <div class="flex flex-wrap justify-center gap-2">
                        <template x-for="type in ['All', 'Foil', 'Epee', 'Sabre']">
                            <button @click="weapon = type"
                                    :class="weapon === type ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'bg-slate-50 text-slate-500 hover:bg-slate-100 border border-slate-200'"
                                    class="px-6 py-2.5 rounded-full text-xs font-black uppercase tracking-widest transition-all duration-300"
                                    x-text="type"></button>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Material Grid -->
            <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($materials as $item)
                    <!-- We use Alpine logic to show/hide based on filters -->
                    <article x-show="(weapon === 'All' || weapon === '{{ $item->weapon }}') && (event === '' || event === '{{ $item->event_id }}')"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             class="group bg-white rounded-[2.5rem] border border-slate-200 p-8 shadow-sm transition hover:shadow-2xl hover:-translate-y-2 flex flex-col h-full relative overflow-hidden">

                        <!-- Watermark Icon -->
                        <div class="absolute -right-4 -top-4 text-8xl opacity-5 group-hover:scale-110 transition duration-500 grayscale">
                            {{ $item->weapon == 'Foil' ? '🤺' : ($item->weapon == 'Epee' ? '🛡️' : '⚔️') }}
                        </div>

                        <div class="flex justify-between items-start mb-6">
                            <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                                {{ $item->weapon }}
                            </span>
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest italic">PDF Document</span>
                        </div>

                        <h3 class="text-2xl font-black text-slate-900 leading-tight mb-4 group-hover:text-blue-600 transition">{{ $item->title }}</h3>

                        <div class="mt-auto pt-8 border-t border-slate-100 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="h-8 w-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-400">📄</div>
                                <span class="text-[11px] font-bold text-slate-400 uppercase tracking-tighter">{{ $item->event->title ?? 'General Training' }}</span>
                            </div>

                            <a href="{{ asset('storage/' . $item->file_path) }}" download class="h-12 w-12 rounded-xl bg-blue-600 text-white flex items-center justify-center shadow-lg shadow-blue-600/20 hover:bg-slate-900 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full py-24 text-center border-2 border-dashed border-slate-200 rounded-[3rem]">
                        <p class="text-slate-400 font-bold uppercase tracking-widest">No training materials uploaded yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    @endauth

</main>

<!-- Training Support CTA -->
<section class="mx-auto max-w-6xl px-4 pb-24">
    <div class="bg-slate-900 rounded-[3rem] p-12 text-center text-white shadow-2xl relative overflow-hidden">
        <div class="absolute inset-0 bg-blue-600/10 blur-[100px]"></div>
        <div class="relative z-10">
            <h2 class="text-3xl font-black tracking-tighter mb-4">Need Technical Help?</h2>
            <p class="text-slate-400 max-w-xl mx-auto mb-10 font-medium leading-relaxed italic">"Technique is the foundation of every victory." - If you cannot find a specific guide, contact your lead coach.</p>
            <a href="{{ url('/contact') }}" class="inline-block bg-white text-slate-900 px-10 py-4 rounded-full font-black uppercase tracking-widest text-xs hover:bg-amber-400 transition transform hover:-translate-y-1">Contact Coaches</a>
        </div>
    </div>
</section>
@endsection
