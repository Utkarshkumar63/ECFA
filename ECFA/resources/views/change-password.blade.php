@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen py-12">
    <div class="max-w-lg mx-auto px-4">

        <!-- Back Button -->
        <a href="{{ route('player.profile') }}" class="inline-flex items-center text-sm font-bold text-slate-500 hover:text-indigo-600 mb-8 transition group">
            <div class="bg-white p-2 rounded-lg shadow-sm mr-3 group-hover:bg-indigo-50 transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            Back to Profile
        </a>

        <div class="bg-white rounded-[2rem] shadow-2xl shadow-indigo-100/50 overflow-hidden border border-white">
            <!-- Header -->
            <div class="p-10 bg-indigo-950 text-white relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-2">
                        <span class="p-2 bg-indigo-500/30 rounded-lg backdrop-blur-md">
                            <svg class="w-6 h-6 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </span>
                        <h2 class="text-3xl font-black tracking-tight uppercase italic">Security Center</h2>
                    </div>
                    <p class="text-indigo-300/80 text-sm font-medium ml-12">Update your credentials to stay protected.</p>
                </div>

                <!-- Abstract Sporty Background Decoration -->
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-10 w-20 h-1 bg-indigo-500 rounded-full transform skew-x-12 opacity-50"></div>
            </div>

            <div class="p-10">
                @if(session('success'))
                    <div class="mb-8 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-sm font-bold border border-emerald-100 flex items-center animate-bounce">
                         <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                         {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('password.update') }}" method="POST" class="space-y-8">
                    @csrf

                    <!-- Current Password -->
                    <div class="relative">
                        <label class="text-[11px] uppercase font-black text-slate-400 tracking-[0.1em] block mb-2 ml-1">Current Password</label>
                        <div class="relative group">
                            <input type="password" name="current_password" id="current_password" required
                                class="w-full pl-5 pr-12 py-4 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 focus:ring-0 outline-none transition-all font-medium">
                            <button type="button" onclick="togglePass('current_password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path id="eye_icon_current" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                        @error('current_password')
                            <p class="text-rose-500 text-[11px] mt-2 font-bold ml-1 flex items-center">
                                <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path></svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="h-px bg-slate-100"></div>

                    <!-- New Password -->
                    <div>
                        <label class="text-[11px] uppercase font-black text-slate-400 tracking-[0.1em] block mb-2 ml-1">New Secure Password</label>
                        <div class="relative mb-3">
                            <input type="password" name="new_password" id="new_password" required onkeyup="checkStrength(this.value)"
                                class="w-full pl-5 pr-12 py-4 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 focus:ring-0 outline-none transition-all font-medium">
                            <button type="button" onclick="togglePass('new_password')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path id="eye_icon_new" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>

                        <!-- Password Strength Meter -->
                        <div class="px-1">
                            <div class="flex justify-between items-center mb-1">
                                <span id="strength-text" class="text-[10px] font-black uppercase text-slate-400 tracking-tighter">Strength: <span class="text-slate-300">None</span></span>
                                <span id="strength-percent" class="text-[10px] font-bold text-slate-400">0%</span>
                            </div>
                            <div class="h-1.5 w-full bg-slate-100 rounded-full overflow-hidden">
                                <div id="strength-bar" class="h-full w-0 bg-slate-300 transition-all duration-500 ease-out"></div>
                            </div>
                        </div>

                        @error('new_password')
                            <p class="text-rose-500 text-[11px] mt-2 font-bold ml-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Confirm New Password -->
                    <div>
                        <label class="text-[11px] uppercase font-black text-slate-400 tracking-[0.1em] block mb-2 ml-1">Confirm New Password</label>
                        <div class="relative">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" required
                                class="w-full pl-5 pr-12 py-4 rounded-2xl border-2 border-slate-100 focus:border-indigo-600 focus:ring-0 outline-none transition-all font-medium">
                            <button type="button" onclick="togglePass('new_password_confirmation')" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path id="eye_icon_confirm" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-indigo-950 hover:bg-black text-white font-black py-5 rounded-[1.5rem] shadow-xl shadow-indigo-200 transition-all transform hover:-translate-y-1 active:scale-95 flex items-center justify-center group">
                        <span class="mr-3 uppercase italic tracking-widest">Update Security</span>
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Toggle Show/Hide Password
    function togglePass(inputId) {
        const input = document.getElementById(inputId);
        const icon = input.nextElementSibling.querySelector('path');

        if (input.type === "password") {
            input.type = "text";
            // Set "Eye Off" icon path
            icon.setAttribute("d", "M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18");
        } else {
            input.type = "password";
            // Set "Eye On" icon path
            icon.setAttribute("d", "M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z");
        }
    }

    // 2. Real-time Strength Checker
    function checkStrength(password) {
        const bar = document.getElementById('strength-bar');
        const text = document.getElementById('strength-text');
        const percent = document.getElementById('strength-percent');

        let score = 0;

        if (password.length > 7) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;

        const width = (score / 4) * 100;
        bar.style.width = width + "%";
        percent.innerText = width + "%";

        if (score === 0) {
            bar.className = "h-full w-0 bg-slate-300 transition-all duration-500";
            text.innerHTML = 'Strength: <span class="text-slate-300">None</span>';
        } else if (score === 1) {
            bar.className = "h-full bg-rose-500 transition-all duration-500";
            text.innerHTML = 'Strength: <span class="text-rose-500 font-black">Weak</span>';
        } else if (score === 2) {
            bar.className = "h-full bg-amber-500 transition-all duration-500";
            text.innerHTML = 'Strength: <span class="text-amber-500 font-black">Medium</span>';
        } else if (score === 3) {
            bar.className = "h-full bg-indigo-500 transition-all duration-500";
            text.innerHTML = 'Strength: <span class="text-indigo-500 font-black">Good</span>';
        } else {
            bar.className = "h-full bg-emerald-500 transition-all duration-500";
            text.innerHTML = 'Strength: <span class="text-emerald-500 font-black">Elite</span>';
        }
    }
</script>
@endsection
