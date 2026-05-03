@extends('layouts.app')

@section('title', 'Admin Command Center')

@section('content')
<!-- Admin Header -->
<header class="bg-slate-900 border-b border-slate-800 py-10 shadow-2xl">
    <div class="max-w-7xl mx-auto px-4 flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <div class="flex items-center gap-2 mb-2">
                <span class="h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span class="text-xs font-black uppercase tracking-[0.2em] text-slate-400">System Live</span>
            </div>
            <h1 class="text-4xl font-black text-white tracking-tighter">Admin <span class="text-amber-400">Dashboard</span></h1>
            <p class="text-slate-400 mt-1">Welcome back, {{ auth()->user()->name ?? 'Administrator' }}</p>
        </div>
        <div class="flex gap-3">
            <a href="/" class="bg-slate-800 hover:bg-slate-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition">View Public Site</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500/10 hover:bg-red-500 text-red-500 px-5 py-2.5 rounded-xl text-sm font-bold transition">Logout</button>
            </form>
        </div>
    </div>
</header>

<main class="max-w-7xl mx-auto px-4 py-12">
    <!-- Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Awaiting Approval</p>
            <p class="text-4xl font-black text-amber-500">{{ count($pendingPlayers) }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Active Players</p>
            <p class="text-4xl font-black text-blue-600">{{ $totalPlayers }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Total Events</p>
            <p class="text-4xl font-black text-slate-900">{{ $totalEvents }}</p>
        </div>
        <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Medal Records</p>
            <p class="text-4xl font-black text-slate-900">{{ $totalAchievements }}</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-12">
        <!-- Quick Actions Column -->
        <div class="lg:col-span-1 space-y-4">
            <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight">Management Suite</h2>

            <a href="/admin-players" class="group flex items-center justify-between p-4 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-lg transition">
                <div class="flex items-center gap-4">
                    <span class="text-2xl">👥</span>
                    <span class="font-bold text-slate-700 group-hover:text-blue-600">Athletes & Rosters</span>
                </div>
                <span class="text-slate-300">→</span>
            </a>

            <a href="/admin-events" class="group flex items-center justify-between p-4 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-lg transition">
                <div class="flex items-center gap-4">
                    <span class="text-2xl">📅</span>
                    <span class="font-bold text-slate-700 group-hover:text-blue-600">Event Scheduling</span>
                </div>
                <span class="text-slate-300">→</span>
            </a>

            <a href="/admin-learn" class="group flex items-center justify-between p-4 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-lg transition">
                <div class="flex items-center gap-4">
                    <span class="text-2xl">📚</span>
                    <span class="font-bold text-slate-700 group-hover:text-blue-600">Learning Library</span>
                </div>
                <span class="text-slate-300">→</span>
            </a>

            <a href="/admin-achievements" class="group flex items-center justify-between p-4 bg-white border border-slate-200 rounded-2xl hover:border-blue-400 hover:shadow-lg transition">
                <div class="flex items-center gap-4">
                    <span class="text-2xl">🏆</span>
                    <span class="font-bold text-slate-700 group-hover:text-blue-600">Medal Registry</span>
                </div>
                <span class="text-slate-300">→</span>
            </a>
        </div>

        <!-- Pending Approvals Column -->
        <div class="lg:col-span-2">
            <h2 class="text-lg font-black text-slate-900 mb-6 uppercase tracking-tight">Pending Registrations</h2>

            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            <div class="space-y-4">
                @forelse($pendingPlayers as $player)
                    <div class="bg-white border border-slate-200 p-6 rounded-3xl shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div>
                            <div class="flex items-center gap-2 mb-1">
                                <h3 class="text-xl font-black text-slate-900">{{ $player->name }}</h3>
                                <span class="bg-amber-100 text-amber-700 px-2 py-0.5 rounded text-[10px] font-bold uppercase tracking-widest">New</span>
                            </div>
                            <div class="grid grid-cols-2 gap-x-6 gap-y-1 text-sm text-slate-500">
                                <p><strong>Email:</strong> {{ $player->email }}</p>
                                <p><strong>Phone:</strong> {{ $player->phone }}</p>
                                <p><strong>Category:</strong> {{ $player->category }}</p>
                                <p><strong>Age:</strong> {{ $player->age_group }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 w-full md:w-auto">
                            <form action="{{ route('admin.approve', $player->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white px-4 py-2.5 rounded-xl font-bold text-sm transition shadow-lg shadow-emerald-600/20">Approve</button>
                            </form>
                            <button class="bg-slate-100 hover:bg-slate-200 text-slate-600 px-4 py-2.5 rounded-xl font-bold text-sm transition">Details</button>
                        </div>
                    </div>
                @empty
                    <div class="bg-slate-50 border-2 border-dashed border-slate-200 p-12 text-center rounded-3xl">
                        <p class="text-slate-400 font-bold uppercase tracking-widest">No pending tasks</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</main>
@endsection
