@extends('layouts.app')

@section('content')
    <!-- Alpine.js for Expandable Cards -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="bg-slate-50 min-h-screen pb-12">
        <!-- Sporty Header Background -->
        <div class="h-64 bg-indigo-900 relative overflow-hidden">
            <div class="absolute inset-0 opacity-20">
                <svg class="h-full w-full" fill="currentColor" viewBox="0 0 100 100" preserveAspectRatio="none">
                    <polygon points="0,100 100,0 100,100" />
                </svg>
            </div>
            <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-t from-slate-50"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-32 relative z-10">
            <div class="flex flex-col lg:flex-row gap-8">

                <!-- Sidebar: User Summary (Same as before) -->
                <div class="lg:w-1/3">
                    <div
                        class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 overflow-hidden border border-white sticky top-8">
                        <div class="p-8 text-center">
                            <div class="relative inline-block group">
                                <img class="h-32 w-32 rounded-3xl border-4 border-indigo-50 rotate-3 group-hover:rotate-0 transition-transform duration-300 shadow-lg mx-auto object-cover"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=4338ca&color=fff&size=128"
                                    alt="Profile">
                                <div
                                    class="absolute -bottom-2 -right-2 bg-green-500 border-4 border-white w-8 h-8 rounded-full flex items-center justify-center shadow-sm">
                                    <span class="block w-2 h-2 bg-white rounded-full animate-pulse"></span>
                                </div>
                            </div>

                            <h2 class="mt-6 text-2xl font-black text-slate-800 tracking-tight uppercase italic">
                                {{ $user->name }}</h2>
                            <span
                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-700 uppercase tracking-widest mt-2">
                                {{ $user->category ?? 'Athlete' }} Fencer
                            </span>

                            <div class="grid grid-cols-2 gap-4 mt-8 border-t border-slate-100 pt-8">
                                <div class="text-center border-r border-slate-100">
                                    <p class="text-2xl font-black text-indigo-600">{{ $user->experience ?? 'New' }}</p>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest">Experience</p>
                                </div>
                                <div class="text-center">
                                    <p class="text-2xl font-black text-indigo-600">{{ $user->registeredEvents->count() }}
                                    </p>
                                    <p class="text-[10px] uppercase font-bold text-slate-400 tracking-widest">Tournaments
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-slate-50/50 p-4 space-y-2 border-t border-slate-100">
                            <a href="#"
                                class="flex items-center space-x-3 p-3 rounded-xl bg-white shadow-sm text-indigo-600 font-bold border border-indigo-100 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                <span>Profile Details</span>
                            </a>
                            <a href="{{ route('password.change') }}"
                                class="flex items-center space-x-3 p-3 rounded-xl text-slate-600 hover:bg-white hover:text-indigo-600 font-semibold transition group">
                                <div class="bg-slate-200 group-hover:bg-indigo-100 p-2 rounded-lg transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="flex-grow text-sm">Security & Password</span>
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="pt-2">
                                @csrf
                                <button
                                    class="w-full flex items-center space-x-3 p-3 rounded-xl text-red-500 hover:bg-red-50 font-semibold transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                        </path>
                                    </svg>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Main Content -->
                <div class="lg:w-2/3 space-y-8">

                    <!-- PERSONAL INFO CARD + VERIFICATION DOCUMENTS -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-white">
                        <div class="flex items-center justify-between mb-8">
                            <h3 class="text-xl font-black text-slate-800 uppercase italic tracking-tight">Athlete Registry
                                Details</h3>
                            <div class="bg-indigo-50 px-3 py-1 rounded-lg">
                                <span class="text-[10px] font-black text-indigo-600 uppercase">Verified Member</span>
                            </div>
                        </div>

                        <!-- Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-8 gap-x-12">
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase font-bold text-slate-400 tracking-widest block">Full
                                    Name</label>
                                <p class="text-slate-800 font-bold border-b border-slate-50 pb-2">{{ $user->name }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase font-bold text-slate-400 tracking-widest block">Email
                                    Address</label>
                                <p class="text-slate-800 font-bold border-b border-slate-50 pb-2">{{ $user->email }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase font-bold text-slate-400 tracking-widest block">Phone
                                    Number</label>
                                <p class="text-slate-800 font-bold border-b border-slate-50 pb-2">{{ $user->phone }}</p>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] uppercase font-bold text-slate-400 tracking-widest block">Date of
                                    Birth</label>
                                <p class="text-slate-800 font-bold border-b border-slate-50 pb-2">
                                    {{ \Carbon\Carbon::parse($user->dob)->format('d M, Y') }}</p>
                            </div>
                            <div class="md:col-span-2 space-y-1">
                                <label class="text-[10px] uppercase font-bold text-slate-400 tracking-widest block">Aadhar
                                    Number</label>
                                <p class="text-slate-800 font-bold border-b border-slate-50 pb-2 tracking-widest">
                                    {{ $user->aadhar_no ?? 'N/A' }}</p>
                            </div>
                            <div class="md:col-span-2 space-y-1">
                                <label
                                    class="text-[10px] uppercase font-bold text-slate-400 tracking-widest block">Residential
                                    Address</label>
                                <p class="text-slate-800 font-bold">{{ $user->address }}, {{ $user->city }},
                                    {{ $user->state }} - {{ $user->pincode }}</p>
                            </div>
                        </div>

                        <!-- NEW: VERIFICATION DOCUMENTS SECTION -->
                        <!-- NEW: INTERACTIVE VERIFICATION DOCUMENTS VAULT -->
                        <div x-data="{ openDocs: false }"
                            class="mt-8 border-t border-slate-100 pt-8 transition-all duration-500">

                            <!-- TRIGGER HEADER -->
                            <div @click="openDocs = !openDocs"
                                class="group flex items-center justify-between cursor-pointer p-4 rounded-2xl bg-slate-50 hover:bg-indigo-50 transition-all border border-transparent hover:border-indigo-100">

                                <div class="flex items-center gap-3">
                                    <div
                                        class="h-10 w-10 rounded-xl bg-white shadow-sm flex items-center justify-center text-indigo-600 border border-slate-100 group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="text-[11px] uppercase font-black text-slate-700 tracking-widest">
                                            Verification Documents Vault</h4>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase tracking-tighter">Click to
                                            view uploaded ID proofs</p>
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <span x-show="!openDocs"
                                        class="text-[9px] font-black uppercase text-indigo-500 bg-white px-2 py-1 rounded-lg border border-indigo-50 shadow-sm">Show
                                        Vault</span>
                                    <svg :class="openDocs ? 'rotate-180' : ''"
                                        class="w-5 h-5 text-slate-300 transition-transform duration-300" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" />
                                    </svg>
                                </div>
                            </div>

                            <!-- EXPANDABLE CONTENT WITH BEST EFFECT -->
                            <div x-show="openDocs" x-transition:enter="transition ease-out duration-500"
                                x-transition:enter-start="opacity-0 -translate-y-4"
                                x-transition:enter-end="opacity-100 translate-y-0"
                                x-transition:leave="transition ease-in duration-300"
                                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                                class="mt-6 bg-white rounded-3xl p-6 border border-slate-100 shadow-inner">

                                <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                    <!-- Aadhar Photo -->
                                    <div class="space-y-3">
                                        <p
                                            class="text-[9px] font-black uppercase text-slate-400 tracking-tighter text-center">
                                            Aadhar Card</p>
                                        <a href="{{ $user->aadhar_photo }}" target="_blank"
                                            class="block group relative rounded-2xl overflow-hidden border-2 border-slate-100 aspect-video md:aspect-square bg-slate-50 shadow-sm">
                                            <img src="{{ $user->aadhar_photo }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-90 group-hover:opacity-100">
                                            <div
                                                class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                                <span
                                                    class="text-white text-[9px] font-black uppercase tracking-widest border-2 border-white/60 px-4 py-2 rounded-xl scale-90 group-hover:scale-100 transition-transform duration-500">Preview
                                                    Original</span>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- DOB Photo -->
                                    <div class="space-y-3">
                                        <p
                                            class="text-[9px] font-black uppercase text-slate-400 tracking-tighter text-center">
                                            DOB Certificate</p>
                                        <a href="{{ $user->dob_photo }}" target="_blank"
                                            class="block group relative rounded-2xl overflow-hidden border-2 border-slate-100 aspect-video md:aspect-square bg-slate-50 shadow-sm">
                                            <img src="{{ $user->dob_photo }}"
                                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-90 group-hover:opacity-100">
                                            <div
                                                class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                                <span
                                                    class="text-white text-[9px] font-black uppercase tracking-widest border-2 border-white/60 px-4 py-2 rounded-xl scale-90 group-hover:scale-100 transition-transform duration-500">Preview
                                                    Original</span>
                                            </div>
                                        </a>
                                    </div>

                                    <!-- Passport Photo (Conditional) -->
                                    @if($user->passport_photo)
                                        <div class="space-y-3">
                                            <p
                                                class="text-[9px] font-black uppercase text-slate-400 tracking-tighter text-center">
                                                Passport Copy</p>
                                            <a href="{{ $user->passport_photo }}" target="_blank"
                                                class="block group relative rounded-2xl overflow-hidden border-2 border-slate-100 aspect-video md:aspect-square bg-slate-50 shadow-sm">
                                                <img src="{{ $user->passport_photo }}"
                                                    class="w-full h-full object-cover group-hover:scale-110 transition duration-700 opacity-90 group-hover:opacity-100">
                                                <div
                                                    class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                                                    <span
                                                        class="text-white text-[9px] font-black uppercase tracking-widest border-2 border-white/60 px-4 py-2 rounded-xl scale-90 group-hover:scale-100 transition-transform duration-500">Preview
                                                        Original</span>
                                                </div>
                                            </a>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-6 flex items-center gap-2 text-slate-400">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <p class="text-[9px] italic font-medium">Documents are stored in encrypted format for
                                        ECFA verification.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- REST OF THE PAGE (Achievements, Support, Tournaments - Same as before) -->

                    <!-- ACHIEVEMENTS CARD -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-white">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 uppercase italic">My Achievements</h3>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Displaying recent
                                    3 awards</p>
                            </div>
                            <div class="bg-amber-100 p-2 rounded-xl">
                                <svg class="w-6 h-6 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @forelse($user->achievements->take(3) as $ach)
                                <div x-data="{ open: false }"
                                    class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden transition-all hover:border-indigo-200">
                                    <div @click="open = !open" class="p-4 flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center gap-4">
                                            <div class="text-2xl">
                                                {{ $ach->medal_type == 'Gold' ? '🥇' : ($ach->medal_type == 'Silver' ? '🥈' : '🥉') }}
                                            </div>
                                            <div>
                                                <p class="font-black text-slate-800 text-sm tracking-tight uppercase italic">
                                                    {{ Str::limit($ach->event_name, 35) }}</p>
                                                <span
                                                    class="text-[9px] font-black text-indigo-500 uppercase">{{ $ach->medal_type }}
                                                    WINNER</span>
                                            </div>
                                        </div>
                                        <svg :class="open ? 'rotate-180' : ''"
                                            class="w-4 h-4 text-slate-400 transition-transform" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 9l-7 7-7-7" stroke-width="3" />
                                        </svg>
                                    </div>
                                    <div x-show="open" x-transition class="p-5 pt-0 bg-white border-t border-slate-100">
                                        <div class="flex flex-col sm:flex-row justify-between items-center mt-4 gap-4">
                                            <p class="text-xs text-slate-500 font-bold uppercase">Tournament: <span
                                                    class="text-slate-800">{{ $ach->event_name }}</span></p>
                                            @if($ach->image)
                                                <a href="{{ $ach->image }}" target="_blank"
                                                    class="flex items-center gap-2 bg-[#0a192f] text-[#c5a059] px-5 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-black transition tracking-widest border border-[#c5a059]/30">
                                                    View Certificate
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-slate-400 text-sm font-medium italic">No achievements recorded yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- SUPPORT INBOX -->
                    <div class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 p-8 border border-white">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 uppercase italic">Support Inbox</h3>
                            </div>
                            <div class="bg-indigo-50 p-3 rounded-2xl text-indigo-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                        <div class="space-y-3">
                            @forelse($myMessages->take(2) as $msg)
                                <div x-data="{ open: false }"
                                    class="bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden transition-all hover:border-indigo-200">
                                    <div @click="open = !open" class="p-4 flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center gap-4">
                                            <div
                                                class="h-8 w-8 rounded-lg flex items-center justify-center {{ $msg->reply_message ? 'bg-emerald-100 text-emerald-600' : 'bg-amber-100 text-amber-600' }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path
                                                        d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"
                                                        stroke-width="2.5" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-xs font-black text-slate-800 uppercase tracking-tight italic">
                                                    {{ Str::limit($msg->subject, 30) }}</p>
                                                <span
                                                    class="text-[8px] font-bold uppercase {{ $msg->reply_message ? 'text-emerald-500' : 'text-amber-500' }}">
                                                    {{ $msg->reply_message ? 'Reply Received' : 'Waiting Response' }}
                                                </span>
                                            </div>
                                        </div>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">
                                            {{ $msg->created_at->format('d M') }}</p>
                                    </div>
                                    <div x-show="open" x-transition
                                        class="p-5 pt-0 bg-white border-t border-slate-100 space-y-4">
                                        <div class="mt-4">
                                            <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Your
                                                Query:</p>
                                            <p class="text-xs text-slate-600 italic">"{{ $msg->message }}"</p>
                                        </div>
                                        @if($msg->reply_message)
                                            <div class="bg-emerald-50 p-4 rounded-xl border border-emerald-100">
                                                <p class="text-[9px] font-black text-emerald-600 uppercase mb-1">Official Response:
                                                </p>
                                                <p class="text-xs font-bold text-slate-800 leading-relaxed">
                                                    {{ $msg->reply_message }}</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-6">
                                    <p class="text-slate-400 text-[10px] font-bold uppercase">No queries found</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                    <!-- TOURNAMENTS CARD -->
                    <div
                        class="bg-white rounded-3xl shadow-xl shadow-slate-200/60 overflow-hidden border border-white mt-8">
                        <div class="p-8 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                            <div>
                                <h3 class="text-xl font-black text-slate-800 uppercase italic">Registration History</h3>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest">Recent 3
                                    tournaments</p>
                            </div>
                            <a href="{{ route('events') }}"
                                class="bg-indigo-600 text-white px-4 py-2 rounded-xl text-[10px] font-black uppercase hover:bg-indigo-700 transition shadow-lg shadow-indigo-200 tracking-widest">
                                Join Event
                            </a>
                        </div>

                        <div class="divide-y divide-slate-50">
                            @forelse($user->registeredEvents->take(3) as $event)
                                <div x-data="{ open: false }" class="group overflow-hidden transition-all hover:bg-slate-50/80">
                                    <!-- HEADER -->
                                    <div @click="open = !open" class="p-5 flex items-center justify-between cursor-pointer">
                                        <div class="flex items-center">
                                            <div
                                                class="flex-shrink-0 w-12 h-12 bg-white border border-slate-100 rounded-2xl flex flex-col items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                                <span
                                                    class="text-[8px] font-black text-indigo-600 uppercase leading-none">{{ \Carbon\Carbon::parse($event->event_date)->format('M') }}</span>
                                                <span
                                                    class="text-lg font-black text-slate-800 leading-tight">{{ \Carbon\Carbon::parse($event->event_date)->format('d') }}</span>
                                            </div>
                                            <div class="ml-5">
                                                <h4
                                                    class="font-black text-slate-800 text-sm uppercase italic tracking-tight group-hover:text-indigo-600 transition">
                                                    {{ Str::limit($event->title, 30) }}</h4>
                                                <span
                                                    class="text-[10px] font-bold text-slate-400 uppercase">{{ $event->location }}</span>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            @php $status = $event->pivot->status ?? 'pending'; @endphp
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-[9px] font-black uppercase tracking-tighter
                                {{ $status == 'selected' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                                                {{ $status }}
                                            </span>
                                            <svg :class="open ? 'rotate-180' : ''"
                                                class="w-4 h-4 text-slate-300 transition-transform" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path d="M19 9l-7 7-7-7" stroke-width="3" />
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- EXPANDED BODY -->
                                    <div x-show="open" x-transition:enter="transition ease-out duration-300"
                                        x-transition:enter-start="opacity-0 -translate-y-2"
                                        x-transition:enter-end="opacity-100 translate-y-0" class="px-6 pb-6 pt-2 bg-white">

                                        <div
                                            class="flex flex-col sm:flex-row justify-between items-center p-4 bg-slate-50 rounded-2xl border border-slate-100 gap-4 shadow-inner">
                                            <div
                                                class="flex items-center text-xs text-slate-500 font-bold uppercase tracking-tight">
                                                <svg class="w-4 h-4 mr-2 text-indigo-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                    </path>
                                                </svg>
                                                Full Venue: {{ $event->location }}
                                            </div>

                                            @php
                                                // Find certificate for this specific event and user
                                                $participationCert = \App\Models\Certificate::where('user_id', $user->id)
                                                    ->where('event_id', $event->id)
                                                    ->first();
                                            @endphp

                                            @if($participationCert)
                                                <a href="{{ route('certificate.view', $participationCert->id) }}" target="_blank"
                                                    class="flex items-center gap-2 bg-[#059669] text-white px-6 py-2.5 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 transition shadow-lg shadow-emerald-100">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    Download Certificate
                                                </a>
                                            @else
                                                <div class="flex items-center gap-2 px-4 py-2 bg-slate-200/50 rounded-xl">
                                                    <span
                                                        class="text-[9px] font-black text-slate-400 uppercase italic tracking-tighter">Record
                                                        Verified</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="p-12 text-center">
                                    <p class="text-slate-500 font-medium italic">No registrations yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
