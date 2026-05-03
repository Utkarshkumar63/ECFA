@extends('layouts.app')

@section('title', 'Arsenal Management - ECFA')

@section('content')
<div class="min-h-screen bg-slate-50">
    <header class="relative overflow-hidden bg-slate-900 pt-32 pb-20 px-6 border-b border-white/5">
        <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 300px; filter: grayscale(100%);"></div>
        <div class="relative max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
            <div class="text-center md:text-left">
                <div class="flex items-center justify-center md:justify-start gap-2 mb-4">
                    <span class="h-2 w-2 rounded-full bg-indigo-500 animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-[0.4em] text-indigo-400">Tactical Command</span>
                </div>
                <h1 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter leading-none">
                    Training <span class="text-indigo-500 not-italic">Arsenal</span>
                </h1>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-white/5 hover:bg-white/10 text-white border border-white/10 px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest transition-all">
                ← Command Center
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6 -mt-10 pb-32">
        <div class="grid lg:grid-cols-12 gap-10">

            <!-- UPLOAD/GENERATE MODULE -->
            <div class="lg:col-span-4">
                <div class="sticky top-28 bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 overflow-hidden">
                    <div class="bg-indigo-600 p-8 text-white">
                        <h2 class="text-2xl font-black tracking-tighter uppercase italic">Deploy</h2>
                        <p class="text-indigo-100 text-[10px] font-bold uppercase tracking-widest mt-1">Manual Input or File Upload</p>
                    </div>

                    <form action="/admin/learn/upload" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Document Title</label>
                            <input type="text" name="title" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 focus:border-indigo-500 outline-none font-bold text-slate-700 text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Weapon</label>
                                <select name="weapon" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-4 focus:border-indigo-500 outline-none font-bold text-slate-700 text-sm">
                                    <option value="Foil">Foil</option>
                                    <option value="Epee">Épée</option>
                                    <option value="Sabre">Sabre</option>
                                    <option value="General">General</option>
                                </select>
                            </div>
                            <div class="space-y-2">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Event Link</label>
                                <select name="event_id" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-4 focus:border-indigo-500 outline-none font-bold text-slate-700 text-sm">
                                    <option value="">None</option>
                                    @foreach($events as $event)
                                        <option value="{{ $event->id }}">{{ $event->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
 

                        <div class="relative py-2 text-center">
                            <span class="bg-white px-4 text-[9px] font-black text-slate-300 uppercase italic tracking-widest">OR ATTACH PDF</span>
                            <div class="absolute inset-y-1/2 left-0 w-full h-[1px] bg-slate-100 -z-10"></div>
                        </div>

                        <input type="file" name="pdf" accept=".pdf" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100">

                        <button type="submit" class="w-full bg-slate-900 hover:bg-indigo-600 text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] transition-all shadow-xl active:scale-95">
                            Initialize Deployment
                        </button>
                    </form>
                </div>
            </div>

            <!-- REGISTRY LISTING -->
            <div class="lg:col-span-8 space-y-6">
                <h2 class="text-3xl font-black text-slate-900 tracking-tighter uppercase italic">Arsenal <span class="text-indigo-500 not-italic">Registry</span></h2>

                @if(session('success'))
                    <div class="p-4 bg-emerald-50 text-emerald-700 rounded-2xl font-bold text-xs border border-emerald-100 italic">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                <div class="grid gap-4">
                    @forelse($materials as $item)
                        <div class="group bg-white border border-slate-100 p-6 rounded-[2.5rem] shadow-xl hover:border-indigo-200 transition-all flex flex-col md:flex-row items-center justify-between gap-6">
                            <div class="flex items-center gap-6">
                                <div class="h-14 w-14 bg-slate-50 rounded-2xl flex items-center justify-center text-2xl group-hover:bg-indigo-600 transition duration-300">
                                    {{ $item->material_type == 'generated' ? '✍️' : '📄' }}
                                </div>
                                <div>
                                    <div class="flex items-center gap-2 mb-1">
                                        <h3 class="text-lg font-black text-slate-900 uppercase tracking-tighter">{{ $item->title }}</h3>
                                        <span class="bg-indigo-50 text-indigo-600 px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest border border-indigo-100">{{ $item->weapon }}</span>
                                    </div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                        Arena: <span class="text-slate-600 italic">{{ $item->event->title ?? 'General' }}</span> • {{ $item->created_at->format('d M Y') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
 {{-- Is button ko change karein --}}
<a href="{{ route('admin.learn.view', $item->id) }}"
   target="_blank"
   class="px-6 py-3 bg-slate-900 text-white rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-600 transition">
   Review Intelligence
</a>                                <form action="/admin/learn/delete/{{ $item->id }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button class="p-3 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white border-4 border-dashed border-slate-100 p-20 text-center rounded-[3.5rem]">
                            <p class="text-slate-300 font-black uppercase tracking-[0.3em]">No Assets Deployed</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </main>
</div>
@endsection
