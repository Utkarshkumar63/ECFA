@extends('layouts.app')

@section('title', 'Tournaments & Arena - ECFA')

@push('styles')
    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(40px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .event-card {
            animation: fadeInUp 0.7s cubic-bezier(0.23, 1, 0.32, 1) forwards;
            opacity: 0;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
@endpush

@section('content')
<div class="bg-white min-h-screen">

    <!-- Success/Error Toast Notifications -->
    <div class="fixed top-24 right-6 z-[100] space-y-4">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
                 class="bg-emerald-500 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 animate-bounce border border-emerald-400/50 backdrop-blur-md">
                <span class="text-xl">✅</span>
                <div class="text-[10px] font-black uppercase tracking-widest">{{ session('success') }}</div>
            </div>
        @endif
    </div>

    <!-- Hero Section -->
    <section class="relative overflow-hidden bg-[#0a0f1d] py-28 text-white">
        <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 250px; filter: grayscale(100%) brightness(2);"></div>
        <div class="absolute inset-0 bg-gradient-to-br from-blue-900/40 via-[#0a0f1d] to-[#0a0f1d]"></div>

        <div class="relative mx-auto max-w-6xl px-6 text-center">
            <span class="mb-8 inline-flex items-center gap-3 rounded-full bg-blue-500/10 border border-blue-500/30 px-6 py-2 text-[10px] font-black uppercase tracking-[0.3em] text-blue-400">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-500"></span>
                </span>
                The Competitive Circuit
            </span>
            <h1 class="text-6xl font-black tracking-tighter md:text-8xl italic uppercase">
                Tournaments <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400 not-italic">& Arena</span>
            </h1>
        </div>
    </section>

    <!-- Tab Switcher Section -->
    <section class="relative z-20 -mt-10" x-data="{ activeTab: 'upcoming' }">
        <div class="mx-auto max-w-xl px-6">
            <div class="flex p-2 glass-nav rounded-full shadow-2xl border-white/50 bg-white/70">
                <button x-on:click="activeTab = 'upcoming'"
                    x-bind:class="activeTab === 'upcoming' ? 'bg-blue-600 text-white shadow-xl translate-y-[-2px]' : 'text-slate-500 hover:text-slate-900'"
                    class="flex-1 py-4 px-8 rounded-full text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-500 outline-none">
                    Upcoming
                </button>
                <button x-on:click="activeTab = 'past'"
                    x-bind:class="activeTab === 'past' ? 'bg-slate-900 text-white shadow-xl translate-y-[-2px]' : 'text-slate-500 hover:text-slate-900'"
                    class="flex-1 py-4 px-8 rounded-full text-[10px] font-black uppercase tracking-[0.2em] transition-all duration-500 outline-none">
                    Archives
                </button>
            </div>
        </div>

        <div class="mx-auto max-w-7xl px-6 py-24">
            <!-- Upcoming Events Tab -->
            <div x-show="activeTab === 'upcoming'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-16 gap-6">
                    <div>
                        <h2 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Live Opportunities</h2>
                        <div class="h-1 w-20 bg-blue-600 mt-2 rounded-full"></div>
                    </div>
                </div>

                <div class="grid gap-10 md:grid-cols-2 lg:grid-cols-3">
                    @forelse($upcoming as $event)
                        <article class="event-card group bg-white rounded-[3rem] border border-slate-100 p-3 shadow-xl hover:shadow-2xl transition-all duration-700 hover:-translate-y-3" style="opacity: 1;">
                            <div class="p-8">
                                <div class="flex justify-between items-start mb-10">
                                    <div class="h-8 w-10 rounded-2xl bg-slate-50 text-slate-900 flex items-center justify-center text-3xl shadow-inner">🤺</div>

                                    <!-- DYNAMIC STATUS BADGE (FIXED) -->
                                    @php
                                        $statusConfig = [
                                            'upcoming' => ['label' => 'Active', 'class' => 'bg-blue-50 text-blue-700 ring-blue-100'],
                                            'completed' => ['label' => 'Completed', 'class' => 'bg-emerald-50 text-emerald-700 ring-emerald-100'],
                                            'cancelled' => ['label' => 'Cancelled', 'class' => 'bg-red-50 text-red-700 ring-red-100']
                                        ][$event->status ?? 'upcoming'];
                                    @endphp
                                    <span class="{{ $statusConfig['class'] }} px-5 py-2 rounded-full text-[9px] font-black uppercase tracking-widest ring-1">
                                        {{ $statusConfig['label'] }}
                                    </span>
                                </div>

                                <h3 class="text-2xl font-black text-slate-900 leading-tight mb-4 uppercase tracking-tighter italic">
                                    {{ $event->title }}
                                </h3>
                                <p class="text-slate-500 text-sm leading-relaxed mb-10 line-clamp-3 italic">
                                    {{ $event->description }}
                                </p>

                                <div class="space-y-4 pt-8 border-t border-slate-50 mb-10">
                                    <div class="flex items-center gap-4 text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-lg">📅</span>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                    </div>
                                    <div class="flex items-center gap-4 text-[10px] font-black text-slate-600 uppercase tracking-widest">
                                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-50 border border-slate-100 text-lg">📍</span>
                                        {{ $event->location }}
                                    </div>
                                </div>

                                <!-- Logic-Driven Action Button (FIXED) -->
                                @auth
                                    @if($event->status !== 'upcoming')
                                        {{-- If completed or cancelled --}}
                                        <div class="w-full bg-slate-50 text-slate-400 py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] border border-slate-100 text-center cursor-not-allowed">
                                            Registration Closed
                                        </div>
                                    @else
                                        @php $isRegistered = $event->athletes->contains(auth()->id()); @endphp

                                        @if($isRegistered)
                                            <div class="flex items-center justify-center gap-3 w-full bg-emerald-50 text-emerald-600 py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] border border-emerald-100">
                                                <span>✓</span> Already Registered
                                            </div>
                                        @elseif(!auth()->user()->is_approved)
                                            <div class="w-full bg-amber-50 text-amber-600 py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] border border-amber-100 text-center">
                                                Account Pending Approval
                                            </div>
                                        @else
                                            <form action="{{ route('event.join', $event->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] hover:bg-blue-600 transition-all shadow-xl shadow-slate-200 active:scale-95">
                                                    Confirm Registration <span>→</span>
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="flex items-center justify-center gap-3 w-full bg-slate-100 text-slate-900 py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] hover:bg-blue-600 hover:text-white transition-all">
                                        Login to Register 🔒
                                    </a>
                                @endauth
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-32 text-center border-2 border-dashed border-slate-200 rounded-[4rem]">
                            <p class="text-slate-400 font-black uppercase tracking-[0.4em] text-xs">No Active Tournaments</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Past Events Tab -->
            <div x-show="activeTab === 'past'" x-transition:enter="transition ease-out duration-500" x-transition:enter-start="opacity-0 translate-y-8">
                <h2 class="text-4xl font-black text-slate-900 mb-16 tracking-tighter uppercase italic">Arena Archives</h2>
                <div class="grid gap-8 md:grid-cols-2 lg:grid-cols-4">
                    @forelse($past ?? [] as $event)
                        <article class="bg-white rounded-[2.5rem] border border-slate-100 p-10 shadow-lg">
                            <div class="h-14 w-14 rounded-2xl bg-slate-50 flex items-center justify-center mb-8 text-2xl">🏆</div>
                            <h3 class="text-lg font-black text-slate-900 uppercase tracking-tighter mb-2">{{ $event->title }}</h3>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">{{ \Carbon\Carbon::parse($event->event_date)->format('Y') }} Season</p>
                        </article>
                    @empty
                        <div class="col-span-full p-20 text-center glass-nav rounded-[3rem] border-slate-100">
                            <p class="text-slate-400 font-black uppercase tracking-[0.3em] text-[10px]">Archived data being processed.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="mx-auto max-w-7xl px-6 pb-28">
        <div class="relative overflow-hidden bg-slate-900 rounded-[4rem] p-12 md:p-24 text-center text-white shadow-3xl">
            <div class="relative z-10">
                <h2 class="text-4xl md:text-6xl font-black tracking-tighter mb-8 uppercase italic">Host a <span class="text-blue-500 not-italic">Meet?</span></h2>
                <div class="flex flex-wrap justify-center gap-6">
                    <a href="/contact" class="bg-white text-slate-900 px-12 py-5 rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-blue-600 hover:text-white transition-all shadow-2xl">
                        Contact Committee
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
