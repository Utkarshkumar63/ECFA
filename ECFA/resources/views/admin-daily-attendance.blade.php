@extends('layouts.app')

@section('title', 'Daily Register | ECFA')

@section('content')
<div class="min-h-screen bg-[#f1f5f9] pt-24 pb-12">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Compact Header -->
        <div class="flex flex-col md:flex-row justify-between items-end mb-6 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">
                    Daily <span class="text-blue-600">Register</span>
                </h1>
                <p class="text-slate-500 font-bold text-[10px] uppercase mt-1 tracking-widest">
                    {{ \Carbon\Carbon::parse($date)->format('l, d F Y') }} •
                    <span id="liveCounter" class="text-blue-600">Present: 0</span>
                </p>
            </div>

            <!-- Date Picker & Search combined -->
            <div class="flex items-center gap-2 bg-white p-1.5 rounded-2xl shadow-sm border border-slate-200">
                <input type="text" id="playerSearch" placeholder="Search athlete..." class="pl-3 pr-2 py-1 text-xs font-bold outline-none border-r border-slate-100 w-40">
                <form action="{{ route('admin.daily.attendance') }}" method="GET" class="flex items-center">
                    <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                           class="bg-transparent border-none font-black text-slate-700 outline-none text-xs px-2 cursor-pointer">
                </form>
            </div>
        </div>

        <form action="{{ route('admin.daily.attendance.save') }}" method="POST">
            @csrf
            <input type="hidden" name="attendance_date" value="{{ $date }}">

            <div class="bg-white rounded-3xl shadow-xl border border-slate-200 overflow-hidden">

                <!-- Quick Actions Bar -->
                <div class="px-6 py-3 bg-slate-50 border-b border-slate-100 flex justify-between items-center">
                    <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Athlete Roster</span>
                    <div class="flex gap-2">
                        <button type="button" id="markAll" class="text-[9px] font-black uppercase px-3 py-1 bg-white border border-slate-200 rounded-lg hover:bg-blue-600 hover:text-white transition">Mark All Present</button>
                        <button type="button" id="clearAll" class="text-[9px] font-black uppercase px-3 py-1 bg-white border border-slate-200 rounded-lg hover:bg-red-600 hover:text-white transition">Clear All</button>
                    </div>
                </div>

                <!-- DENSE TABLE -->
                <div class="overflow-y-auto max-h-[550px]">
                    <table class="w-full text-left border-collapse">
                        <thead class="sticky top-0 bg-white shadow-sm z-10">
                            <tr class="border-b border-slate-100">
                                <th class="pl-6 py-3 text-[10px] font-black uppercase text-slate-400 w-12">#</th>
                                <th class="py-3 text-[10px] font-black uppercase text-slate-400">Athlete Name</th>
                                <th class="py-3 text-[10px] font-black uppercase text-slate-400 hidden sm:table-cell">Weapon</th>
                                <th class="pr-6 py-3 text-[10px] font-black uppercase text-slate-400 text-right">Attendance</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($players as $index => $player)
                            <tr class="player-row hover:bg-blue-50/50 transition">
                                <td class="pl-6 py-3 text-[11px] font-bold text-slate-400">{{ $index + 1 }}</td>
                                <td class="py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="h-7 w-7 rounded-lg bg-slate-900 text-white flex items-center justify-center font-black text-[10px]">
                                            {{ substr($player->name, 0, 1) }}
                                        </div>
                                        <span class="player-name font-bold text-slate-800 text-sm tracking-tight">{{ $player->name }}</span>
                                    </div>
                                </td>
                                <td class="py-3 hidden sm:table-cell">
                                    <span class="text-[10px] font-black uppercase text-slate-500 bg-slate-100 px-2 py-0.5 rounded">{{ $player->category }}</span>
                                </td>
                                <td class="pr-6 py-3 text-right">
                                    <!-- Toggle Switch Small -->
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="present_players[]" value="{{ $player->id }}"
                                               class="sr-only peer attendance-check"
                                               {{ (isset($attendance[$player->id]) && $attendance[$player->id] == 'present') ? 'checked' : '' }}>
                                        <div class="w-10 h-5 bg-slate-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:bg-blue-600 after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all"></div>
                                        <span class="ml-2 text-[10px] font-black uppercase w-8 text-left peer-checked:text-blue-600 text-slate-400">
                                            {{ (isset($attendance[$player->id]) && $attendance[$player->id] == 'present') ? 'PRE' : 'ABS' }}
                                        </span>
                                    </label>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="p-10 text-center text-xs font-bold text-slate-400">No Athletes Found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Footer Submit -->
                <div class="p-4 bg-slate-900 flex justify-between items-center">
                    <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest">Marked by: {{ auth()->user()->name }}</p>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-8 py-3 rounded-xl font-black uppercase tracking-widest text-[11px] shadow-lg transition active:scale-95">
                        Save Register 💾
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.attendance-check');
        const counter = document.getElementById('liveCounter');
        const search = document.getElementById('playerSearch');
        const rows = document.querySelectorAll('.player-row');

        // Update counter on load and change
        function updateCount() {
            const checked = document.querySelectorAll('.attendance-check:checked').length;
            counter.innerText = `Present: ${checked} / ${checkboxes.length}`;
        }

        checkboxes.forEach(c => c.addEventListener('change', (e) => {
            updateCount();
            // Update the text label next to toggle
            const label = e.target.nextElementSibling.nextElementSibling;
            label.innerText = e.target.checked ? 'PRE' : 'ABS';
        }));

        updateCount();

        // Search functionality
        search.addEventListener('keyup', function() {
            let term = this.value.toLowerCase();
            rows.forEach(row => {
                let name = row.querySelector('.player-name').innerText.toLowerCase();
                row.style.display = name.includes(term) ? "" : "none";
            });
        });

        // Mark All Logic
        document.getElementById('markAll').addEventListener('click', () => {
            checkboxes.forEach(c => {
                c.checked = true;
                c.nextElementSibling.nextElementSibling.innerText = 'PRE';
            });
            updateCount();
        });

        document.getElementById('clearAll').addEventListener('click', () => {
            checkboxes.forEach(c => {
                c.checked = false;
                c.nextElementSibling.nextElementSibling.innerText = 'ABS';
            });
            updateCount();
        });
    });
</script>
@endsection
