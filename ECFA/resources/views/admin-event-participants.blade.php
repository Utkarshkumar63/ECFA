@extends('layouts.app')

@section('title', 'Event Participants - ECFA')

@section('content')
<div class="min-h-screen bg-[#f8fafc] pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- 1. Stats Overview Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 flex items-center gap-5">
                <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Total Participants</p>
                    <h3 class="text-2xl font-black text-slate-900">{{ $event->athletes->count() }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 flex items-center gap-5">
                <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center text-emerald-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div>
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Selected Athletes</p>
                    <h3 class="text-2xl font-black text-emerald-600">{{ $event->athletes->where('pivot.status', 'selected')->count() }}</h3>
                </div>
            </div>

            <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-xl shadow-slate-200/50 flex items-center gap-5">
                <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center text-amber-600">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4 2.222"></path></svg>
                </div>
                <div>
                    @php $certifiedCount = \App\Models\Certificate::where('event_id', $event->id)->count(); @endphp
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Certificates Issued</p>
                    <h3 class="text-2xl font-black text-amber-600">{{ $certifiedCount }}</h3>
                </div>
            </div>
        </div>

        <!-- 2. Header Actions Section -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">
                    Event Registry: <span class="text-blue-600">{{ $event->title }}</span>
                </h1>
                <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mt-2">Manage selection and issue digital honors</p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.event.participants.pdf', [$event->id, 'status' => request('status')]) }}"
                   class="bg-slate-900 hover:bg-black text-white px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition flex items-center gap-2 shadow-xl">
                    <svg class="h-4 w-4 text-brand-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    Export {{ request('status') ?: 'Full' }} List
                </a>
                <a href="{{ route('admin.events') }}" class="bg-white border border-slate-200 text-slate-600 px-6 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest transition hover:bg-slate-50">
                    Exit Registry
                </a>
            </div>
        </div>

        <!-- 3. Filter Tabs -->
        <div class="flex items-center gap-3 mb-8 bg-white p-2 rounded-2xl border border-slate-100 shadow-sm w-fit">
            @foreach(['all' => null, 'selected' => 'selected', 'waiting' => 'waiting'] as $label => $val)
                <a href="{{ route('admin.event.participants', [$event->id, 'status' => $val]) }}"
                   class="px-5 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest transition-all {{ request('status') == $val ? 'bg-blue-600 text-white shadow-lg shadow-blue-100' : 'text-slate-400 hover:text-slate-600' }}">
                   {{ ucfirst($label) }}
                </a>
            @endforeach
        </div>

        <!-- 4. Main Participants Table -->
        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-slate-200/60 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 text-slate-400 border-b border-slate-100">
                            <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Athlete</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest">Category</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest">Status</th>
                            <th class="px-6 py-5 text-[10px] font-black uppercase tracking-widest text-right">Actions / Certification</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($event->athletes as $player)
                        @php
                            // Check if certificate exists for this specific event and user
                            $cert = \App\Models\Certificate::where('user_id', $player->id)->where('event_id', $event->id)->first();
                        @endphp
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <!-- Athlete Basic Info -->
                            <td class="px-8 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-slate-100 to-slate-200 flex items-center justify-center font-black text-slate-500 text-xs">
                                        {{ substr($player->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-black text-slate-900 uppercase italic tracking-tight">{{ $player->name }}</div>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $player->phone }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Category & Group -->
                            <td class="px-6 py-6 text-sm">
                                <span class="bg-blue-50 text-blue-600 px-3 py-1 rounded-lg text-[9px] font-black uppercase tracking-widest border border-blue-100">
                                    {{ $player->category }}
                                </span>
                                <div class="mt-1 text-[10px] font-bold text-slate-400">{{ $player->age_group }}</div>
                            </td>

                            <!-- App Status -->
                            <td class="px-6 py-6">
                                @if($player->is_approved)
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black uppercase text-emerald-500 bg-emerald-50 px-2.5 py-1 rounded-full border border-emerald-100">
                                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span> Active Account
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-black uppercase text-amber-500 bg-amber-50 px-2.5 py-1 rounded-full border border-amber-100">
                                        Pending Review
                                    </span>
                                @endif
                            </td>

                            <!-- Right Action Area (THE LOGIC UPDATE) -->
                            <td class="px-8 py-6">
                                <div class="flex items-center justify-end gap-3">

                                    {{-- Logical Flow: 1. Is selected? -> 2. Is certified? --}}
                                    @if($player->pivot->status == 'selected')

                                        @if($cert)
                                            {{-- Case: Selected and Certificate Generated --}}
                                            <div class="flex items-center gap-3">
                                                <div class="text-right">
                                                    <p class="text-[9px] font-black text-emerald-600 uppercase italic tracking-widest leading-none">Certified</p>
                                                    <p class="text-[8px] text-slate-400 font-bold uppercase tracking-tighter">{{ $cert->cert_id }}</p>
                                                </div>
                                                <a href="{{ route('cert.verify', ['cert_id' => $cert->cert_id, 'hash' => $cert->verification_hash]) }}" target="_blank"
                                                   class="bg-blue-600 hover:bg-blue-700 text-white p-2.5 rounded-xl transition shadow-lg shadow-blue-100" title="View Certificate">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                                </a>
                                            </div>
                                        @else
                                            {{-- Case: Selected but Certificate NOT Generated Yet --}}
                                            <form action="{{ route('admin.issue.cert', [$event->id, $player->id]) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-xl text-[9px] font-black uppercase tracking-widest transition flex items-center gap-2 shadow-lg shadow-amber-100">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    Generate Certificate
                                                </button>
                                            </form>
                                        @endif

                                    @else
                                        {{-- Case: Not Selected --}}
                                        <form action="{{ route('admin.event.participant.approve', [$event->id, $player->id]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="bg-emerald-500 hover:bg-emerald-600 text-white p-2.5 rounded-xl transition shadow-lg shadow-emerald-100 flex items-center gap-2 text-[9px] font-black uppercase tracking-widest px-4">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" /></svg>
                                                Select Athlete
                                            </button>
                                        </form>
                                    @endif

                                    <!-- Always show Remove Button -->
                                    <form action="{{ route('admin.event.participant.reject', [$event->id, $player->id]) }}" method="POST" onsubmit="return confirm('Remove athlete from registry?')">
                                        @csrf
                                        <button type="submit" class="bg-slate-100 hover:bg-rose-50 text-slate-400 hover:text-rose-600 p-2.5 rounded-xl transition">
                                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-32 text-center">
                                <div class="bg-slate-50 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-6">
                                    <svg class="w-10 h-10 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-xs italic">No Registry Records Found</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
