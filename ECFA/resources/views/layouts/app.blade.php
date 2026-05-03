<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="overflow-x-hidden">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ECFA - East Champaran Fencing Association')</title>

    <!-- Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Frameworks -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Plus Jakarta Sans', 'system-ui', 'sans-serif'] },
                    colors: {
                        brand: {
                            dark: '#0a0f1d',
                            gold: '#fbbf24',
                            blue: '#2563eb'
                        }
                    }
                },
            },
        };
    </script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* 🔥 FIX FOR WHITE SPACE ON RIGHT */
        html,
        body {
            max-width: 100vw;
            overflow-x: hidden;
            position: relative;
            margin: 0;
            padding: 0;
        }

        .glass-nav {
            background: rgba(10, 15, 29, 0.92);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        }

        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -4px;
            left: 0;
            width: 0%;
            height: 2px;
            background: #fbbf24;
            transition: width 0.3s ease;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .menu-open {
            overflow: hidden;
        }

        /* 🔥 HIDE SCROLLBAR */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 font-sans text-slate-900 antialiased overflow-x-hidden"
    x-data="{ mobileMenu: false, userDropdown: false, notifications: false }" :class="{ 'menu-open': mobileMenu }">

    <!-- Header / Navigation -->
    <nav class="sticky top-0 z-[100] glass-nav text-white shadow-2xl w-full">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-5 py-3 md:py-4">

            <!-- 1. Logo Section -->
            <a href="{{ url('/') }}" class="flex shrink-0 items-center gap-2 sm:gap-3 group">
                <div class="bg-white p-1 rounded-lg shadow-lg group-hover:scale-105 transition-transform duration-300">
                    <img src="{{ asset('images/logo.jpeg') }}" alt="ECFA Logo" class="h-8 sm:h-10 w-auto rounded-md">
                </div>
                <div class="flex flex-col leading-none">
                    <span class="font-black text-sm sm:text-lg md:text-xl tracking-tighter uppercase italic">
                        ECFA <span class="text-brand-gold">BIHAR</span>
                    </span>
                    <!-- Mobile par 'East Champaran' ko chhota ya hide kar sakte hain agar space kam ho -->
                    <span
                        class="text-[7px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-[0.1em] sm:tracking-[0.2em]">East
                        Champaran</span>
                </div>
            </a>

            <!-- 2. Desktop Links -->
            <div class="hidden lg:flex items-center gap-6 text-[10px] font-extrabold uppercase tracking-[0.18em]">
                <a href="{{ url('/') }}"
                    class="nav-link {{ Request::is('/') ? 'text-brand-gold' : 'text-slate-200' }}">Home</a>
                <a href="{{ url('/about') }}"
                    class="nav-link {{ Request::is('about*') ? 'text-brand-gold' : 'text-slate-200' }}">About Us</a>

                <a href="{{ url('/events') }}"
                    class="nav-link {{ Request::is('events*') ? 'text-brand-gold' : 'text-slate-200' }}">Events</a>
                <a href="{{ url('/achievements') }}"
                    class="nav-link {{ Request::is('achievements*') ? 'text-brand-gold' : 'text-slate-200' }}">Honors</a>
                <a href="{{ url('/gallery') }}"
                    class="nav-link {{ Request::is('gallery*') ? 'text-brand-gold' : 'text-slate-200' }}">Gallery</a>
                <a href="{{ url('/news') }}"
                    class="nav-link {{ Request::is('news*') ? 'text-brand-gold' : 'text-slate-200' }}">News</a>
                <a href="{{ url('/contact') }}"
                    class="nav-link {{ Request::is('contact*') ? 'text-brand-gold' : 'text-slate-200' }}">Contact</a>
                <a href="{{ url('/learn') }}"
                    class="nav-link {{ Request::is('learn*') ? 'text-brand-gold' : 'text-blue-400 italic' }}">Learn</a>
            </div>

            <!-- 3. Right Side (Auth) -->
            <!-- 3. Right Side (Auth) -->
            <div class="flex items-center gap-2 sm:gap-3 border-l border-white/10 pl-2 sm:pl-4">
                @guest
                    <div class="hidden md:flex items-center gap-4">
                        <a href="{{ url('/player-login') }}"
                            class="text-xs font-bold uppercase tracking-widest text-slate-200 hover:text-brand-gold transition">Login</a>
                    </div>
                    <a href="{{ url('/registration') }}"
                        class="px-3 sm:px-4 py-2 bg-brand-gold text-slate-950 rounded-full font-black text-[9px] sm:text-[10px] uppercase tracking-widest hover:bg-white transition-all shadow-lg shrink-0">
                        Join
                    </a>
                @else
                    <!-- Notification Bell (Desktop) -->
                    <div class="relative hidden sm:block">
                        <button @click="notifications = !notifications"
                            class="p-2 text-slate-400 hover:text-brand-gold transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </button>
                    </div>

                    <!-- User Dropdown (Auth) -->
                    <div class="relative">
                        <button @click="userDropdown = !userDropdown" @click.away="userDropdown = false"
                            class="flex items-center gap-1 sm:gap-2 bg-white/5 hover:bg-white/10 border border-white/10 pl-1 pr-1.5 sm:pr-2 py-1 rounded-full transition-all group">

                            <!-- Profile Letter Icon (Responsive size) -->
                            <div
                                class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-gradient-to-br from-brand-gold to-yellow-600 flex items-center justify-center font-black text-brand-dark text-xs sm:text-sm shadow-inner">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>

                            <!-- Down Arrow Chevron -->
                            <svg class="w-3 h-3 sm:w-4 sm:h-4 text-brand-gold transition-transform duration-300"
                                :class="userDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7">
                                </path>
                            </svg>
                        </button>

                        <!-- Dropdown Content -->
                        <div x-show="userDropdown" x-cloak x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl py-2 border border-slate-200 text-slate-800 overflow-hidden">

                            <div class="px-4 py-3 border-b border-slate-100">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Account</p>
                                <p class="text-xs font-black text-brand-dark uppercase mt-1">{{ Auth::user()->name }}</p>
                            </div>

                            <a href="{{ Auth::user()->role == 'admin' ? route('admin.dashboard') : route('player.dashboard') }}"
                                class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">
                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                            <a href="{{ route('player.profile') }}"
                                class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A9 9 0 1118.364 4.561M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Profile
                            </a>
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ url('/admin/achievements/add') }}"
                                        class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">

                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 21h8M12 17v4m-4-4h8m2-13h-2a4 4 0 01-4 4 4 4 0 01-4-4H6a2 2 0 00-2 2v2a4 4 0 004 4h8a4 4 0 004-4V6a2 2 0 00-2-2z" />
                                        </svg>

                                        Add Achievement
                                    </a>
                                    <a href="{{ url('/admin-gallery') }}"
                                        class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">

                                        <!-- ICON -->
                                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4-4a3 3 0 014 0l4 4m-6-6l2-2a3 3 0 014 0l4 4M4 20h16a2 2 0 002-2V6a2 2 0 00-2-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>

                                        Add Image
                                    </a>
                                    <a href="{{ url('/admin/news') }}"
                                        class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">

                                        <!-- ICON -->
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21H5a2 2 0 01-2-2V7a2 2 0 012-2h11l5 5v9a2 2 0 01-2 2z" />
                                        </svg>

                                        Add News
                                    </a>
                                    <a href="{{ url('/admin/daily-attendance') }}"
                                        class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">

                                        <!-- ICON -->
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10m-11 9h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z" />
                                        </svg>

                                        Attendance
                                    </a>
                                @endif
                            @endauth
                            @auth
                                @if(Auth::user()->role === 'admin')
                                    <a href="{{ url('/admin/smart-issue') }}"
                                        class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">

                                        <!-- ICON -->
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 4v16m8-8H4"></path>
                                        </svg>

                                        Add Certificate
                                    </a>
                                    <a href="{{ url('/admin/messages') }}"
                                        class="flex items-center gap-3 px-4 py-3 hover:bg-slate-50 transition text-xs font-bold">

                                        <!-- ICON -->
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4-.8L3 20l1.8-3.6A7.963 7.963 0 013 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                            </path>
                                        </svg>

                                        Messages
                                    </a>
                                @endif
                            @endauth

                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="w-full flex items-center gap-3 px-4 py-3 hover:bg-red-50 transition text-xs font-black text-red-600 uppercase tracking-wider text-left border-t border-slate-50">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </div>
                @endguest

                <!-- Mobile Toggle (shrink-0 is the fix) -->
                <button @click="mobileMenu = true" class="lg:hidden p-1 text-white hover:text-brand-gold shrink-0">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenu" x-cloak x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="translate-x-full"
        class="fixed inset-0 z-[200] bg-brand-dark flex flex-col w-full h-full overflow-x-hidden">

        <div class="flex items-center justify-between px-6 py-5 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="bg-white p-1 rounded-lg">
                    <img src="{{ asset('images/logo.jpeg') }}" class="h-8 w-auto rounded">
                </div>
                <span class="font-black text-white italic uppercase tracking-tighter">ECFA <span
                        class="text-brand-gold">BIHAR</span></span>
            </div>
            <button @click="mobileMenu = false" class="p-2 bg-white/5 rounded-full text-white">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>

        <div class="flex-1 overflow-y-auto no-scrollbar px-8 py-10">
            @auth
                <div
                    class="bg-gradient-to-r from-white/10 to-transparent p-5 rounded-3xl border border-white/10 mb-8 text-center">
                    <p class="text-white font-black uppercase italic">{{ Auth::user()->name }}</p>
                    <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ Auth::user()->role }}
                        ACCOUNT ACTIVE</p>
                </div>
            @endauth

            <div class="flex flex-col gap-6">
                <a @click="mobileMenu = false" href="{{ url('/') }}"
                    class="text-4xl font-black tracking-tighter {{ Request::is('/') ? 'text-brand-gold' : 'text-white' }}">HOME</a>
                <a @click="mobileMenu = false" href="{{ url('/about') }}"
                    class="text-3xl font-black tracking-tighter text-slate-400 uppercase">About</a>
                <a @click="mobileMenu = false" href="{{ url('/members') }}"
                    class="text-3xl font-black tracking-tighter text-slate-400 uppercase">Players</a>
                <a @click="mobileMenu = false" href="{{ url('/events') }}"
                    class="text-3xl font-black tracking-tighter text-slate-400 uppercase">Events</a>
                <a @click="mobileMenu = false" href="{{ url('/achievements') }}"
                    class="text-3xl font-black tracking-tighter text-slate-400 uppercase">Honors</a>
                <a @click="mobileMenu = false" href="{{ url('/gallery') }}"
                    class="text-3xl font-black tracking-tighter text-slate-400 uppercase">Gallery</a>
                <a @click="mobileMenu = false" href="{{ url('/news') }}"
                    class="text-3xl font-black tracking-tighter text-slate-400 uppercase">News</a>
                <a @click="mobileMenu = false" href="{{ url('/contact') }}"
                    class="text-3xl font-black tracking-tighter text-slate-400 uppercase">Contact</a>
                <a @click="mobileMenu = false" href="{{ url('/learn') }}"
                    class="text-3xl font-black tracking-tighter text-blue-400 italic uppercase">Learn</a>
            </div>

            <div class="h-px bg-white/10 my-8"></div>

            <div class="flex flex-col gap-4">
                @guest
                    <a @click="mobileMenu = false" href="{{ url('/player-login') }}"
                        class="py-4 border border-white/20 rounded-2xl text-white font-bold uppercase text-center text-sm">Login</a>
                    <a @click="mobileMenu = false" href="{{ url('/registration') }}"
                        class="py-4 bg-brand-gold text-slate-950 rounded-2xl font-black uppercase text-center text-sm">Join</a>
                @else
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="w-full py-4 bg-red-500/10 text-red-500 border border-red-500/20 rounded-2xl font-black uppercase text-sm">Sign
                            Out</button>
                    </form>
                @endguest
            </div>
        </div>
    </div>

    <!-- Page Content -->
    <main class="relative w-full">
        @yield('content')
    </main>

    <!-- Professional Restore Footer -->
    <footer class="bg-brand-dark py-20 text-slate-500 border-t border-white/5 w-full">
        <div class="mx-auto max-w-7xl px-5 grid grid-cols-1 md:grid-cols-4 gap-12">
            <div class="col-span-1">
                <span class="font-black text-white text-2xl uppercase italic tracking-tighter mb-6 block">ECFA <span
                        class="text-brand-gold">BIHAR</span></span>
                <p class="text-sm leading-relaxed font-medium">Official authority for fencing in East Champaran region.
                    Dedicated to building champions of tomorrow.</p>
            </div>
            <div>
                <h3 class="text-white font-black text-xs uppercase tracking-[0.3em] mb-8">Navigation</h3>
                <ul class="text-sm space-y-4 font-bold">
                    <li><a href="{{ url('/events') }}" class="hover:text-brand-gold transition">Tournaments</a></li>
                    <li><a href="{{ url('/members') }}" class="hover:text-brand-gold transition">Athlete Registry</a>
                    </li>
                    <li><a href="{{ url('/achievements') }}" class="hover:text-brand-gold transition">Honors</a></li>
                    <li><a href="{{ url('/gallery') }}" class="hover:text-brand-gold transition">Gallery</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-white font-black text-xs uppercase tracking-[0.3em] mb-8">Contact Us</h3>
                <p class="text-sm font-bold">✉️ ecfamotihari@gmail.com</p>
                <p class="text-sm font-bold mt-2 uppercase">📍 Motihari, East Champaran, Bihar</p>
                <p class="text-sm font-bold mt-2 uppercase">📞 +91 9772960842</p>
            </div>
            <div>
                <h3 class="text-white font-black text-xs uppercase tracking-[0.3em] mb-8">Social Media</h3>
                <div class="flex gap-4">
                    <a href="#"
                        class="h-11 w-11 rounded-xl bg-white/5 flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all text-xs font-black">FB</a>
                    <a href="#"
                        class="h-11 w-11 rounded-xl bg-white/5 flex items-center justify-center hover:bg-pink-600 hover:text-white transition-all text-xs font-black">IG</a>
                </div>
            </div>
        </div>
        <div
            class="text-center text-[9px] font-black uppercase tracking-[0.5em] opacity-40 border-t border-white/5 mt-5 pt-5">
            &copy; {{ date('Y') }} ECFA Regional Authority. Built for Excellence.
            <div class="mt-4">
                <span class="opacity-50">Developed by</span>
                <a href="https://sanjeev-ky.vercel.app" target="_blank"
                    class="hover:text-blue-500 hover:opacity-500 transition-all duration-300 cursor-pointer decoration-blue-500">
                    Sanjeev kumar || Utkarsh
                </a>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>
