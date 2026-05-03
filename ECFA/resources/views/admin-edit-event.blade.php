@extends('layouts.app')

@section('title', 'Modify Arena Intel - ECFA')

@section('content')
<div class="min-h-screen bg-[#f8fafc]">
    <!-- Elite Header -->
    <header class="relative overflow-hidden bg-[#0f172a] pt-32 pb-24 px-6">
        <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 350px; filter: grayscale(100%);"></div>

        <div class="relative max-w-4xl mx-auto text-center">
            <div class="flex items-center justify-center gap-3 mb-4">
                <span class="text-[10px] font-black uppercase tracking-[0.5em] text-blue-400">Tactical Re-deployment</span>
            </div>
            <h1 class="text-4xl md:text-6xl font-black text-white italic uppercase tracking-tighter leading-none">
                Edit <span class="text-blue-500 not-italic">Arena</span>
            </h1>
            <p class="mt-4 text-slate-400 font-medium italic text-lg">Modifying Intel for: {{ $event->title }}</p>
        </div>
    </header>

    <main class="max-w-3xl mx-auto px-6 -mt-12 pb-32">
        <div class="bg-white rounded-[3rem] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden">

            <!-- Form Header -->
            <div class="bg-slate-900 p-8 text-white flex justify-between items-center">
                <div>
                    <h2 class="text-xl font-black tracking-tighter uppercase italic">Update Records</h2>
                    <p class="text-[9px] font-bold uppercase tracking-[0.2em] text-slate-400">UID: EVT-00{{ $event->id }}</p>
                </div>
                <a href="{{ route('admin.events') }}" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-white transition">
                    Cancel & Return
                </a>
            </div>

            <form action="{{ route('admin.event.update', $event->id) }}" method="POST" class="p-10 space-y-8">
                @csrf
                <!-- Note: Aapne route mein POST rakha hai to method="POST" hi rahega -->

                <!-- Title -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tournament Title</label>
                    <input type="text" name="title" value="{{ old('title', $event->title) }}" required
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 outline-none focus:border-blue-500 focus:bg-white font-bold text-slate-700 transition-all text-sm">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Event Date -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Event Date</label>
                        <input type="date" name="event_date" value="{{ old('event_date', \Carbon\Carbon::parse($event->event_date)->format('Y-m-d')) }}" required
                            class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-4 outline-none focus:border-blue-500 focus:bg-white font-bold text-slate-700 text-sm">
                    </div>

                    <!-- Location -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Location</label>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}" required
                            class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-4 outline-none focus:border-blue-500 focus:bg-white font-bold text-slate-700 text-sm">
                    </div>
                </div>

                <!-- Status Selection -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Mission Status</label>
                    <select name="status" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 outline-none focus:border-blue-500 focus:bg-white font-bold text-slate-700 transition-all text-sm appearance-none">
                        <option value="upcoming" {{ $event->status == 'upcoming' ? 'selected' : '' }}>Upcoming (Registration Open)</option>
                        <option value="completed" {{ $event->status == 'completed' ? 'selected' : '' }}>Completed (Archived)</option>
                        <option value="cancelled" {{ $event->status == 'cancelled' ? 'selected' : '' }}>Cancelled (Mission Aborted)</option>
                    </select>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Intel (Description)</label>
                    <textarea name="description" rows="4" required
                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-4 outline-none focus:border-blue-500 focus:bg-white font-bold text-slate-700 text-sm leading-relaxed">{{ old('description', $event->description) }}</textarea>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 flex flex-col md:flex-row gap-4">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-6 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.4em] transition-all shadow-xl shadow-blue-200 active:scale-95 flex items-center justify-center gap-3">
                        Save Changes <span>→</span>
                    </button>

                    <a href="{{ route('admin.events') }}" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-600 py-6 rounded-[2rem] font-black text-[11px] uppercase tracking-[0.4em] transition-all text-center flex items-center justify-center">
                        Back to Registry
                    </a>
                </div>
            </form>
        </div>
    </main>
</div>
@endsection
