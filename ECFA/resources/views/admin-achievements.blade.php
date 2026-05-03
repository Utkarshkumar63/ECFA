@extends('layouts.app')

@section('title', 'Achievement Control - ECFA')

@section('content')
<div class="min-h-screen bg-[#f8fafc] pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header -->
        <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-4xl font-black text-slate-900 uppercase italic tracking-tighter">
                    Hall of Fame <span class="text-blue-600">Control</span>
                </h1>
                <p class="text-slate-500 font-medium italic uppercase tracking-widest text-[10px]">Managing the Legacy of Champions</p>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="bg-slate-900 text-white px-8 py-3 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 transition shadow-xl shadow-slate-200">
                ← Command Center
            </a>
        </div>

        <div class="grid lg:grid-cols-12 gap-8">

            <!-- ADD ACHIEVEMENT FORM -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-2xl p-8 sticky top-28">
                    <h2 class="text-xl font-black text-slate-900 uppercase italic mb-6">Enroll Champion</h2>

                    <form action="{{ route('admin.achievement.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Champion Athlete</label>
                            <select name="user_id" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 focus:border-blue-500 outline-none font-bold text-sm">
                                <option value="">Select Athlete...</option>
                                @foreach($players as $player)
                                    <option value="{{ $player->id }}">{{ $player->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Achievement Title</label>
                            <input type="text" name="title" required placeholder="e.g. State Sabre Champion" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 focus:border-blue-500 outline-none font-bold text-sm">
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Medal</label>
                                <select name="medal_type" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 focus:border-blue-500 outline-none font-bold text-sm">
                                    <option value="Gold">🥇 Gold</option>
                                    <option value="Silver">🥈 Silver</option>
                                    <option value="Bronze">🥉 Bronze</option>
                                </select>
                            </div>
                            <div class="space-y-1">
                                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Level</label>
                                <select name="level" required class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 focus:border-blue-500 outline-none font-bold text-sm">
                                    <option value="National">National</option>
                                    <option value="State">State</option>
                                    <option value="District">District</option>
                                </select>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Event Name</label>
                            <input type="text" name="event_name" placeholder="e.g. 24th National Cup" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 focus:border-blue-500 outline-none font-bold text-sm">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Ceremony Image (Cloudinary)</label>
                            <input type="file" name="image" class="w-full text-xs text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Achievement Description</label>
                            <textarea name="description" rows="3" placeholder="Brief details about the performance..." class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-4 py-3 focus:border-blue-500 outline-none font-medium text-sm"></textarea>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-black text-[10px] uppercase tracking-[0.3em] transition shadow-xl shadow-blue-100 active:scale-95">
                            Authorize Entry <span>→</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- REGISTRY LIST -->
            <div class="lg:col-span-8">
                @if(session('success'))
                    <div class="mb-6 p-5 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-3xl font-bold text-xs italic">
                        ✓ {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-xl overflow-hidden">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-900 text-white">
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Visual</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Champion</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest">Medal / Title</th>
                                <th class="px-8 py-5 text-[10px] font-black uppercase tracking-widest text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse($achievements as $a)
                            <tr class="hover:bg-slate-50 transition group">
                                <td class="px-8 py-6">
                                    <div class="h-14 w-14 rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-sm">
                                        @if($a->image)
                                            <img src="{{ $a->image }}" class="h-full w-full object-cover group-hover:scale-110 transition duration-500" alt="Ceremony">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-xl grayscale opacity-20">🤺</div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="font-black text-slate-800 text-sm uppercase italic">{{ $a->user->name ?? 'Unknown' }}</div>
                                    <div class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ $a->event_name ?? 'Official Event' }}</div>
                                </td>
                                <td class="px-8 py-6">
                                    @php
                                        $medalStyle = [
                                            'Gold' => 'bg-amber-50 text-amber-600 border-amber-100',
                                            'Silver' => 'bg-slate-50 text-slate-500 border-slate-200',
                                            'Bronze' => 'bg-orange-50 text-orange-600 border-orange-100'
                                        ][$a->medal_type] ?? 'bg-blue-50 text-blue-600 border-blue-100';
                                    @endphp
                                    <div class="font-black text-slate-700 text-xs uppercase tracking-tighter">{{ $a->title }}</div>
                                    <span class="{{ $medalStyle }} px-2 py-0.5 rounded text-[8px] font-black uppercase tracking-widest border inline-block mt-1">
                                        {{ $a->medal_type }} - {{ $a->level }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <form action="{{ route('admin.achievement.delete', $a->id) }}" method="POST" onsubmit="return confirm('Purge this record from Hall of Fame?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2.5 bg-red-50 text-red-500 rounded-xl hover:bg-red-500 hover:text-white transition shadow-sm">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-8 py-20 text-center text-slate-300 font-bold uppercase tracking-[0.4em]">Registry is empty</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-8">
                    {{ $achievements->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
