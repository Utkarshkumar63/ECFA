@extends('layouts.app')

@section('title', 'Athlete Registry - ECFA')

@section('content')
<div class="min-h-screen bg-[#f8fafc] pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 uppercase italic tracking-tighter">
                    Athlete <span class="text-blue-600">Registry</span>
                </h1>
                <p class="text-slate-500 font-medium">Total: {{ $players->total() }} Athletes Found</p>
            </div>

            <a href="{{ route('admin.dashboard') }}" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 transition shadow-xl shadow-slate-200">
                ← Command Center
            </a>
        </div>

        <!-- SEARCH & FILTERS ROW -->
        <div class="flex flex-col lg:flex-row justify-between items-center gap-6 mb-8">
            <div class="flex flex-wrap gap-2 w-full lg:w-auto">
                <a href="{{ route('admin.players', ['status' => '', 'search' => request('search')]) }}"
                   class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition {{ !request('status') ? 'bg-blue-600 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-100 hover:bg-slate-50' }}">
                   All
                </a>
                <a href="{{ route('admin.players', ['status' => 'pending', 'search' => request('search')]) }}"
                   class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition {{ request('status') == 'pending' ? 'bg-amber-500 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-100 hover:bg-slate-50' }}">
                   Pending
                </a>
                <a href="{{ route('admin.players', ['status' => 'approved', 'search' => request('search')]) }}"
                   class="px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest transition {{ request('status') == 'approved' ? 'bg-emerald-500 text-white shadow-lg' : 'bg-white text-slate-400 border border-slate-100 hover:bg-slate-50' }}">
                   Approved
                </a>
            </div>

            <div class="w-full lg:w-96">
                <form action="{{ route('admin.players') }}" method="GET" class="relative group">
                    <input type="hidden" name="status" value="{{ request('status') }}">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search by Name, Email or Phone..."
                           class="w-full bg-white border-2 border-slate-100 rounded-2xl px-6 py-3.5 pl-12 outline-none focus:border-blue-500 font-bold text-slate-700 transition-all text-xs">
                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-blue-500 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </form>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-2xl font-bold text-sm flex items-center gap-3">
                <span class="bg-emerald-500 text-white rounded-full h-5 w-5 flex items-center justify-center text-[10px]">✓</span>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-[2.5rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-900 text-white">
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Athlete Details</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Contact Info</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Category / Level</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Address</th>
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($players as $player)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="h-12 w-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center font-black text-lg border border-blue-100 group-hover:scale-110 transition duration-300">
                                        {{ substr($player->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-800 text-base uppercase tracking-tight">{{ $player->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-0.5">
                                            {{ $player->gender }} • DOB: {{ $player->dob }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="text-sm font-bold text-slate-600 lowercase">{{ $player->email }}</div>
                                <div class="text-sm font-black text-blue-600">{{ $player->phone }}</div>
                            </td>

                            <td class="px-8 py-6">
                                <span class="inline-block bg-blue-50 text-blue-700 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest mb-1 border border-blue-100">
                                    {{ $player->category }}
                                </span>
                                <div class="text-xs font-bold text-slate-400 italic">{{ $player->experience }} level</div>
                            </td>

                            <td class="px-8 py-6">
                                <div class="text-xs font-bold text-slate-600 leading-tight">
                                    {{ $player->city }}, {{ $player->state }}<br>
                                    <span class="text-[10px] text-slate-400 uppercase font-black">PIN: {{ $player->pincode }}</span>
                                </div>
                            </td>

                            <td class="px-8 py-6 text-right">
                                <div class="flex items-center justify-end gap-3">
                                    <!-- VIEW / EDIT BUTTON -->
                                    <a href="{{ route('admin.player.edit', $player->id) }}" class="p-2.5 bg-blue-50 text-blue-500 hover:bg-blue-600 hover:text-white rounded-xl transition border border-blue-100 shadow-sm" title="View & Edit Details">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @if(!$player->is_approved)
                                        <form action="{{ route('admin.player.approve', $player->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition shadow-lg shadow-emerald-100">
                                                Approve
                                            </button>
                                        </form>
                                    @else
                                        <div class="bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100">
                                            <span class="text-emerald-600 text-[10px] font-black uppercase tracking-widest">Verified</span>
                                        </div>
                                    @endif

                                    <form action="{{ route('admin.player.delete', $player->id) }}" method="POST" onsubmit="return confirm('CRITICAL: Permanently delete this athlete record?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-rose-50 text-rose-500 hover:bg-rose-500 hover:text-white rounded-xl transition border border-rose-100 shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-8 py-24 text-center font-black text-slate-300 uppercase">No matching athletes found</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-8 bg-slate-50 border-t border-slate-100">
                {{ $players->appends(request()->input())->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
