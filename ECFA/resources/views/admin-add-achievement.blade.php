@extends('layouts.app')

@section('content')
<!-- Tom Select CSS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">

<div class="bg-[#f8fafc] min-h-screen py-12">
    <div class="max-w-4xl mx-auto px-4">

        <!-- Breadcrumb -->
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-indigo-600 transition flex items-center gap-2">
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"/></svg>
                Back to Command Center
            </a>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-indigo-100/50 overflow-hidden border border-slate-100">
            <!-- Header -->
            <div class="p-10 bg-[#0f172a] text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-2">
                        <span class="bg-indigo-500 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Administrator</span>
                        <span class="h-px w-12 bg-indigo-500/30"></span>
                    </div>
                    <h2 class="text-3xl font-black italic uppercase tracking-tighter leading-none">Issue Athlete Honors</h2>
                    <p class="text-slate-400 text-xs mt-3 font-medium">Record achievements and deploy digital certificates to the registry.</p>
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-10">
                    <svg class="w-64 h-64 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M21 7.1c-.2-.2-.5-.3-.8-.1l-2.6 1.7-2.9-2.9 1.7-2.6c.2-.3.1-.6-.1-.8s-.6-.2-.8.1l-2.7 4.1-3.6-3.6c-1.1-1.1-3-1.1-4.1 0l-1.4 1.4c-1.1 1.1-1.1 3 0 4.1l3.6 3.6-4.1 2.7c-.3.2-.3.5-.1.8.1.1.3.2.5.2.1 0 .2 0 .3-.1l2.6-1.7 2.9 2.9-1.7 2.6c-.2.3-.1.6.1.8.1.1.3.2.5.2.1 0 .2 0 .3-.1l2.7-4.1 3.6 3.6c.5.5 1.3.8 2 .8s1.5-.3 2-.8l1.4-1.4c1.2-1.1 1.2-2.9.1-4.1z"/></svg>
                </div>
            </div>

            <div class="p-10">
                @if(session('success'))
                    <div class="mb-8 p-5 bg-emerald-50 border border-emerald-100 rounded-2xl flex items-center gap-4">
                        <p class="text-emerald-800 text-sm font-black uppercase">{{ session('success') }}</p>
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-8 p-5 bg-rose-50 border border-rose-100 rounded-2xl">
                        <ul class="text-rose-600 text-xs font-bold uppercase space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.achievement.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

                        <!-- Global Athlete Search -->
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] block mb-3 ml-1">Search Athlete</label>
                            <select id="player_search" name="user_id" placeholder="Start typing to search..." autocomplete="off" required>
                                <option value="">Type to search athlete...</option>
                                @foreach($players as $player)
                                    <option value="{{ $player->id }}">
                                        {{ $player->name }} | {{ $player->phone }} | ID: {{ $player->id }} | Category: {{ strtoupper($player->category) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- NEW: Achievement Title -->
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] block mb-3 ml-1">Achievement Title</label>
                            <input type="text" name="title" placeholder="e.g. Winner / Runner Up" required
                                class="w-full px-6 py-5 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 transition-all outline-none font-bold text-slate-700 bg-slate-50/50">
                        </div>

                        <!-- NEW: Level Dropdown -->
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] block mb-3 ml-1">Championship Level</label>
                            <select name="level" required class="w-full px-6 py-5 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 transition-all outline-none font-black text-slate-700 bg-slate-50/50">
                                <option value="District">District Level</option>
                                <option value="State">State Level</option>
                                <option value="National">National Level</option>
                                <option value="International">International Level</option>
                            </select>
                        </div>

                        <!-- Event Name -->
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] block mb-3 ml-1">Tournament / Event Name</label>
                            <input type="text" name="event_name" placeholder="e.g. State Level Open Fencing Championship 2024" required
                                class="w-full px-6 py-5 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 transition-all outline-none font-bold text-slate-700 bg-slate-50/50">
                        </div>

                        <!-- Medal Type -->
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] block mb-3 ml-1">Rank / Medal</label>
                            <select name="medal_type" required class="w-full px-6 py-5 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 transition-all outline-none font-black text-slate-700 bg-slate-50/50">
                                <option value="Gold">Gold Medal 🥇</option>
                                <option value="Silver">Silver Medal 🥈</option>
                                <option value="Bronze">Bronze Medal 🥉</option>
                                <option value="Participation">Participation 📜</option>
                            </select>
                        </div>

                        <!-- Date -->
                        <div>
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] block mb-3 ml-1">Award Date</label>
                            <input type="date" name="achievement_date" required
                                class="w-full px-6 py-5 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 transition-all outline-none font-bold text-slate-600 bg-slate-50/50">
                        </div>

                        <!-- Upload File -->
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-black uppercase text-slate-400 tracking-[0.2em] block mb-3 ml-1">Digital Certificate</label>
                            <div class="relative border-2 border-dashed border-slate-200 rounded-[2rem] p-10 text-center hover:bg-indigo-50/50 transition-all group">
                                <input type="file" name="certificate" id="cert_upload" required class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                <div class="space-y-4 relative z-10">
                                    <div class="bg-white w-16 h-16 rounded-2xl shadow-xl flex items-center justify-center mx-auto border border-slate-100">
                                        <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                                    </div>
                                    <div id="file-name" class="text-sm text-slate-500 font-bold uppercase">Click to browse or drag file</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-[#0f172a] hover:bg-black text-white font-black py-6 rounded-2xl shadow-2xl transition-all transform hover:-translate-y-1 active:scale-95 uppercase italic tracking-widest">
                        Issue Honor to Registry
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script>
    new TomSelect("#player_search", { create: false });
    document.getElementById('cert_upload').onchange = function() {
        if(this.files[0]) document.getElementById('file-name').innerText = "Selected: " + this.files[0].name;
    };
</script>
@endsection
