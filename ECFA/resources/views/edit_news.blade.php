@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fdfeff] pt-28 pb-12">
    <div class="max-w-4xl mx-auto px-4">

        <!-- Breadcrumb & Back Button -->
        <div class="mb-8">
            <a href="{{ route('admin.news') }}" class="group inline-flex items-center gap-2 text-slate-400 hover:text-indigo-600 transition-colors">
                <div class="h-8 w-8 rounded-full border border-slate-200 flex items-center justify-center group-hover:border-indigo-100 group-hover:bg-indigo-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </div>
                <span class="text-[10px] font-black uppercase tracking-widest">Back to Newsroom</span>
            </a>
        </div>

        <!-- Header Section -->
        <div class="mb-10">
            <span class="text-indigo-600 font-bold text-[10px] uppercase tracking-[0.3em] mb-2 block">Editor Mode</span>
            <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                Edit <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 font-light">Update</span>
            </h1>
            <p class="text-slate-400 font-medium mt-3 italic">"Refining the narrative to perfection."</p>
        </div>

        <!-- Premium Edit Card -->
        <div class="bg-white rounded-[3rem] shadow-[0_30px_60px_rgba(79,70,229,0.08)] border border-slate-50 overflow-hidden">
            <div class="grid md:grid-cols-12">

                <!-- Left Sidebar Decoration -->
                <div class="md:col-span-1 bg-indigo-600 flex items-center justify-center py-8">
                    <span class="rotate-[-90deg] text-white/30 font-black uppercase tracking-[0.5em] whitespace-nowrap text-[10px]">Registry Edit</span>
                </div>

                <!-- Main Form Area -->
                <div class="md:col-span-11 p-8 md:p-12">

                    @if($errors->any())
                        <div class="mb-8 p-5 bg-rose-50 text-rose-700 rounded-3xl text-xs font-bold border border-rose-100 flex items-center gap-3">
                            <div class="h-8 w-8 bg-rose-100 rounded-full flex items-center justify-center flex-shrink-0">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"></path></svg>
                            </div>
                            <ul class="list-disc ml-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- User's Route expects POST to /admin/news/update/{id} -->
                    <form action="{{ route('admin.news.update', $newsItem->id) }}" method="POST" class="space-y-8">
                        @csrf
                        <!-- Title Field -->
                        <div class="space-y-3 group">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 group-focus-within:text-indigo-600 transition-colors">Headline</label>
                            <input type="text" name="title" required
                                value="{{ old('title', $newsItem->title) }}"
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-5 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-800 transition-all shadow-sm"
                                placeholder="Enter updated headline...">
                        </div>

                        <!-- Category Selector -->
                        <div class="grid md:grid-cols-2 gap-8">
                            <div class="space-y-3">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Classification</label>
                                <div class="relative">
                                    <select name="type" required
                                        class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-6 py-5 focus:border-indigo-500 focus:bg-white outline-none font-bold text-slate-700 transition-all appearance-none cursor-pointer">
                                        @php
                                            $categories = [
                                                'News', 'Announcement', 'Event', 'Result', 'Achievement',
                                                'Tournament', 'Training', 'Workshop', 'Selection', 'Notice',
                                                'Alert', 'Recruitment', 'Ranking', 'Highlight', 'Injury'
                                            ];
                                        @endphp
                                        @foreach($categories as $category)
                                            <option value="{{ $category }}" {{ $newsItem->type == $category ? 'selected' : '' }}>
                                                {{ $category }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="absolute right-6 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    </div>
                                </div>
                            </div>

                            <!-- Meta Info (Read Only for Context) -->
                            <div class="space-y-3">
                                <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1 text-opacity-50">Log Info</label>
                                <div class="bg-slate-50 border-2 border-dashed border-slate-100 rounded-2xl px-6 py-5 flex items-center justify-between">
                                    <span class="text-xs font-bold text-slate-400">Created: {{ $newsItem->created_at->format('d M, Y') }}</span>
                                    <span class="text-[10px] font-black text-indigo-300">ID: #{{ $newsItem->id }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Content Area -->
                        <div class="space-y-3">
                            <label class="block text-[11px] font-black text-slate-400 uppercase tracking-widest ml-1">Full Narrative</label>
                            <textarea name="description" rows="8" required
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-[2rem] px-6 py-6 focus:border-indigo-500 focus:bg-white outline-none font-medium text-slate-700 transition-all shadow-sm leading-relaxed"
                                placeholder="Describe the update in detail...">{{ old('description', $newsItem->description) }}</textarea>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col md:flex-row gap-4 pt-4">
                            <button type="submit"
                                class="flex-1 bg-gradient-to-r from-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.2em] transition-all shadow-xl shadow-indigo-100 hover:shadow-indigo-200 hover:-translate-y-1 flex items-center justify-center gap-3">
                                <svg class="w-5 h-5 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                Save Changes
                            </button>

                            <a href="{{ route('admin.news') }}"
                                class="px-10 py-5 rounded-2xl border-2 border-slate-100 font-black text-xs uppercase tracking-[0.2em] text-slate-400 hover:bg-slate-50 hover:text-slate-600 transition-all text-center">
                                Cancel
                            </a>
                        </div>
                    </form>

                </div>
            </div>
        </div>

        <!-- Subtle Footer Quote -->
        <p class="text-center mt-12 text-[10px] font-bold text-slate-300 uppercase tracking-[0.4em]">
            Official News Management Portal &copy; {{ date('Y') }}
        </p>
    </div>
</div>

<style>
    /* Premium Smooth Entry Animation */
    form > div {
        animation: slideUp 0.5s ease-out forwards;
        opacity: 0;
    }
    form > div:nth-child(1) { animation-delay: 0.1s; }
    form > div:nth-child(2) { animation-delay: 0.2s; }
    form > div:nth-child(3) { animation-delay: 0.3s; }
    form > div:nth-child(4) { animation-delay: 0.4s; }

    @keyframes slideUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
</style>
@endsection
