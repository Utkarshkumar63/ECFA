@extends('layouts.app')

@section('title', 'Get in Touch with ECFA')

@push('styles')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeInUp 0.6s ease-out forwards; }
    .card-delay-1 { animation-delay: 0.1s; }
    .card-delay-2 { animation-delay: 0.2s; }
    .card-delay-3 { animation-delay: 0.3s; }
</style>
@endpush

@section('content')
<!-- Dynamic Hero Section -->
<section class="relative overflow-hidden bg-slate-900 py-24 text-white">
    <div class="absolute inset-0 opacity-10" style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 300px; filter: grayscale(100%);"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-blue-900/40 to-slate-900"></div>

    <div class="relative mx-auto max-w-6xl px-4 text-center animate-fade-in">
        <span class="inline-block rounded-full bg-indigo-500/10 px-4 py-1.5 text-xs font-bold uppercase tracking-[0.2em] text-indigo-400 ring-1 ring-indigo-500/20 mb-6">Connect with us</span>
        <h1 class="text-5xl font-black tracking-tighter md:text-7xl">Get in <span class="text-amber-400">Touch</span></h1>
        <p class="mx-auto mt-6 max-w-2xl text-lg text-slate-300 leading-relaxed">
            Have questions about registration, training, or events? Our team is here to help you start your fencing journey in East Champaran.
        </p>
    </div>
</section>

<!-- Main Contact Section -->
<section class="relative z-10 -mt-16 pb-24">
    <div class="mx-auto max-w-6xl px-4">
        <div class="grid gap-12 lg:grid-cols-3">

            <!-- Left Side: Contact Cards -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Location Card -->
                <div class="animate-fade-in card-delay-1 bg-white rounded-3xl p-8 shadow-xl border border-slate-100 group hover:border-indigo-400 transition-all duration-300">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl mb-6 group-hover:bg-indigo-600 group-hover:text-white group-hover:rotate-6 transition-all duration-300 shadow-inner">📍</div>
                    <h3 class="text-xl font-black text-slate-900 mb-2 tracking-tight">Our Headquarters</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        East Champaran Sports Complex,<br>
                        Motihari, Bihar 845401, India
                    </p>
                </div>

                <!-- Phone Card -->
                <div class="animate-fade-in card-delay-2 bg-white rounded-3xl p-8 shadow-xl border border-slate-100 group hover:border-indigo-400 transition-all duration-300">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl mb-6 group-hover:bg-indigo-600 group-hover:text-white group-hover:rotate-6 transition-all duration-300 shadow-inner">📞</div>
                    <h3 class="text-xl font-black text-slate-900 mb-2 tracking-tight">Phone Support</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-bold hover:text-indigo-600 transition-colors cursor-pointer">+91 9772960842</p>
                    <p class="text-[10px] text-slate-400 uppercase tracking-widest mt-2 font-black">Mon–Sat: 06 AM – 08 PM</p>
                </div>

                <!-- Email Card -->
                <div class="animate-fade-in card-delay-3 bg-white rounded-3xl p-8 shadow-xl border border-slate-100 group hover:border-indigo-400 transition-all duration-300">
                    <div class="h-14 w-14 rounded-2xl bg-indigo-50 flex items-center justify-center text-3xl mb-6 group-hover:bg-indigo-600 group-hover:text-white group-hover:rotate-6 transition-all duration-300 shadow-inner">✉️</div>
                    <h3 class="text-xl font-black text-slate-900 mb-2 tracking-tight">Official Email</h3>
                    <p class="text-slate-500 text-sm leading-relaxed font-bold hover:text-indigo-600 transition-colors cursor-pointer">ecfamotihari@gmail.com</p>
                </div>
            </div>

            <!-- Right Side: Interactive Form -->
            <div class="lg:col-span-2 animate-fade-in card-delay-2">
                <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-2xl border border-slate-100 relative overflow-hidden">
                    <div class="absolute top-0 right-0 h-32 w-32 bg-indigo-50 rounded-full -mr-16 -mt-16 opacity-50"></div>

                    <h2 class="relative z-10 text-3xl font-black text-slate-900 tracking-tighter mb-8">Send a Message</h2>

                    <!-- Success Message -->
                    @if(session('success'))
                        <div class="mb-8 p-5 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl font-bold text-sm flex items-center gap-3">
                            <span class="text-xl">✅</span> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6 relative z-10">
                        @csrf
                        <div class="grid gap-6 md:grid-cols-2">
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Full Name</label>
                                <input type="text" name="name" value="{{ old('name') }}" required
                                    class="w-full bg-slate-50 border @error('name') border-red-400 @else border-slate-100 @enderror rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-100 focus:bg-white outline-none transition-all font-semibold"
                                    placeholder="Enter your name">
                                @error('name') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Email Address</label>
                                <input type="email" name="email" value="{{ old('email') }}" required
                                    class="w-full bg-slate-50 border @error('email') border-red-400 @else border-slate-100 @enderror rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-100 focus:bg-white outline-none transition-all font-semibold"
                                    placeholder="yourname@email.com">
                                @error('email') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Subject</label>
                            <input type="text" name="subject" value="{{ old('subject') }}" required
                                class="w-full bg-slate-50 border @error('subject') border-red-400 @else border-slate-100 @enderror rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-100 focus:bg-white outline-none transition-all font-semibold"
                                placeholder="What is this regarding?">
                            @error('subject') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Your Message</label>
                            <textarea name="message" rows="5" required
                                class="w-full bg-slate-50 border @error('message') border-red-400 @else border-slate-100 @enderror rounded-2xl px-5 py-4 focus:ring-4 focus:ring-indigo-100 focus:bg-white outline-none transition-all font-semibold"
                                placeholder="Write your message here...">{{ old('message') }}</textarea>
                            @error('message') <span class="text-red-500 text-[10px] font-bold mt-1 ml-2">{{ $message }}</span> @enderror
                        </div>

                        <div class="flex items-center gap-3 px-2">
                            <input type="checkbox" id="agree" required class="h-5 w-5 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            <label for="agree" class="text-xs font-bold text-slate-500 uppercase tracking-wide cursor-pointer select-none">I agree to be contacted via email/phone</label>
                        </div>

                        <button type="submit"
                            class="group w-full bg-indigo-600 hover:bg-indigo-700 text-white py-5 rounded-2xl font-black text-sm transition-all duration-300 shadow-xl shadow-indigo-600/30 uppercase tracking-[0.2em] flex items-center justify-center gap-3">
                            <span>Dispatch Message</span>
                            <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Integrated Map Section -->
        <div class="mt-20 animate-fade-in card-delay-3">
            <div class="flex items-center gap-4 mb-8">
                <h2 class="text-3xl font-black text-slate-900 tracking-tight">Locate Our Arena</h2>
                <div class="h-px flex-1 bg-slate-200"></div>
            </div>
            <div class="overflow-hidden rounded-[3rem] shadow-2xl border-8 border-white ring-1 ring-slate-200">
                <iframe class="h-[500px] w-full filter hover:grayscale-0 transition-all duration-700"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14371.49216744038!2d84.9048386!3d26.6575971!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39933501a3554907%3A0xb35a0d33e5c7a5!2sMotihari%2C%20Bihar!5e0!3m2!1sen!2sin!4v1712345678901"
                        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</section>

<!-- Bottom CTA -->
<section class="max-w-6xl mx-auto px-4 pb-24 text-center">
    <div class="bg-slate-50 rounded-[2rem] py-10 px-6 border border-slate-200">
        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs mb-2">Need immediate help?</p>
        <p class="text-slate-700 font-black text-xl italic">"Our mission is to serve every fencer with precision and speed."</p>
    </div>
</section>
@endsection
