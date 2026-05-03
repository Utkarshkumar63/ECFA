@extends('layouts.app')

@section('title', 'Event Attendance | ECFA')

@section('content')
<div class="min-h-screen bg-[#f8fafc] pt-24 pb-12">
    <div class="max-w-6xl mx-auto px-4">

        <!-- Header -->
        <div class="mb-8 flex justify-between items-end">
            <div>
                <h1 class="text-3xl font-black text-slate-900 uppercase italic leading-none">
                    Event <span class="text-blue-600">Attendance</span>
                </h1>
                <p class="text-slate-500 font-bold text-[11px] uppercase mt-2 tracking-widest">
                    Tournament: <span class="text-slate-800">{{ $event->title }}</span>
                </p>
            </div>
            <a href="{{ route('admin.events') }}" class="text-[10px] font-black uppercase text-slate-400 hover:text-blue-600 transition">← Back to Events</a>
        </div>

        <form action="{{ route('admin.event.attendance.store', $event->id) }}" method="POST">
            @csrf
            <div class="bg-white rounded-[2rem] shadow-xl border border-slate-200 overflow-hidden">

                <table class="w-full text-left border-collapse">
                    <thead class="bg-slate-50 border-b border-slate-100">
                        <tr>
                            <th class="pl-8 py-4 text-[10px] font-black uppercase text-slate-400">Athlete</th>
                            <th class="py-4 text-[10px] font-black uppercase text-slate-400">Weapon</th>
                            <th class="py-4 text-[10px] font-black uppercase text-slate-400">Status</th>
                            <th class="pr-8 py-4 text-[10px] font-black uppercase text-slate-400">Reason for Absence (If any)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($event->athletes as $athlete)
                        <tr class="hover:bg-slate-50/50 transition attendance-row">
                            <td class="pl-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-lg bg-blue-600 text-white flex items-center justify-center font-black text-xs">
                                        {{ substr($athlete->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-slate-800 text-sm">{{ $athlete->name }}</span>
                                </div>
                            </td>
                            <td class="py-4">
                                <span class="text-[10px] font-black text-slate-500 bg-slate-100 px-2 py-1 rounded uppercase">{{ $athlete->category }}</span>
                            </td>
                            <td class="py-4">
                                <select name="attendance[{{ $athlete->id }}]"
                                        class="status-select bg-slate-50 border-2 border-slate-100 rounded-xl px-3 py-1.5 text-xs font-black uppercase outline-none focus:border-blue-500 transition">
                                    <option value="present" {{ $athlete->pivot->attendance_status == 'present' ? 'selected' : '' }}>Present</option>
                                    <option value="absent" {{ $athlete->pivot->attendance_status == 'absent' ? 'selected' : '' }} class="text-red-600">Absent</option>
                                </select>
                            </td>
                            <td class="pr-8 py-4">
                                <input type="text" name="reasons[{{ $athlete->id }}]"
                                       value="{{ $athlete->pivot->absent_reason }}"
                                       placeholder="e.g. Injury, Exam, Personal..."
                                       class="reason-input w-full bg-slate-50 border-2 border-slate-100 rounded-xl px-4 py-2 text-xs font-bold outline-none focus:border-blue-500 transition {{ $athlete->pivot->attendance_status != 'absent' ? 'opacity-30' : '' }}">
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-20 text-center font-black text-slate-300 uppercase tracking-widest">No selected participants found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Save Bar -->
                <div class="p-6 bg-slate-900 flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <div class="h-10 w-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <p class="text-white text-[10px] font-bold uppercase tracking-widest">Only 'Selected' athletes are listed here.</p>
                    </div>
                    <button type="submit" class="bg-blue-600 hover:bg-blue-500 text-white px-10 py-4 rounded-2xl font-black uppercase tracking-widest text-[11px] shadow-xl transition active:scale-95">
                        Submit Event Report 📑
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.querySelectorAll('.status-select').forEach(select => {
        select.addEventListener('change', function() {
            const row = this.closest('tr');
            const reasonInput = row.querySelector('.reason-input');

            if (this.value === 'absent') {
                row.classList.add('bg-red-50/50');
                reasonInput.classList.remove('opacity-30');
                reasonInput.focus();
            } else {
                row.classList.remove('bg-red-50/50');
                reasonInput.classList.add('opacity-30');
                reasonInput.value = '';
            }
        });
    });
</script>
@endsection
