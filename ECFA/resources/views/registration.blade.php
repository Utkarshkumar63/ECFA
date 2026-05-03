@extends('layouts.app')

@section('title', 'Athlete Registration - Join ECFA')

@section('content')
    <!-- High-End Registration Hero -->
    <section class="relative overflow-hidden bg-slate-950 py-24 text-white">
        <!-- Fixed Logo Watermark -->
        <div class="absolute inset-0 opacity-15"
            style="background-image: url('{{ asset('images/logo.jpeg') }}'); background-size: 350px; filter: grayscale(100%) brightness(50%);">
        </div>
        <div class="absolute inset-0 bg-gradient-to-br from-slate-950 via-slate-900/60 to-slate-950"></div>

        <div class="relative mx-auto max-w-6xl px-4 text-center">
            <span
                class="inline-block rounded-full bg-amber-500/10 px-5 py-2 text-[10px] font-black uppercase tracking-[0.4em] text-amber-500 ring-1 ring-amber-500/20 mb-8">Official
                Enrollment</span>
            <h1 class="text-5xl font-black tracking-tighter md:text-7xl uppercase italic">The Path to <span
                    class="text-amber-400 not-italic underline decoration-amber-500/30 underline-offset-8">Glory</span></h1>
            <p class="mx-auto mt-8 max-w-2xl text-lg text-slate-400 font-medium">Begin your journey with the East Champaran
                Fencing Association. Elite training starts with a single step.</p>
        </div>
    </section>

    <section class="relative z-20 -mt-12 pb-24">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid gap-12 lg:grid-cols-3">

                <!-- Left Side: Registration Form -->
                <div class="lg:col-span-2">
                    <!-- ENCTYPE ADDED FOR FILE UPLOADS -->
                    <form id="playerRegistrationForm" action="{{ route('register.submit') }}" method="POST" enctype="multipart/form-data"
                        class="bg-white rounded-[2.5rem] shadow-2xl border border-slate-100 p-8 md:p-12 space-y-12">
                        @csrf

                        <!-- Success/Error Feedback -->
                        @if(session('success'))
                            <div class="p-6 bg-emerald-50 border border-emerald-100 text-emerald-700 rounded-3xl font-bold text-sm flex items-center gap-4 animate-pulse">
                                <span class="text-2xl">✅</span> {{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="p-6 bg-red-50 border border-red-100 text-red-700 rounded-3xl font-bold text-sm flex items-center gap-4">
                                <span class="text-2xl">⚠️</span> {{ session('error') }}
                            </div>
                        @endif

                        <!-- Section 1: Personal Information -->
                        <div class="space-y-8">
                            <div class="flex items-center gap-4">
                                <span class="h-10 w-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black">01</span>
                                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Athlete Profile</h2>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Full Legal Name *</label>
                                    <input type="text" name="name" value="{{ old('name') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold"
                                        placeholder="e.g. Rahul Singh">
                                    @error('name') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Date of Birth *</label>
                                    <input type="date" name="dob" value="{{ old('dob') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Gender Identification *</label>
                                    <select name="gender" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-bold text-slate-700 appearance-none cursor-pointer">
                                        <option value="">Select Gender</option>
                                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Electronic Mail *</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold"
                                        placeholder="athlete@example.com">
                                    @error('email') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Direct Contact No. *</label>
                                    <input type="tel" name="phone" value="{{ old('phone') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold"
                                        placeholder="+91 00000 00000">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Create Password *</label>
                                    <input type="password" name="password" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold"
                                        placeholder="Min 6 characters">
                                </div>
                            </div>
                        </div>

                        <!-- Section 2: Address Information -->
                        <div class="space-y-8 pt-8 border-t border-slate-50">
                            <div class="flex items-center gap-4">
                                <span class="h-10 w-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black">02</span>
                                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Location Details</h2>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-3">
                                <div class="sm:col-span-3">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Residential Address *</label>
                                    <textarea name="address" rows="3" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold">{{ old('address') }}</textarea>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">City *</label>
                                    <input type="text" name="city" value="{{ old('city') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">State *</label>
                                    <input type="text" name="state" value="{{ old('state') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold">
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Pincode *</label>
                                    <input type="text" name="pincode" value="{{ old('pincode') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold">
                                </div>
                            </div>
                        </div>

                        <!-- Section 3: Fencing Information -->
                        <div class="space-y-8 pt-8 border-t border-slate-50">
                            <div class="flex items-center gap-4">
                                <span class="h-10 w-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black">03</span>
                                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Arena Specifications</h2>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2">
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Fencing Primary Weapon *</label>
                                    <select name="category" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-bold text-slate-700 appearance-none cursor-pointer">
                                        <option value="">Select Weapon</option>
                                        <option value="Epee" {{ old('category') == 'Epee' ? 'selected' : '' }}>Epee</option>
                                        <option value="Foil" {{ old('category') == 'Foil' ? 'selected' : '' }}>Foil</option>
                                        <option value="Sabre" {{ old('category') == 'Sabre' ? 'selected' : '' }}>Sabre</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Competitive Age Group *</label>
                                    <select name="ageGroup" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-bold text-slate-700 appearance-none cursor-pointer">
                                        <option value="">Select Age Group</option>
                                        <option value="U-14">Under 14</option>
                                        <option value="U-17">Under 17</option>
                                        <option value="U-20">Under 20</option>
                                        <option value="Senior">Senior</option>
                                    </select>
                                </div>

                                <div class="sm:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Athlete Skill Level *</label>
                                    <select name="experience" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-bold text-slate-700 appearance-none cursor-pointer">
                                        <option value="">Select Level</option>
                                        <option value="Beginner">Beginner</option>
                                        <option value="Intermediate">Intermediate</option>
                                        <option value="Advanced">Advanced</option>
                                        <option value="Professional">Professional</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- SECTION 04: SECURITY & DOCUMENTATION (UPDATED) -->
                        <div class="space-y-8 pt-8 border-t border-slate-50">
                            <div class="flex items-center gap-4">
                                <span class="h-10 w-10 rounded-2xl bg-blue-600 text-white flex items-center justify-center font-black">04</span>
                                <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tight">Security & Documentation</h2>
                            </div>

                            <div class="grid gap-6 sm:grid-cols-2">
                                <!-- Aadhar Number (Mandatory) -->
                                <div class="sm:col-span-1">
                                    <label class="flex justify-between items-center mb-2 ml-1">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Aadhar Number *</span>
                                        <span class="text-[8px] bg-red-100 text-red-600 px-2 py-0.5 rounded-md font-bold uppercase">Mandatory</span>
                                    </label>
                                    <input type="text" name="aadhar_no" value="{{ old('aadhar_no') }}" required
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold"
                                        placeholder="12-Digit Unique ID">
                                    @error('aadhar_no') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <!-- Aadhar Photo (Mandatory) -->
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Aadhar Card Copy *</label>
                                    <div class="relative group">
                                        <input type="file" name="aadhar_photo" required
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 group-hover:border-blue-400 transition">
                                            <span class="text-xl">🪪</span>
                                            <span class="text-xs font-bold text-slate-500 group-hover:text-blue-600">Upload Front/Back JPG/PNG</span>
                                        </div>
                                    </div>
                                    @error('aadhar_photo') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <!-- DOB Certificate (Mandatory) -->
                                <div>
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">DOB Certificate *</label>
                                    <div class="relative group">
                                        <input type="file" name="dob_photo" required
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 group-hover:border-blue-400 transition">
                                            <span class="text-xl">📅</span>
                                            <span class="text-xs font-bold text-slate-500 group-hover:text-blue-600">Birth Certificate Image</span>
                                        </div>
                                    </div>
                                    @error('dob_photo') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>

                                <!-- Passport ID (Optional) -->
                                <div>
                                    <label class="flex justify-between items-center mb-2 ml-1">
                                        <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Passport ID</span>
                                        <span class="text-[8px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-md font-bold uppercase tracking-widest">Global / Optional</span>
                                    </label>
                                    <input type="text" name="passport_no" value="{{ old('passport_no') }}"
                                        class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 outline-none transition font-semibold"
                                        placeholder="International Travel ID">
                                </div>

                                <!-- Passport Photo (Optional) -->
                                <div class="sm:col-span-2">
                                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Passport Scan (Optional)</label>
                                    <div class="relative group">
                                        <input type="file" name="passport_photo"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                        <div class="w-full bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl px-5 py-4 flex items-center gap-3 group-hover:border-blue-400 transition">
                                            <span class="text-xl">🛂</span>
                                            <span class="text-xs font-bold text-slate-500 group-hover:text-blue-600">Upload passport main page (if available)</span>
                                        </div>
                                    </div>
                                    @error('passport_photo') <p class="text-red-500 text-[10px] mt-1 font-bold">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Final Submission & Terms -->
                        <div class="space-y-8 pt-8 border-t border-slate-50">
                            <div class="space-y-4">
                                <label class="flex items-start gap-4 cursor-pointer group">
                                    <input type="checkbox" name="agree" required
                                        class="mt-1 rounded-lg border-slate-300 text-blue-600 focus:ring-blue-500 h-5 w-5">
                                    <span class="text-[11px] font-bold text-slate-500 leading-relaxed group-hover:text-slate-900 transition">
                                        I verify that the uploaded Aadhar and DOB documents are authentic. I agree to the ECFA verification process and understand that false information will lead to immediate disqualification. *
                                    </span>
                                </label>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-4 pt-4">
                                <button type="submit"
                                    class="flex-1 bg-blue-600 hover:bg-slate-900 text-white py-5 rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition shadow-xl shadow-blue-600/20 transform hover:-translate-y-1">
                                    Deploy Registration
                                </button>
                                <button type="reset"
                                    class="px-10 py-5 bg-slate-50 hover:bg-slate-100 text-slate-400 rounded-2xl font-black text-xs uppercase tracking-[0.3em] transition">
                                    Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Right Side: Sidebar Info -->
                <aside class="space-y-8">
                    <!-- Documentation Checklist Card -->
                    <div class="bg-slate-900 rounded-[2.5rem] p-10 shadow-xl text-white relative overflow-hidden">
                         <div class="absolute top-0 right-0 p-4 opacity-10">
                            <span class="text-6xl font-black italic">!</span>
                         </div>
                         <h3 class="text-xl font-black uppercase tracking-tighter mb-6 text-amber-400 italic">Verify Checklist</h3>
                         <ul class="space-y-4">
                             <li class="flex items-center gap-3">
                                 <span class="text-emerald-400">✔</span>
                                 <p class="text-[10px] font-bold uppercase tracking-widest">Aadhar Front & Back</p>
                             </li>
                             <li class="flex items-center gap-3">
                                 <span class="text-emerald-400">✔</span>
                                 <p class="text-[10px] font-bold uppercase tracking-widest">Birth Certificate Copy</p>
                             </li>
                             <li class="flex items-center gap-3">
                                 <span class="text-slate-500">○</span>
                                 <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Passport (If Travel Ready)</p>
                             </li>
                         </ul>
                    </div>

                    <!-- Process Flow -->
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-xl border border-slate-100 relative overflow-hidden group">
                        <div class="relative z-10">
                            <h3 class="text-xl font-black text-slate-900 uppercase tracking-tighter mb-6">Enrollment Flow</h3>
                            <ul class="space-y-6">
                                <li class="flex gap-4">
                                    <span class="text-blue-600 font-black">01</span>
                                    <p class="text-xs font-bold text-slate-500 leading-relaxed uppercase tracking-wider">Document submission.</p>
                                </li>
                                <li class="flex gap-4">
                                    <span class="text-blue-600 font-black">02</span>
                                    <p class="text-xs font-bold text-slate-500 leading-relaxed uppercase tracking-wider">Background verification.</p>
                                </li>
                                <li class="flex gap-4">
                                    <span class="text-blue-600 font-black">03</span>
                                    <p class="text-xs font-bold text-slate-500 leading-relaxed uppercase tracking-wider">Credential issuance.</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>
@endsection
