@extends('layouts.app')

@section('title', 'Athlete Command Center | ECFA')

@push('styles')
<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }
    .gradient-text {
        background: linear-gradient(135deg, #1e293b 0%, #3b82f6 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .status-pulse {
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-[#f8fafc] pb-20">
    <!-- Top Decorative Banner -->
    <div class="h-64 bg-slate-900 w-full absolute top-0 left-0 z-0">
        <div class="absolute inset-0 opacity-20" style="background-image: url('data:image/svg+xml,%3Csvg width=\"30\" height=\"30\" viewBox=\"0 0 30 30\" fill=\"none\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cpath d=\"M15 0L17.5 12.5L30 15L17.5 17.5L15 30L12.5 17.5L0 15L12.5 12.5L15 0Z\" fill=\"white\"/%3E%3C/svg%3E'); background-size: 40px;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-6 pt-32">

        <!-- Header: Profile & Quick Actions -->
        <div class="flex flex-col lg:flex-row justify-between items-end mb-12 gap-8">
            <div class="flex items-center gap-6">
                <div class="relative">
                    <div class="h-24 w-24 rounded-[2rem] bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-3xl font-black text-white shadow-2xl ring-4 ring-white">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="absolute -bottom-2 -right-2 h-8 w-8 bg-green-500 border-4 border-white rounded-full status-pulse"></div>
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-4xl font-black text-white tracking-tight uppercase italic">{{ $user->name }}</h1>
                        <span class="bg-blue-500/20 text-blue-300 text-[10px] font-black px-3 py-1 rounded-full border border-blue-500/30 uppercase tracking-widest">Active Athlete</span>
                    </div>
                    <p class="text-slate-400 font-bold mt-1 uppercase text-xs tracking-[0.2em]">ECFA ID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</p>
                </div>
            </div>

            <div class="flex gap-4 w-full lg:w-auto">
                <a href="{{ route('player.learn') }}" class="flex-1 lg:flex-none text-center bg-white text-slate-900 px-8 py-4 rounded-2xl font-black text-xs uppercase tracking-widest shadow-xl hover:bg-blue-600 hover:text-white transition-all duration-300 transform hover:-translate-y-1">
                    Training Library
                </a>
                <button class="bg-blue-600 text-white p-4 rounded-2xl shadow-xl hover:bg-blue-700 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                </button>
            </div>
        </div>

        <!-- Stats Grid: The Elite Tryptic -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-12">
            <!-- Rank Status -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 text-blue-500/5 group-hover:scale-110 transition-transform duration-700">
                    <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                </div>
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Combat Standing</p>
                <h3 class="text-4xl font-black text-slate-900 mb-4 italic">{{ $stats['rank'] }}</h3>
                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    <div class="bg-blue-600 h-full rounded-full" style="width: {{ $stats['xp_percent'] }}%"></div>
                </div>
                <p class="text-[10px] font-bold text-blue-600 mt-3 uppercase tracking-widest">Level {{ $stats['level'] }} • {{ $stats['xp_percent'] }}% to next rank</p>
            </div>

            <!-- Hall of Fame -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Medal Count</p>
                <div class="flex items-end gap-3">
                    <h3 class="text-6xl font-black text-slate-900">{{ $myAchievements }}</h3>
                    <span class="text-amber-500 text-3xl mb-1">🥇</span>
                </div>
                <p class="text-[10px] font-bold text-amber-600 mt-4 uppercase tracking-widest">Verified Achievements in Hall of Fame</p>
            </div>

            <!-- Tournaments -->
            <div class="glass-card p-8 rounded-[2.5rem] shadow-2xl relative overflow-hidden group">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2">Association Events</p>
                <h3 class="text-6xl font-black text-slate-900">{{ $totalEvents }}</h3>
                <p class="text-[10px] font-bold text-slate-500 mt-4 uppercase tracking-widest">Global Championships Currently Active</p>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            <!-- Left: Upcoming Tournaments (Timeline Style) -->
            <div class="lg:col-span-2 space-y-8">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter italic">Battle Schedule</h3>
                    <div class="h-px flex-1 bg-slate-200 mx-6"></div>
                </div>

                <div class="grid gap-6">
                    @forelse($upcomingEvents as $event)
                    <div class="group relative bg-white p-6 rounded-[2.5rem] shadow-xl border border-transparent hover:border-blue-500 transition-all duration-500">
                        <div class="flex flex-col md:flex-row items-center gap-8">
                            <div class="relative h-24 w-24 md:h-32 md:w-32 shrink-0 rounded-[2rem] overflow-hidden shadow-lg">
                                <img src="{{ $event->image }}" class="h-full w-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                            </div>

                            <div class="flex-1 text-center md:text-left">
                                <span class="text-[10px] font-black text-blue-600 uppercase tracking-[0.2em]">{{ $event->location }}</span>
                                <h4 class="text-2xl font-black text-slate-900 uppercase tracking-tight mt-1">{{ $event->title }}</h4>
                                <div class="flex flex-wrap justify-center md:justify-start gap-4 mt-4">
                                    <div class="flex items-center gap-2 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('D, d M Y') }}
                                    </div>
                                </div>
                            </div>

                            <form action="{{ route('event.join', $event->id) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                <button class="w-full md:w-auto bg-slate-900 text-white px-10 py-4 rounded-2xl font-black text-[10px] uppercase tracking-[0.2em] hover:bg-blue-600 transition-all shadow-lg shadow-slate-900/10">
                                    Enlist Now
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white p-20 rounded-[3rem] text-center border-2 border-dashed border-slate-200">
                        <span class="text-5xl">🛡️</span>
                        <p class="text-slate-400 font-bold mt-4 uppercase text-xs tracking-widest">No active deployments found.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Right: Tactical Intel (Sidebar) -->
            <div class="space-y-8">
                <div class="flex items-center gap-4">
                    <h3 class="text-2xl font-black text-slate-900 uppercase tracking-tighter italic whitespace-nowrap">Tactical Intel</h3>
                    <div class="h-px w-full bg-slate-200"></div>
                </div>

                <div class="bg-slate-900 rounded-[3rem] p-8 shadow-2xl relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-8 opacity-10">
                        <svg class="w-24 h-24 text-white" fill="currentColor" viewBox="0 0 20 20"><path d="M9 4.804A7.993 7.993 0 0115 5a1 1 0 011 1v12a1 1 0 01-1 1c-2.423-.5-4.856-.5-7.28 0A1 1 0 017 18V6a1 1 0 011-1.196z"/></svg>
                    </div>

                    <div class="relative z-10 space-y-8">
                        @forelse($latestMaterials as $material)
                        <div class="group cursor-pointer">
                            <p class="text-[10px] font-black text-blue-400 uppercase tracking-[0.3em] mb-1">{{ $material->weapon }}</p>
                            <h5 class="text-white font-black text-lg uppercase leading-tight group-hover:text-blue-400 transition-colors">{{ $material->title }}</h5>
                            <div class="flex items-center gap-4 mt-4">
                                <a href="{{ route('player.learn') }}" class="text-[9px] font-black text-white/50 uppercase tracking-[0.2em] border-b border-white/10 pb-1 group-hover:border-blue-400 transition-all">Download Briefing</a>
                            </div>
                        </div>
                        @empty
                        <p class="text-white/30 italic text-sm py-10">No new intel available.</p>
                        @endforelse
                    </div>

                    <a href="{{ route('player.learn') }}" class="mt-12 block w-full py-4 bg-white/5 hover:bg-white/10 text-center rounded-2xl text-[10px] font-black text-white uppercase tracking-widest transition-all">
                        Access Full Arsenal
                    </a>
                </div>

                <!-- Personal Message Box -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2.5rem] p-8 text-white shadow-xl shadow-blue-600/20">
                    <h4 class="font-black uppercase italic tracking-tight text-xl mb-2">Coach's Tip</h4>
                    <p class="text-blue-100 text-sm leading-relaxed italic opacity-80">"Success is where preparation and opportunity meet. Keep your guard up and your focus sharper."</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
