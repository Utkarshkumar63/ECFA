@extends('layouts.app')

@section('title', 'Athlete Verification - ECFA')

@section('content')
<!-- Main Portal Wrapper -->
<div class="relative min-h-screen w-full flex items-center justify-center overflow-hidden bg-[#050810]" x-data="{ loading: false, showPass: false }">

    <!-- 1. Immersive Background Layers -->
    <div class="absolute inset-0 z-0">
        <!-- Blurred Action Background -->
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1510211334416-49199898e727?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center opacity-20 grayscale scale-110"></div>
        <!-- Gradient Overlays -->
        <div class="absolute inset-0 bg-gradient-to-b from-[#050810] via-transparent to-[#050810]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_center,_var(--tw-gradient-stops))] from-blue-600/20 via-transparent to-transparent"></div>
    </div>

    <!-- 2. The Glowing "Piste" Line (Decorative) -->
    <div class="absolute left-1/2 top-0 -translate-x-1/2 w-[1px] h-full bg-gradient-to-b from-transparent via-blue-500/50 to-transparent z-10 hidden md:block">
        <div class="absolute top-1/4 left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-blue-500 blur-sm animate-pulse"></div>
        <div class="absolute bottom-1/4 left-1/2 -translate-x-1/2 w-4 h-4 rounded-full bg-blue-500 blur-sm animate-pulse"></div>
    </div>

    <!-- 3. The Floating Verification Card -->
    <div class="relative z-20 w-full max-w-[480px] px-6 py-12">

        <!-- Branding Top -->
        <div class="text-center mb-10 group">
            <div class="inline-flex relative p-[2px] rounded-3xl bg-gradient-to-tr from-brand-gold/50 via-blue-500/50 to-brand-gold/50 group-hover:scale-110 transition-transform duration-700">
                <div class="bg-[#0a0f1d] p-4 rounded-[22px]">
                    <img src="{{ asset('images/logo.jpeg') }}" class="h-12 w-12 rounded-lg grayscale brightness-150" alt="ECFA">
                </div>
            </div>
            <h1 class="mt-6 text-4xl font-black text-white italic tracking-tighter uppercase leading-none">
                ATHLETE <span class="text-brand-gold not-italic">PORTAL</span>
            </h1>
            <p class="mt-3 text-slate-500 text-[10px] font-black uppercase tracking-[0.4em]">Identity Verification Required</p>
        </div>

        <!-- Glass Card -->
        <div class="backdrop-blur-3xl bg-white/[0.03] border border-white/10 rounded-[3rem] p-10 md:p-14 shadow-[0_0_100px_rgba(0,0,0,0.5)]">

            <!-- Dynamic Alert for Laravel Errors -->
            @if($errors->any())
                <div class="mb-8 p-4 bg-red-500/10 border border-red-500/20 rounded-2xl flex items-center gap-3 animate-head-shake">
                    <div class="h-2 w-2 rounded-full bg-red-500 animate-pulse"></div>
                    <span class="text-[10px] font-black text-red-400 uppercase tracking-widest">{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" @submit="loading = true" class="space-y-8">
                @csrf

                <!-- ID Input Group -->
                <div class="space-y-3">
                    <label class="block text-[9px] font-black text-slate-500 uppercase tracking-[0.3em] ml-1">Athlete Identifier</label>
                    <div class="relative group">
                        <input type="email" name="email" required
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-white font-bold outline-none transition-all focus:bg-white/10 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 placeholder:text-slate-700"
                            placeholder="EMAIL ADDRESS">
                        <div class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-700 group-focus-within:text-blue-400 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" stroke-width="2"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Pass-Key Input Group -->
                <div class="space-y-3">
                    <div class="flex justify-between items-center px-1">
                        <label class="text-[9px] font-black text-slate-500 uppercase tracking-[0.3em]">Access Key</label>
                        <a href="#" class="text-[9px] font-black text-blue-400 uppercase tracking-widest hover:text-white transition">Lost Key?</a>
                    </div>
                    <div class="relative group">
                        <input :type="showPass ? 'text' : 'password'" name="password" required
                            class="w-full bg-white/5 border border-white/10 rounded-2xl px-6 py-5 text-white font-bold outline-none transition-all focus:bg-white/10 focus:border-blue-500/50 focus:ring-4 focus:ring-blue-500/10 placeholder:text-slate-700"
                            placeholder="••••••••">
                        <button type="button" @click="showPass = !showPass" class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-700 hover:text-white transition-colors">
                            <svg x-show="!showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" stroke-width="2"/></svg>
                            <svg x-show="showPass" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" stroke-width="2"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Submit Button (High Impact) -->
                <button type="submit"
                    class="relative w-full py-6 bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-black text-xs uppercase tracking-[0.4em] transition-all transform active:scale-[0.98] shadow-[0_20px_40px_rgba(37,99,235,0.3)] group overflow-hidden"
                    :disabled="loading">
                    <span class="relative z-10 flex items-center justify-center gap-3">
                        <span x-show="!loading">Initialize Access</span>
                        <svg x-show="loading" class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span x-show="!loading" class="group-hover:translate-x-2 transition-transform">→</span>
                    </span>
                    <!-- Button Glow Effect -->
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]"></div>
                </button>
            </form>

            <!-- Card Bottom -->
            <div class="mt-12 pt-10 border-t border-white/5 text-center">
                <p class="text-[10px] font-black text-slate-500 uppercase tracking-widest mb-6">New to the Circuit?</p>
                <a href="{{ url('/registration') }}" class="group inline-flex items-center gap-4 text-[11px] font-black text-brand-gold uppercase tracking-widest">
                    Request Credentials
                    <div class="h-10 w-10 rounded-full border border-brand-gold/30 flex items-center justify-center group-hover:bg-brand-gold group-hover:text-black transition-all">
                        →
                    </div>
                </a>
            </div>
        </div>

        <!-- System Footer -->
        <div class="mt-12 flex flex-col items-center">
            <div class="flex gap-6 mb-4">
                <div class="h-[1px] w-12 bg-white/10 self-center"></div>
                <p class="text-[8px] font-black text-slate-600 uppercase tracking-[0.5em]">ECFA Security Protocol</p>
                <div class="h-[1px] w-12 bg-white/10 self-center"></div>
            </div>
            <p class="text-[9px] font-medium text-slate-700 uppercase tracking-widest">© {{ date('Y') }} Regional Authority Node 01</p>
        </div>
    </div>
</div>

<style>
    @keyframes shimmer {
        100% { transform: translateX(100%); }
    }
    @keyframes head-shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-5px); }
        75% { transform: translateX(5px); }
    }
    .animate-head-shake {
        animation: head-shake 0.4s ease-in-out;
    }
    input::placeholder {
        letter-spacing: 0.1em;
        font-size: 10px;
    }
</style>
@endsection
