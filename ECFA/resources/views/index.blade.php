@extends('layouts.app')

@section('title', 'ECFA - Forging Fencing Champions in Bihar')

@section('content')
<!-- 1. HERO SECTION (Refined) -->
<section class="relative min-h-[85vh] flex items-center overflow-hidden bg-brand-dark text-white">
    <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: cover; background-position: center;"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-brand-dark/50 via-brand-dark to-brand-dark"></div>

    <div class="relative z-10 mx-auto max-w-7xl px-5 w-full grid lg:grid-cols-2 gap-12 items-center">
        <div class="text-center lg:text-left">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 mb-6">
                <span class="w-2 h-2 bg-brand-gold rounded-full animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-[0.2em] text-brand-gold">Foil • Epee • Sabre</span>
            </div>
            <h1 class="text-5xl md:text-7xl font-black tracking-tighter leading-[0.9] mb-6 italic uppercase">
                Swift. Silent.<br><span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-gold to-yellow-200">Supreme.</span>
            </h1>
            <p class="text-slate-400 text-lg font-medium max-w-lg mb-10 leading-relaxed mx-auto lg:mx-0">
                The official governing body for fencing in East Champaran. Transforming raw talent into state & national icons.
            </p>
            <div class="flex flex-wrap gap-4 justify-center lg:justify-start">
                <a href="{{ url('/registration') }}" class="px-8 py-4 bg-brand-gold text-brand-dark rounded-2xl font-black uppercase text-[11px] tracking-widest hover:scale-105 transition shadow-xl shadow-brand-gold/20">Join Registry</a>
                <a href="{{ url('/about') }}" class="px-8 py-4 bg-white/5 border border-white/10 rounded-2xl font-black uppercase text-[11px] tracking-widest hover:bg-white/10 transition">Our Legacy</a>
                <a href="{{ url('/verify-certificate') }}" class="px-8 py-4 bg-white/5 border border-white/10 rounded-2xl font-black uppercase text-[11px] tracking-widest hover:bg-white/10 transition">Verify Certificate</a>
            </div>
        </div>

        <div class="hidden lg:block relative group">
            <div class="absolute -inset-4 bg-brand-gold/20 blur-3xl rounded-full opacity-50 group-hover:opacity-100 transition duration-1000"></div>
            <img src="{{ asset('images/logo.png') }}" class="relative w-[950px] h-[330px] object-cover rounded-[3rem] border-4 border-white/10 shadow-2xl mx-auto rotate-3 hover:rotate-0 transition-all duration-700">
        </div>
    </div>
</section>

<!-- 2. STATS SECTION (4 Small Attractive Cards 🔥) -->
<section class="relative z-20 -mt-12 px-5">
    <div class="mx-auto max-w-5xl grid grid-cols-2 md:grid-cols-4 gap-4">
        <!-- Athletes -->
        <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-50 text-center transform hover:-translate-y-2 transition duration-300">
            <div class="text-blue-600 mb-2 flex justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            </div>
            <h3 class="text-3xl font-black text-brand-dark tracking-tighter">500+</h3>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Elite Athletes</p>
        </div>
        <!-- Events -->
        <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-50 text-center transform hover:-translate-y-2 transition duration-300">
            <div class="text-amber-500 mb-2 flex justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-3xl font-black text-brand-dark tracking-tighter">{{ $eventCount ?? 0 }}</h3>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Annual Events</p>
        </div>
        <!-- Medals -->
        <div class="bg-white p-6 rounded-3xl shadow-xl border border-slate-50 text-center transform hover:-translate-y-2 transition duration-300">
            <div class="text-yellow-600 mb-2 flex justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path></svg>
            </div>
            <h3 class="text-3xl font-black text-brand-dark tracking-tighter">{{ $medalCount ?? 0 }}</h3>
            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Honors Won</p>
        </div>
        <!-- Ranking -->
        <div class="bg-brand-gold p-6 rounded-3xl shadow-2xl border border-brand-gold text-center transform hover:-translate-y-2 transition duration-300">
            <div class="text-brand-dark mb-2 flex justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="text-xl font-black text-brand-dark tracking-tighter uppercase italic">Top 5</h3>
            <p class="text-[9px] font-black text-brand-dark/60 uppercase tracking-widest mt-1">Bihar Rank</p>
        </div>
    </div>
</section>

<!-- 3. ABOUT ECFA (Short & Impactful) -->
<section class="py-24 px-5">
    <div class="mx-auto max-w-7xl grid lg:grid-cols-2 gap-16 items-center">
        <div>
            <span class="text-blue-600 font-black text-[10px] uppercase tracking-[0.4em] mb-4 block">Official Governance</span>
            <h2 class="text-4xl md:text-5xl font-black text-brand-dark tracking-tighter uppercase mb-6 italic">Forging <span class="text-blue-600">Champions</span></h2>
            <p class="text-slate-600 text-lg leading-relaxed mb-8">
                The East Champaran Fencing Association (ECFA) is dedicated to nurturing raw talent from the heart of Bihar. Our goal is to provide elite coaching and a global competitive edge to every athlete.
            </p>

            <div class="flex items-center gap-6 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                <div class="flex-shrink-0 w-12 h-12 bg-white rounded-xl shadow-md flex items-center justify-center font-black text-brand-gold">500+</div>
                <p class="text-xs font-bold text-slate-500 uppercase leading-snug">Athletes have transitioned from district enthusiasts to state champions under our guidance.</p>
            </div>
        </div>

        <div class="grid gap-6">
            <!-- Vision Card -->
            <div class="bg-brand-dark p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-white/5 rounded-full group-hover:scale-150 transition duration-700"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-brand-gold rounded-2xl flex items-center justify-center text-brand-dark mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase italic tracking-tighter mb-3">Our Vision</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">To make East Champaran a globally recognized hub for fencing by fostering an environment of peak performance and Olympic values.</p>
                </div>
            </div>

            <!-- Mission Card -->
            <div class="bg-blue-600 p-8 rounded-[2.5rem] text-white shadow-2xl relative overflow-hidden group">
                <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-black/10 rounded-full group-hover:scale-150 transition duration-700"></div>
                <div class="relative z-10">
                    <div class="w-12 h-12 bg-white rounded-2xl flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-2xl font-black uppercase italic tracking-tighter mb-3">Our Mission</h3>
                    <ul class="text-blue-100 text-sm space-y-2 font-medium">
                        <li class="flex items-center gap-2">✓ Modern training facilities</li>
                        <li class="flex items-center gap-2">✓ Scout rural talent early</li>
                        <li class="flex items-center gap-2">✓ Absolute discipline & fair play</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 4. WEAPONS SECTION (Small & Visual) -->
<section class="bg-slate-50 py-24 px-5">
    <div class="mx-auto max-w-7xl">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-brand-dark uppercase tracking-tighter italic">Combat <span class="text-blue-600">Disciplines</span></h2>
        </div>
        <div class="grid md:grid-cols-3 gap-6">
            @php
                $weapons = [
                    ['name' => 'Foil', 'desc' => 'A light thrusting weapon targeting only the torso.', 'color' => 'bg-amber-50'],
                    ['name' => 'Épée', 'desc' => 'The heaviest weapon where the entire body is a target.', 'color' => 'bg-blue-50'],
                    ['name' => 'Sabre', 'desc' => 'A fast cutting and thrusting weapon targeting above the waist.', 'color' => 'bg-slate-100']
                ];
            @endphp
            @foreach($weapons as $w)
                <div class="{{ $w['color'] }} p-8 rounded-[2rem] border border-slate-200 group hover:shadow-xl transition">
                    <h4 class="text-xl font-black uppercase italic mb-2">{{ $w['name'] }}</h4>
                    <p class="text-xs text-slate-500 font-bold leading-relaxed">{{ $w['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

<!-- 5. TOURNAMENT ARENA (Horizontal Scroll or Grid) -->
<section class="py-24 px-5">
    <div class="mx-auto max-w-7xl">
        <div class="flex justify-between items-end mb-12">
            <h2 class="text-4xl font-black text-brand-dark uppercase tracking-tighter italic">Tournament <span class="text-amber-500">Arena</span></h2>
            <a href="{{ url('/events') }}" class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 hover:text-brand-dark">Full Calendar →</a>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($events as $event)
                <div class="group bg-white rounded-[2.5rem] overflow-hidden shadow-lg border border-slate-100 hover:shadow-2xl transition duration-500">
                    <div class="h-56 overflow-hidden relative">
                        <img src="{{ $event->image }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                        <div class="absolute top-4 right-4 px-4 py-2 bg-brand-gold rounded-xl font-black text-[10px] uppercase shadow-lg">{{ \Carbon\Carbon::parse($event->event_date)->format('d M') }}</div>
                    </div>
                    <div class="p-8">
                        <h3 class="text-xl font-black uppercase italic mb-4">{{ $event->title }}</h3>
                        <a href="{{ url('/events') }}" class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-blue-600 group-hover:translate-x-2 transition">Registration Details →</a>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border border-dashed border-slate-300">
                    <p class="text-slate-400 font-black uppercase tracking-widest text-sm">No Upcoming Arena Matches</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- 6. FINAL CTA -->
<section class="pb-24 px-5">
    <div class="mx-auto max-w-5xl bg-gradient-to-br from-blue-700 to-indigo-900 rounded-[3rem] p-12 md:p-20 text-center text-white relative overflow-hidden shadow-2xl">
        <div class="relative z-10">
            <h2 class="text-4xl md:text-5xl font-black italic uppercase tracking-tighter mb-6">Ready to Duel?</h2>
            <p class="text-blue-100 mb-10 max-w-xl mx-auto font-medium">Join the elite fencing fraternity. National-grade facilities and championship coaching await you.</p>
            <a href="{{ url('/registration') }}" class="inline-block bg-white text-blue-700 px-12 py-5 rounded-[2rem] font-black uppercase text-xs tracking-widest hover:bg-brand-gold hover:text-brand-dark transition transform hover:-translate-y-1">Start Training Today</a>
        </div>
    </div>
</section>

<style>
    @keyframes float {
        0%, 100% { transform: translateY(0) rotate(3deg); }
        50% { transform: translateY(-15px) rotate(1deg); }
    }
    .animate-float { animation: float 6s ease-in-out infinite; }
</style>
@endsection
