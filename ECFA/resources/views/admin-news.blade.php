@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-[#fdfeff] pt-28 pb-12">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Header: Premium Modern Look -->
        <div class="mb-12 flex flex-col md:flex-row justify-between items-end gap-6 border-b border-slate-100 pb-8">
            <div>
                <span class="text-indigo-600 font-bold text-[10px] uppercase tracking-[0.3em] mb-2 block">Control Center</span>
                <h1 class="text-5xl font-black text-slate-900 tracking-tighter uppercase italic leading-none">
                    News <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600 font-light">Studio</span>
                </h1>
                <p class="text-slate-400 font-medium mt-2">Manage the heartbeat of your association's updates.</p>
            </div>
            <a href="{{ route('news.index') }}"
                class="group flex items-center gap-3 text-xs font-black uppercase tracking-widest bg-slate-900 text-white px-8 py-4 rounded-2xl hover:bg-indigo-600 transition-all duration-300 shadow-xl shadow-slate-200">
                View Public Newsroom
                <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 8l4 4m0 0l-4 4m4-4H3" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
            </a>
        </div>

        <div class="grid lg:grid-cols-12 gap-10">
            <!-- Left Side: Interactive Form -->
            <div class="lg:col-span-4">
                <div class="bg-white rounded-[2.5rem] shadow-[0_20px_50px_rgba(79,70,229,0.1)] p-8 border border-slate-50 sticky top-28">
                    <div class="flex items-center gap-3 mb-8">
                        <div class="h-10 w-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h3 class="text-xl font-black text-slate-800 uppercase italic">Publish Update</h3>
                    </div>

                    <!-- Messages & Error Handling -->
                    @if(session('success'))
                        <div class="mb-6 p-4 bg-emerald-50 text-emerald-700 rounded-2xl text-xs font-bold border border-emerald-100 flex items-center gap-2 animate-pulse">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"></path></svg>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-6 p-4 bg-rose-50 text-rose-700 rounded-2xl text-[10px] font-bold border border-rose-100">
                            <ul class="list-disc ml-4">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.news.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Headline</label>
                            <input type="text" name="title" required value="{{ old('title') }}"
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-bold text-sm transition-all" placeholder="Enter title...">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Category</label>
                            <div class="relative">
                                <select name="type" required
                                    class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-bold text-sm transition-all appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select Category</option>
                                    <option value="News">News Article</option>
                                    <option value="Announcement">Official Announcement</option>
                                    <option value="Event">Upcoming Event</option>
                                    <option value="Result">Match Results</option>
                                    <option value="Achievement">Player Achievement</option>
                                    <option value="Tournament">Tournament Update</option>
                                    <option value="Training">Training Camp</option>
                                    <option value="Workshop">Workshop / Seminar</option>
                                    <option value="Selection">Team Selection</option>
                                    <option value="Notice">Important Notice</option>
                                    <option value="Alert">Urgent Alert</option>
                                    <option value="Recruitment">Recruitment / Trials</option>
                                    <option value="Ranking">Player Rankings</option>
                                    <option value="Highlight">Match Highlights</option>
                                    <option value="Injury">Injury Update</option>
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1">Description</label>
                            <textarea name="description" rows="5" required
                                class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-4 focus:border-indigo-500 focus:bg-white outline-none font-medium text-sm transition-all" placeholder="Write full details...">{{ old('description') }}</textarea>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-slate-900 to-indigo-900 hover:from-indigo-600 hover:to-violet-600 text-white py-5 rounded-2xl font-black text-[11px] uppercase tracking-[0.2em] transition-all shadow-xl shadow-indigo-100 hover:-translate-y-1">
                            Publish Now
                        </button>
                    </form>
                </div>
            </div>

            <!-- Right Side: Recent News List -->
            <div class="lg:col-span-8 space-y-6">
                <div class="flex items-center justify-between px-2">
                    <h3 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.3em]">Latest Registry</h3>
                    <div class="h-1 w-20 bg-indigo-100 rounded-full"></div>
                </div>

                @forelse($news as $item)
                    <div class="group bg-white rounded-3xl p-6 border border-slate-100 shadow-sm hover:shadow-2xl hover:shadow-indigo-50 hover:border-indigo-200 transition-all duration-500 flex items-center justify-between">
                        <div class="flex items-center gap-6">
                            <!-- Premium Date Icon -->
                            <div class="h-16 w-16 rounded-2xl bg-slate-50 group-hover:bg-indigo-600 group-hover:scale-110 transition-all duration-500 flex flex-col items-center justify-center border border-slate-100 group-hover:border-indigo-500">
                                <span class="text-[10px] font-black text-indigo-600 group-hover:text-white uppercase leading-none">{{ $item->created_at->format('M') }}</span>
                                <span class="text-2xl font-black text-slate-800 group-hover:text-white leading-tight">{{ $item->created_at->format('d') }}</span>
                            </div>

                            <div class="max-w-md">
                                <div class="flex items-center gap-3 mb-2">
                                    <!-- Dynamic Color based on type (Optional - uses Indigo as default) -->
                                    <span class="text-[9px] font-black uppercase tracking-widest px-2.5 py-1 rounded-lg bg-indigo-50 text-indigo-600 border border-indigo-100">
                                        {{ $item->type }}
                                    </span>
                                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                        {{ $item->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <h4 class="font-bold text-slate-800 uppercase italic tracking-tight text-lg group-hover:text-indigo-600 transition-colors line-clamp-1">
                                    {{ $item->title }}
                                </h4>
                                <p class="text-[11px] text-slate-400 font-medium line-clamp-1 mt-1">{{ Str::limit($item->description, 100) }}</p>
                            </div>
                        </div>

                        <!-- Actions (Edit & Delete) -->
                        <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-4 group-hover:translate-x-0">
                            <!-- Edit Button -->
                            <a href="{{ route('admin.news.edit', $item->id) }}"
                                class="p-3 text-slate-400 hover:text-amber-500 hover:bg-amber-50 rounded-xl transition-all border border-transparent hover:border-amber-100 shadow-sm"
                                title="Edit Post">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <!-- Delete Button -->
                            <form action="{{ route('admin.news.delete', $item->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to permanently delete this update?')">
                                @csrf
                                @method('DELETE')
                                <button class="p-3 text-slate-400 hover:text-rose-500 hover:bg-rose-50 rounded-xl transition-all border border-transparent hover:border-rose-100 shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="bg-white rounded-[3rem] p-24 text-center border-2 border-dashed border-slate-100">
                        <div class="mb-4 flex justify-center">
                            <svg class="w-12 h-12 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l4 4v10a2 2 0 01-2 2z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                        </div>
                        <p class="text-slate-300 font-black uppercase tracking-[0.3em] text-[10px]">Registry is currently empty</p>
                    </div>
                @endforelse

                <div class="mt-12">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
