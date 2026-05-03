@extends('layouts.app')

@section('content')
<!-- Alpine.js for Interactivity -->
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

<div class="min-h-screen bg-slate-50 pt-24 pb-12">
    <div class="max-w-5xl mx-auto px-4">

        <div class="mb-10 flex justify-between items-end">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tighter uppercase italic">Inbox</h1>
                <p class="text-slate-500 font-bold uppercase tracking-widest text-[10px]">Total Messages: {{ $messages->total() }}</p>
            </div>
            <div class="bg-indigo-600 text-white px-4 py-1 rounded-full text-[10px] font-black uppercase tracking-widest">
                Official Correspondence
            </div>
        </div>

        <div class="grid gap-4">
            @forelse($messages as $msg)
            <!-- Short Card with Alpine.js Toggle -->
            <div x-data="{ open: false }"
                 class="bg-white rounded-[1.5rem] shadow-sm border border-slate-100 overflow-hidden transition-all duration-300"
                 :class="open ? 'shadow-xl ring-2 ring-indigo-500/20' : 'hover:border-indigo-300'">

                <!-- THE SHORT CARD (Visible) -->
                <div @click="open = !open" class="p-5 md:px-8 flex items-center justify-between cursor-pointer select-none">
                    <div class="flex items-center gap-4 flex-1 overflow-hidden">
                        <!-- Avatar -->
                        <div class="h-10 w-10 rounded-xl flex-shrink-0 flex items-center justify-center font-black text-xs shadow-inner"
                             :class="'{{ $msg->reply_message }}' ? 'bg-emerald-50 text-emerald-600' : 'bg-indigo-50 text-indigo-600'">
                            {{ substr($msg->name, 0, 1) }}
                        </div>

                        <!-- Details Truncated -->
                        <div class="overflow-hidden">
                            <h3 class="font-black text-slate-800 text-sm truncate uppercase italic tracking-tight">{{ $msg->name }}</h3>
                            <p class="text-[11px] font-bold text-slate-400 truncate tracking-tight">Subject: {{ $msg->subject }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-6 ml-4">
                        <div class="hidden md:block text-right">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-tighter">
                                {{ $msg->created_at->format('d M') }}
                            </p>
                            @if($msg->reply_message)
                                <span class="text-[8px] font-black text-emerald-500 uppercase tracking-widest italic">Replied</span>
                            @else
                                <span class="text-[8px] font-black text-amber-500 uppercase tracking-widest italic animate-pulse">New</span>
                            @endif
                        </div>
                        <!-- Toggle Icon -->
                        <svg class="w-4 h-4 text-slate-400 transition-transform duration-300"
                             :class="open ? 'rotate-180' : ''"
                             fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M19 9l-7 7-7-7"/></svg>
                    </div>
                </div>

                <!-- THE EXPANDED DETAILS (Hidden by default) -->
                <div x-show="open"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-4"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="px-8 pb-8 pt-2 border-t border-slate-50 bg-slate-50/30">

                    <div class="py-4 space-y-4">
                        <div class="flex justify-between items-center text-[10px] font-black uppercase text-slate-400 border-b pb-2">
                            <span>Email: {{ $msg->email }}</span>
                            <span>Full Date: {{ $msg->created_at->format('d M, Y | h:i A') }}</span>
                        </div>

                        <!-- User Original Message -->
                        <div class="bg-white p-6 rounded-2xl border border-slate-100 italic text-slate-700 leading-relaxed">
                            "{{ $msg->message }}"
                        </div>

                        @if($msg->reply_message)
                            <!-- Show Response History -->
                            <div class="bg-emerald-500/5 border border-emerald-100 p-6 rounded-2xl">
                                <div class="flex justify-between mb-2">
                                    <p class="text-[9px] font-black text-emerald-600 uppercase tracking-widest">Official Response</p>
                                    <p class="text-[9px] font-bold text-slate-400 italic">
                                        Sent {{ \Carbon\Carbon::parse($msg->replied_at)->diffForHumans() }}
                                    </p>
                                </div>
                                <p class="text-slate-800 font-bold text-sm">{{ $msg->reply_message }}</p>
                            </div>
                        @else
                            <!-- Simple Reply Action -->
                            <form action="{{ route('admin.messages.reply', $msg->id) }}" method="POST" class="mt-6 space-y-3">
                                @csrf
                                <textarea name="reply_message" rows="3" required
                                    class="w-full bg-white border-2 border-slate-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-100 outline-none transition-all font-semibold text-sm"
                                    placeholder="Enter your response..."></textarea>
                                <div class="flex justify-end">
                                    <button type="submit" class="bg-indigo-900 hover:bg-black text-white px-8 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest transition-all shadow-lg flex items-center gap-2">
                                        Deploy Reply
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-slate-200">
                <p class="text-slate-300 font-black uppercase tracking-[0.3em] italic">No Communication Records Found</p>
            </div>
            @endforelse
        </div>

        <div class="mt-10">
            {{ $messages->links() }}
        </div>
    </div>
</div>
@endsection
