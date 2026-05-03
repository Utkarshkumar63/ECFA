@extends('layouts.app')

@section('title', 'Arena Control Center - ECFA')

@section('content')
<div class="min-h-screen bg-[#f1f5f9]">
    <!-- Compact Header -->
    <header class="relative bg-[#0f172a] pt-24 pb-12 px-6">
        <div class="absolute inset-0 opacity-5" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 200px;"></div>
        <div class="relative max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-center md:text-left">
                <h1 class="text-3xl md:text-4xl font-black text-white italic uppercase tracking-tighter leading-none">
                    Tournament <span class="text-blue-500 not-italic">Control</span>
                </h1>
                <p class="mt-2 text-slate-400 font-bold uppercase text-[10px] tracking-[0.3em]">Operational Registry</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white/5 hover:bg-white/10 text-white border border-white/10 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all">
                ← Command Center
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 -mt-8 pb-32">
        <div class="grid lg:grid-cols-12 gap-8">

            <!-- DEPLOYMENT FORM (Compact Sidebar) -->
            <div class="lg:col-span-4">
                <div class="sticky top-24">
                    <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">
                        <div class="bg-slate-900 p-6 text-white">
                            <h2 class="text-xl font-black tracking-tight uppercase italic">Deploy Arena</h2>
                        </div>

                        <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4">
                            @csrf
                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Event Title</label>
                                <input type="text" name="title" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-700 text-xs focus:border-blue-500 outline-none">
                            </div>

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Date</label>
                                    <input type="date" name="event_date" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-3 font-bold text-slate-700 text-xs focus:border-blue-500 outline-none">
                                </div>
                                <div>
                                    <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Location</label>
                                    <input type="text" name="location" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-3 font-bold text-slate-700 text-xs focus:border-blue-500 outline-none">
                                </div>
                            </div>

                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Intel (Brief)</label>
                                <textarea name="description" rows="2" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 font-bold text-slate-700 text-xs focus:border-blue-500 outline-none"></textarea>
                            </div>

                            <div>
                                <label class="text-[9px] font-black text-slate-400 uppercase tracking-widest ml-1">Banner Asset</label>
                                <input type="file" name="image" required class="text-[9px] text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 cursor-pointer">
                            </div>

                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg">
                                Initialize Launch ⚡
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- REGISTRY LIST (The Compact Professional View) -->
            <div class="lg:col-span-8 space-y-4">

                <div class="flex justify-between items-center mb-2 px-2">
                    <h2 class="text-2xl font-black text-slate-900 uppercase italic tracking-tight">Active <span class="text-blue-600">Arenas</span></h2>
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total: {{ $events->total() }}</span>
                </div>

                @if(session('success'))
                    <div class="p-4 bg-emerald-500 text-white rounded-2xl font-bold text-xs flex items-center gap-3 animate-pulse">
                        <span>✓</span> {{ session('success') }}
                    </div>
                @endif

                <div class="space-y-3">
                    @forelse($events as $event)
                        <div class="group bg-white rounded-2xl border border-slate-200 p-4 hover:shadow-lg transition-all duration-300 flex flex-col md:flex-row items-center gap-5">

                            <!-- Thumbnail (Smaller 20x20 size) -->
                            <div class="h-20 w-20 rounded-xl overflow-hidden flex-shrink-0 border border-slate-100 shadow-sm">
                                @if($event->image)
                                    <img src="{{ $event->image }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                                @else
                                    <div class="h-full w-full bg-slate-100 flex items-center justify-center text-2xl">🤺</div>
                                @endif
                            </div>

                            <!-- Intel (Content) -->
                            <div class="flex-grow min-w-0 text-center md:text-left">
                                <div class="flex flex-col md:flex-row md:items-center gap-2">
                                    <h3 class="text-lg font-black text-slate-800 uppercase tracking-tight truncate">{{ $event->title }}</h3>
                                    @php
                                        $statusColor = [
                                            'upcoming' => 'bg-blue-100 text-blue-600',
                                            'completed' => 'bg-emerald-100 text-emerald-600',
                                            'cancelled' => 'bg-red-100 text-red-600'
                                        ][$event->status ?? 'upcoming'];
                                    @endphp
                                    <span class="{{ $statusColor }} px-2 py-0.5 rounded text-[8px] font-black uppercase w-fit mx-auto md:mx-0">
                                        {{ $event->status ?? 'upcoming' }}
                                    </span>
                                </div>

                                <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 mt-1">
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                        <span class="text-blue-500 opacity-70">📅</span> {{ \Carbon\Carbon::parse($event->event_date)->format('d M, Y') }}
                                    </span>
                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-wider flex items-center gap-1">
                                        <span class="text-blue-500 opacity-70">📍</span> {{ $event->location }}
                                    </span>

                                    <!-- Quick Status Toggle -->
                                    <form action="{{ route('admin.event.status', $event->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        <select name="status" onchange="this.form.submit()" class="bg-slate-100 border-none text-[8px] font-black uppercase text-slate-500 rounded-lg py-0.5 px-2 focus:ring-0 cursor-pointer">
                                            <option value="upcoming" {{ ($event->status == 'upcoming') ? 'selected' : '' }}>Set Upcoming</option>
                                            <option value="completed" {{ ($event->status == 'completed') ? 'selected' : '' }}>Set Completed</option>
                                            <option value="cancelled" {{ ($event->status == 'cancelled') ? 'selected' : '' }}>Set Cancelled</option>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <!-- ACTION CENTER (Condensed Buttons) -->
                            <div class="flex items-center gap-2 flex-wrap justify-center">

                                <!-- Participants Button -->
                                <a href="{{ route('admin.event.participants', $event->id) }}" class="h-10 px-3 bg-slate-900 text-white rounded-xl flex items-center gap-2 hover:bg-blue-600 transition shadow-sm">
                                    <span class="text-xs">👥</span>
                                    <span class="text-[10px] font-black uppercase">{{ $event->athletes_count }}</span>
                                </a>

                                <!-- NEW: Mark Attendance Button -->
                                <a href="{{ route('admin.event.attendance', $event->id) }}" class="h-10 px-3 bg-emerald-600 text-white rounded-xl flex items-center gap-2 hover:bg-emerald-700 transition shadow-sm" title="Mark Attendance">
                                    <span class="text-xs">📋</span>
                                    <span class="text-[9px] font-black uppercase">Attendance</span>
                                </a>

                                <!-- Edit -->
                                <a href="{{ route('admin.event.edit', $event->id) }}" class="h-10 w-10 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center hover:bg-blue-600 hover:text-white transition shadow-sm border border-blue-100">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.event.delete', $event->id) }}" method="POST" onsubmit="return confirm('Purge Arena?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="h-10 w-10 bg-red-50 text-red-600 rounded-xl flex items-center justify-center hover:bg-red-600 hover:text-white transition shadow-sm border border-red-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border-2 border-dashed border-slate-200 p-16 text-center rounded-[2rem]">
                            <p class="font-black text-slate-300 uppercase tracking-widest text-xs">No Events Found</p>
                        </div>
                    @endforelse
                </div>

                <div class="pt-6">
                    {{ $events->links() }}
                </div>
            </div>
        </div>
    </main>
</div>

<style>
    /* Compact scrollbar */
    ::-webkit-scrollbar { width: 5px; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }

    /* Input styling */
    input[type="date"]::-webkit-calendar-picker-indicator { filter: invert(0.5); cursor: pointer; }
</style>
@endsection
