@extends('layouts.app')

@section('content')
<!-- Professional Libraries -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<script src="https://unpkg.com/tesseract.js@v5.0.0/dist/tesseract.min.js"></script>

<div class="bg-white min-h-screen py-10 px-4">
    <div class="max-w-4xl mx-auto">

        <div class="mb-10 flex items-center justify-between border-b border-slate-100 pb-6">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter">Issue Honors</h1>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.3em]">Official Athlete Registry Center</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-slate-100 p-3 rounded-2xl text-slate-400 hover:text-indigo-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            </a>
        </div>

        <!-- Scanning Loader (Hidden) -->
        <div id="loader" class="hidden fixed inset-0 bg-slate-900/90 z-[999] flex flex-col items-center justify-center text-white">
            <div class="w-12 h-12 border-4 border-indigo-500 border-t-transparent rounded-full animate-spin mb-4"></div>
            <p id="loader-text" class="font-black uppercase tracking-widest text-sm italic">AI Scanning Certificate...</p>
        </div>

        <form action="{{ route('admin.issue.cert.store') }}" method="POST" class="space-y-8" id="issueForm">
            @csrf

            <!-- 1. ATHLETE SELECTION -->
            <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100">
                <label class="text-[10px] font-black uppercase text-indigo-600 tracking-widest mb-4 block">1. Select Target Athlete</label>
                <select id="user_select" name="user_id" required class="w-full">
                    <option value="">Search Athlete Name or ID...</option>
                    @foreach($players as $player)
                        <option value="{{ $player->id }}">{{ $player->name }} | ID: {{ $player->id }}</option>
                    @endforeach
                </select>
            </div>

            <!-- 2. DATA SOURCE -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-slate-50 p-8 rounded-[2.5rem] border border-slate-100">
                    <label class="text-[10px] font-black uppercase text-indigo-600 tracking-widest mb-4 block">2. Connect to System Event (Instant)</label>
                    <select id="event_trigger" class="w-full bg-white border-2 border-slate-100 rounded-2xl px-4 py-4 text-sm font-bold outline-none focus:border-indigo-600 transition">
                        <option value="">-- Manual Entry / External --</option>
                        @foreach(\App\Models\Event::latest()->get() as $event)
                            <option value="{{ $event->id }}"
                                    data-title="{{ $event->title }}"
                                    data-loc="{{ $event->location }}"
                                    data-date="{{ $event->event_date }}">
                                {{ $event->title }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="bg-indigo-900 p-8 rounded-[2.5rem] shadow-xl text-white">
                    <label class="text-[10px] font-black uppercase text-indigo-300 tracking-widest mb-4 block">3. Scan Certificate Photo</label>
                    <input type="file" id="ai_scanner" class="block w-full text-xs text-slate-300 file:mr-4 file:py-3 file:px-6 file:rounded-xl file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-600 file:text-white cursor-pointer">
                </div>
            </div>

            <!-- 3. FORM FIELDS -->
            <div class="bg-white p-8 rounded-[3rem] border-2 border-slate-50 shadow-sm grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="md:col-span-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-2">Tournament / Event Name</label>
                    <input type="text" name="event_name" id="event_name" required placeholder="Ex: Bihar State Fencing Cup" class="w-full bg-slate-50 px-6 py-5 rounded-3xl border-2 border-transparent focus:border-indigo-600 focus:bg-white outline-none font-bold text-slate-700 transition-all uppercase">
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-2">Medal / Achievement</label>
                    <select name="medal_type" id="medal_type" class="w-full bg-slate-50 px-6 py-5 rounded-3xl border-2 border-transparent focus:border-indigo-600 focus:bg-white outline-none font-black text-slate-700 transition-all">
                        <option value="Gold">Gold Medal 🥇</option>
                        <option value="Silver">Silver Medal 🥈</option>
                        <option value="Bronze">Bronze Medal 🥉</option>
                        <option value="Participation">Participation 📜</option>
                    </select>
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-2">Host Venue / Location</label>
                    <input type="text" name="location" id="location" required placeholder="Ex: Patliputra Stadium" class="w-full bg-slate-50 px-6 py-5 rounded-3xl border-2 border-transparent focus:border-indigo-600 focus:bg-white outline-none font-bold text-slate-700 transition-all">
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-2">Organizer Authority</label>
                    <input type="text" name="host_org" id="host_org" required value="East Champaran Fencing Association" class="w-full bg-slate-50 px-6 py-5 rounded-3xl border-2 border-transparent focus:border-indigo-600 focus:bg-white outline-none font-bold text-slate-700 transition-all">
                </div>

                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 block ml-2">Certificate Issue Date</label>
                    <input type="date" name="issue_date" id="issue_date" required class="w-full bg-slate-50 px-6 py-5 rounded-3xl border-2 border-transparent focus:border-indigo-600 focus:bg-white outline-none font-bold text-slate-700 transition-all">
                </div>
            </div>

            <button type="submit" class="w-full bg-slate-900 text-white py-6 rounded-[2.5rem] font-black text-xs uppercase tracking-[0.4em] shadow-2xl hover:bg-black transition-all transform active:scale-95 flex items-center justify-center gap-3">
                Authorize & Publish Certificate
                <svg class="w-5 h-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </button>
        </form>
    </div>
</div>

<script>
    // 1. Safe Initialize Athlete Search
    window.addEventListener('DOMContentLoaded', () => {
        new TomSelect("#user_select", { create: false });
    });

    // 2. Instant Event Auto-Fill (Primary Method)
    document.getElementById('event_trigger').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        if (this.value !== "") {
            document.getElementById('event_name').value = selected.getAttribute('data-title') || '';
            document.getElementById('location').value = selected.getAttribute('data-loc') || '';
            document.getElementById('issue_date').value = selected.getAttribute('data-date') || '';
        }
    });

    // 3. AI Scan Backup (Cleaned up)
    const scanner = document.getElementById('ai_scanner');
    const loader = document.getElementById('loader');

    scanner.addEventListener('change', async (e) => {
        const file = e.target.files[0];
        if(!file) return;

        loader.classList.remove('hidden');

        try {
            const result = await Tesseract.recognize(file, 'eng');
            const text = result.data.text.toLowerCase();

            // Basic Key-word fill
            if(text.includes('gold') || text.includes('1st')) document.getElementById('medal_type').value = 'Gold';
            else if(text.includes('silver') || text.includes('2nd')) document.getElementById('medal_type').value = 'Silver';
            else if(text.includes('bronze') || text.includes('3rd')) document.getElementById('medal_type').value = 'Bronze';

            // Find tournament name
            const lines = result.data.text.split('\n');
            lines.forEach(line => {
                const l = line.toLowerCase();
                if(l.includes('championship') || l.includes('tournament')) {
                    document.getElementById('event_name').value = line.trim();
                }
            });

        } catch (err) {
            console.error("OCR Error:", err);
        } finally {
            setTimeout(() => { loader.classList.add('hidden'); }, 500);
        }
    });
</script>
@endsection
