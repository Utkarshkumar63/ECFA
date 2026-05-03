@extends('layouts.app')

@section('title', 'About Our Legacy')

@section('content')
<!-- Hero Section with Pattern Overlay -->
<section class="relative overflow-hidden bg-slate-900 py-24 text-white">
    <div class="absolute inset-0 opacity-20" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 400px; background-repeat: repeat; filter: grayscale(100%) brightness(50%);"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-blue-900/40 to-slate-900"></div>

    <div class="relative mx-auto max-w-6xl px-4 text-center">
        <span class="inline-block rounded-full bg-amber-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-widest text-amber-500 ring-1 ring-amber-500/20 mb-6">Our Legacy</span>
        <h1 class="text-5xl font-black tracking-tighter md:text-7xl">About <span class="text-amber-400">ECFA</span></h1>
        <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-300">Nurturing champions and promoting the noble art of fencing in the heart of East Champaran.</p>
    </div>
</section>

<!-- History Section: High-End Layout -->
<section class="bg-white py-20">
    <div class="mx-auto max-w-6xl px-4">
        <div class="grid items-center gap-16 md:grid-cols-2">
            <div class="relative">
                <div class="absolute -left-4 -top-4 h-full w-full rounded-3xl bg-amber-400/10"></div>
                <img src="{{ asset('images/logo.jpeg') }}" alt="ECFA History" class="relative z-10 w-full rounded-3xl border border-slate-200 shadow-2xl">
            </div>
            <div>
                <h2 class="text-3xl font-black text-slate-900 md:text-4xl">Our History</h2>
                <div class="mt-6 space-y-4 text-lg leading-relaxed text-slate-600">
                    <p>Established with a vision to redefine sports in Bihar, the <strong class="text-blue-700">East Champaran Fencing Association (ECFA)</strong> serves as the official governing body for fencing in the region.</p>
                    <p>From humble beginnings to becoming a powerhouse for regional talent, we have focused on one thing: **Excellence**. We serve as the gateway for local athletes to transition from district enthusiasts to state and national champions.</p>
                </div>
                <div class="mt-8 flex gap-4">
                    <div class="flex flex-col border-l-4 border-amber-400 pl-4">
                        <span class="text-2xl font-black text-slate-900">500+</span>
                        <span class="text-sm font-semibold text-slate-500">Athletes Trained</span>
                    </div>
                    <div class="flex flex-col border-l-4 border-blue-600 pl-4">
                        <span class="text-2xl font-black text-slate-900">District</span>
                        <span class="text-sm font-semibold text-slate-500">Official Hub</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Vision & Mission: Glass Cards -->
<section class="bg-slate-50 py-20">
    <div class="mx-auto max-w-6xl px-4">
        <div class="grid gap-8 md:grid-cols-2">
            <div class="group rounded-3xl bg-white p-10 shadow-sm transition hover:shadow-xl border border-slate-200">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-amber-400 text-slate-900 text-2xl shadow-lg shadow-amber-400/30 mb-6 group-hover:rotate-6 transition">🎯</div>
                <h3 class="text-2xl font-black text-slate-900">Our Vision</h3>
                <p class="mt-4 text-lg leading-relaxed text-slate-600">To make East Champaran a globally recognized hub for fencing by fostering an environment of peak performance, olympic values, and fair play.</p>
            </div>
            <div class="group rounded-3xl bg-white p-10 shadow-sm transition hover:shadow-xl border border-slate-200">
                <div class="inline-flex h-14 w-14 items-center justify-center rounded-2xl bg-blue-600 text-white text-2xl shadow-lg shadow-blue-600/30 mb-6 group-hover:rotate-6 transition">🚀</div>
                <h3 class="text-2xl font-black text-slate-900">Our Mission</h3>
                <ul class="mt-4 space-y-3 text-lg text-slate-600">
                    <li class="flex items-start gap-3"><span class="text-blue-600 font-bold">✓</span> Create state-of-the-art training facilities</li>
                    <li class="flex items-start gap-3"><span class="text-blue-600 font-bold">✓</span> Scout and nurture rural talent early</li>
                    <li class="flex items-start gap-3"><span class="text-blue-600 font-bold">✓</span> Uphold absolute discipline and respect</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Committee: Modern Grid -->
<section class="bg-white py-24">
    <div class="mx-auto max-w-6xl px-4">
        <div class="mb-16 text-center">
            <h2 class="text-4xl font-black text-slate-900 tracking-tight">President & Committee</h2>
            <div class="mx-auto mt-4 h-1 w-24 rounded-full bg-blue-600"></div>
        </div>

        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
            @php
                $committee = [
                    ['name' => 'Shri. Ram Kumar Singh', 'role' => 'President', 'bio' => '20+ years in sports management and leadership.'],
                    ['name' => 'Smt. Priya Sharma', 'role' => 'Vice President', 'bio' => 'Former national fencer with technical expertise.'],
                    ['name' => 'Shri. Ajay Kumar', 'role' => 'Secretary', 'bio' => 'Visionary behind regional fencing outreach.'],
                    ['name' => 'Shri. Vikram Mishra', 'role' => 'Treasurer', 'bio' => 'Financial backbone ensuring resource stability.']
                ];
            @endphp

            @foreach($committee as $member)
            <div class="group text-center">
                <div class="relative mx-auto mb-6 h-48 w-48 overflow-hidden rounded-3xl bg-slate-200 ring-8 ring-slate-50 transition group-hover:ring-amber-100">
                    <!-- Image Placeholder -->
                    <div class="flex h-full w-full items-center justify-center text-slate-400 text-4xl font-bold bg-slate-200 group-hover:scale-110 transition duration-500 uppercase">{{ substr($member['name'], 0, 1) }}</div>
                </div>
                <h4 class="text-xl font-black text-slate-900">{{ $member['name'] }}</h4>
                <p class="text-sm font-bold uppercase tracking-widest text-amber-600 mb-4">{{ $member['role'] }}</p>
                <p class="px-4 text-sm text-slate-500 leading-relaxed">{{ $member['bio'] }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="mx-auto max-w-6xl px-4 pb-24">
    <div class="rounded-3xl bg-blue-700 p-12 text-center text-white shadow-2xl shadow-blue-700/20">
        <h2 class="text-3xl font-black md:text-4xl">Be Part of the Future</h2>
        <p class="mt-4 text-blue-100 italic">"Fencing is a game of physical chess." - Join our club today.</p>
        <div class="mt-10">
            <a href="{{ route('register') }}" class="rounded-full bg-white px-8 py-4 text-lg font-bold text-blue-700 transition hover:bg-amber-400 hover:text-slate-900">Register as Player</a>
        </div>
    </div>
</section>
@endsection
