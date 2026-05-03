@extends('layouts.app')

@section('title', 'Hall of Fame - Elite Achievements')

@push('styles')
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes shine {
            0% {
                left: -100%;
            }

            20% {
                left: 100%;
            }

            100% {
                left: 100%;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .achievement-card {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .image-shine {
            position: relative;
            overflow: hidden;
        }

        .image-shine::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: skewX(-25deg);
            animation: shine 4s infinite;
        }

        /* Bold Medal Styling */
        .medal-gold {
            background: #FFD700;
            color: #000;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        }

        .medal-silver {
            background: #E2E8F0;
            color: #1e293b;
            box-shadow: 0 0 15px rgba(226, 232, 240, 0.3);
        }

        .medal-bronze {
            background: #CD7F32;
            color: #fff;
            box-shadow: 0 0 15px rgba(205, 127, 50, 0.3);
        }

        .level-badge {
            background: #0f172a;
            color: #fff;
        }
    </style>
@endpush

@section('content')

    <!-- Updated Hero Section: Left & Right Layout -->
    <section class="relative min-h-[60vh] flex items-center overflow-hidden bg-[#020617] py-20 text-white">
        <!-- Watermark Background -->
        <div class="absolute inset-0 opacity-10"
            style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 150px; background-repeat: repeat;">
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#020617] via-[#020617]/90 to-transparent"></div>

        <div class="relative mx-auto max-w-7xl px-6 w-full">
            <div class="grid items-center gap-12 lg:grid-cols-2">
                <!-- Left Side: Content -->
                <div class="text-left">
                    <div
                        class="mb-6 inline-flex items-center gap-2 rounded-full border border-amber-500/30 bg-amber-500/10 px-4 py-2 text-xs font-black tracking-[0.2em] text-amber-500 uppercase">
                        <span class="relative flex h-2 w-2">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-amber-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-amber-500"></span>
                        </span>
                        The Elite Circle
                    </div>
                    <h1 class="text-5xl font-black tracking-tighter md:text-8xl leading-none">
                        HALL OF <br>
                        <span
                            class="bg-gradient-to-r from-amber-200 via-yellow-500 to-amber-200 bg-clip-text text-transparent">FAME</span>
                    </h1>
                    <p class="mt-8 max-w-lg text-lg font-medium leading-relaxed text-slate-400">
                        Celebrating the legendary fencers of East Champaran who have mastered the blade and brought glory to
                        the district.
                    </p>
                    <div class="mt-10 flex gap-4">
                        <div class="h-1 w-20 bg-amber-500 rounded-full"></div>
                        <div class="h-1 w-8 bg-slate-700 rounded-full"></div>
                    </div>
                </div>

                <!-- Right Side: Visual Element -->
                <div class="hidden lg:flex justify-center items-center">
                    <div class="relative">
                        <div class="absolute -inset-10 bg-blue-500/20 blur-[100px] rounded-full"></div>
                        <div style="animation: float 6s ease-in-out infinite;">
                            <!-- You can replace this with a large trophy icon or a fencing silhouette image -->
                            <span class="text-[180px] filter drop-shadow-[0_0_30px_rgba(245,158,11,0.5)]">🥇</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Scoreboard (Floating) -->
    <section class="relative z-30 -mt-16">
        <div class="mx-auto max-w-6xl px-4">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
                @foreach(['Gold' => 'gold-count', 'Silver' => 'silver-count', 'Bronze' => 'bronze-count'] as $label => $id)
                    <div
                        class="group overflow-hidden rounded-3xl bg-white/80 p-1 shadow-2xl backdrop-blur-xl transition-all hover:-translate-y-2">
                        <div class="flex items-center justify-between rounded-[1.4rem] bg-white p-8">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">{{ $label }} Medals
                                </p>
                                <h2 id="{{ $id }}" class="mt-1 text-5xl font-black text-slate-900">0</h2>
                            </div>
                            <div class="text-5xl transition-transform duration-500 group-hover:scale-125">
                                {{ $label == 'Gold' ? '🥇' : ($label == 'Silver' ? '🥈' : '🥉') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Filters -->
    <section class="mx-auto mt-20 max-w-6xl px-4">
        <div
            class="flex flex-col items-center justify-between gap-6 rounded-[2.5rem] border border-slate-200 bg-white p-5 shadow-xl md:flex-row md:px-10">
            <div class="flex items-center gap-4">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                    </svg>
                </div>
                <div>
                    <h4 class="font-black text-slate-900 leading-none">Filter Archive</h4>
                    <p class="text-xs font-bold text-slate-400 uppercase tracking-tighter mt-1">Search by Rank or Level</p>
                </div>
            </div>
            <div class="flex w-full gap-4 md:w-auto">
                <select id="filterLevel" onchange="filterAchievements()"
                    class="w-full min-w-[160px] rounded-2xl border-2 border-slate-100 bg-slate-50 px-6 py-3.5 text-sm font-black text-slate-700 outline-none focus:border-blue-500 transition-all">
                    <option value="">All Levels</option>
                    <option value="National">National</option>
                    <option value="State">State</option>
                    <option value="District">District</option>
                </select>
                <select id="filterMedal" onchange="filterAchievements()"
                    class="w-full min-w-[160px] rounded-2xl border-2 border-slate-100 bg-slate-50 px-6 py-3.5 text-sm font-black text-slate-700 outline-none focus:border-blue-500 transition-all">
                    <option value="">All Medals</option>
                    <option value="Gold">Gold</option>
                    <option value="Silver">Silver</option>
                    <option value="Bronze">Bronze</option>
                </select>
            </div>
        </div>
    </section>

    <!-- Achievements Grid -->
    <section class="mx-auto max-w-4xl px-6 py-20">
        <div id="achievements-container" class="grid gap-10 sm:grid-cols-2 lg:grid-cols-3">
            <!-- JS Injection -->
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        let allAchievements = @json($achievements);

        function renderAchievementCard(a, index) {
            const medalClass = a.medal_type === 'Gold' ? 'medal-gold' : (a.medal_type === 'Silver' ? 'medal-silver' : 'medal-bronze');
            const delay = index * 0.1;
            const athleteName = a.user ? a.user.name : 'Elite Fencer';

            const imageHtml = a.image
                ? `<div class="image-shine relative h-44 w-full overflow-hidden rounded-[1.5rem]">
                     <img src="${a.image}" alt="${a.title}" class="h-full w-full object-cover transition-transform duration-1000 group-hover:scale-110">
                     <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                   </div>`
                : `<div class="flex h-44 w-full items-center justify-center rounded-[1.5rem] bg-slate-100">
                     <span class="text-6xl opacity-20">🤺</span>
                   </div>`;

            return `
    <article class="achievement-card group relative flex flex-col rounded-[2.5rem] bg-white p-4 shadow-xl max-w-sm mx-auto w-full">                ${imageHtml}

                    <div class="flex-1 px-3 py-6">
                        <!-- Medals & Level Row: Bold & Distinct -->
                        <div class="mb-5 flex items-center justify-between gap-2">
                            <span class="inline-flex items-center gap-2 rounded-xl px-4 py-1.5 text-l font-black uppercase tracking-widest ${medalClass}">
                                ${getMedalEmoji(a.medal_type)} ${a.medal_type}
                            </span>
                            <span class="level-badge inline-flex items-center rounded-xl px-4 py-1.5 text-[10px] font-black uppercase tracking-[0.2em]">
                                ${a.level || 'Competition'}
                            </span>
                        </div>

                        <div class="flex justify-between items-start">

        <!-- LEFT -->
        <h3 class="text-lg font-black text-slate-900 group-hover:text-blue-600">
            ${a.title}
        </h3>

        <!-- RIGHT -->
        ${a.event_name ? `
            <p class="text-xs font-extrabold text-blue-500 uppercase">
                ${a.event_name}
            </p>
        ` : ''}

    </div>
                        <!-- Athlete Footer -->
                        <div class=" flex items-center gap-4 border-t border-slate-50 pt-6">
                            <div class="h-8 w-12 flex-shrink-0 overflow-hidden rounded-2xl bg-slate-900 font-black text-white flex items-center justify-center shadow-lg">
                                ${athleteName.charAt(0)}
                            </div>
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 leading-none mb-1">Champion</p>
                                <p class="text-base font-black text-slate-900">${athleteName}</p>
                            </div>
                        </div>
                    </div>
                </article>
            `;
        }

        // ... (rest of your existing init, updateCounters, and displayAchievements JS functions) ...
        function init() {
            updateCounters(allAchievements);
            displayAchievements(allAchievements);
        }

        function updateCounters(data) {
            const counts = {
                'Gold': data.filter(a => a.medal_type === 'Gold').length,
                'Silver': data.filter(a => a.medal_type === 'Silver').length,
                'Bronze': data.filter(a => a.medal_type === 'Bronze').length
            };
            animateValue("gold-count", 0, counts.Gold, 1500);
            animateValue("silver-count", 0, counts.Silver, 1500);
            animateValue("bronze-count", 0, counts.Bronze, 1500);
        }

        function animateValue(id, start, end, duration) {
            const obj = document.getElementById(id);
            if (!obj) return;
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start);
                if (progress < 1) window.requestAnimationFrame(step);
            };
            window.requestAnimationFrame(step);
        }

        function displayAchievements(achievements) {
            const container = document.getElementById('achievements-container');
            if (achievements.length === 0) {
                container.innerHTML = `<div class="col-span-full py-20 text-center font-black text-slate-300 text-2xl uppercase tracking-widest">No Champions Found</div>`;
            } else {
                container.innerHTML = achievements.map((a, i) => renderAchievementCard(a, i)).join('');
            }
        }

        function getMedalEmoji(type) {
            return { 'Gold': '🥇', 'Silver': '🥈', 'Bronze': '🥉' }[type] || '🏆';
        }

        function filterAchievements() {
            const level = document.getElementById('filterLevel').value;
            const medal = document.getElementById('filterMedal').value;
            let filtered = allAchievements;
            if (level) filtered = filtered.filter(a => a.level === level);
            if (medal) filtered = filtered.filter(a => a.medal_type === medal);
            displayAchievements(filtered);
        }

        document.addEventListener('DOMContentLoaded', init);
    </script>
@endpush
