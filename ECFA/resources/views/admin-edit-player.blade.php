@extends('layouts.app')

@section('title', 'Edit Athlete | ECFA Admin')

@section('content')
<div class="min-h-screen bg-[#f1f5f9] pt-24 pb-20">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <nav class="flex mb-2 text-xs font-bold uppercase tracking-widest text-slate-400">
                    <a href="{{ route('admin.players') }}" class="hover:text-blue-600 transition">Registry</a>
                    <span class="mx-2">/</span>
                    <span class="text-slate-900">Edit Athlete</span>
                </nav>
                <h1 class="text-4xl font-black text-slate-900 leading-none uppercase italic">
                    Athlete <span class="text-blue-600">Profile</span>
                </h1>
                <p class="text-slate-500 mt-1 font-medium">Updating records for: <span class="text-slate-800 font-bold">{{ $player->name }}</span></p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.players') }}" class="px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-50 transition shadow-sm">
                    Cancel
                </a>
            </div>
        </div>

        <!-- Global Error Alert -->
        @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-2xl shadow-sm">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-bold text-red-800 uppercase tracking-tight">Required fields are missing or invalid</p>
                </div>
            </div>
        </div>
        @endif

        <form action="{{ route('admin.player.update', $player->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- CRITICAL FOR UPDATING -->

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- LEFT COLUMN: Main Info -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- SECTION 1: IDENTITY -->
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-200/60 relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-8 opacity-5">
                            <svg class="w-24 h-24 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>

                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-blue-600 mb-8 flex items-center gap-3">
                            <span class="h-6 w-1 bg-blue-600 rounded-full"></span>
                            Personal Identification
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                            <div class="md:col-span-2">
                                <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">Full Legal Name</label>
                                <input type="text" name="name" value="{{ old('name', $player->name) }}"
                                    class="w-full bg-slate-50 border-2 @error('name') border-red-200 @else border-slate-100 @enderror rounded-2xl px-5 py-3.5 font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none transition-all shadow-sm">
                                @error('name') <p class="text-red-500 text-[10px] mt-1 font-bold uppercase ml-1">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">Email Address</label>
                                <input type="email" name="email" value="{{ old('email', $player->email) }}"
                                    class="w-full bg-slate-50 border-2 @error('email') border-red-200 @else border-slate-100 @enderror rounded-2xl px-5 py-3.5 font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none transition-all shadow-sm">
                            </div>

                            <div>
                                <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">Phone Number</label>
                                <input type="text" name="phone" value="{{ old('phone', $player->phone) }}"
                                    class="w-full bg-slate-50 border-2 @error('phone') border-red-200 @else border-slate-100 @enderror rounded-2xl px-5 py-3.5 font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none transition-all shadow-sm">
                            </div>

                            <div>
                                <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">Aadhar (12 Digits)</label>
                                <input type="text" name="aadhar_no" value="{{ old('aadhar_no', $player->aadhar_no) }}" maxlength="12"
                                    class="w-full bg-slate-50 border-2 @error('aadhar_no') border-red-200 @else border-slate-100 @enderror rounded-2xl px-5 py-3.5 font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none transition-all shadow-sm">
                            </div>

                            <div>
                                <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">Gender</label>
                                <select name="gender" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none transition-all shadow-sm appearance-none">
                                    <option value="Male" {{ $player->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ $player->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                    <option value="Other" {{ $player->gender == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 2: LOGISTICS -->
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-200/60">
                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-amber-600 mb-8 flex items-center gap-3">
                            <span class="h-6 w-1 bg-amber-600 rounded-full"></span>
                            Contact & Location
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">Street Address</label>
                                <input type="text" name="address" value="{{ old('address', $player->address) }}" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 font-bold text-slate-700 focus:bg-white focus:border-blue-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">City</label>
                                <input type="text" name="city" value="{{ old('city', $player->city) }}" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 font-bold text-slate-700">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">State</label>
                                    <input type="text" name="state" value="{{ old('state', $player->state) }}" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 font-bold text-slate-700">
                                </div>
                                <div>
                                    <label class="text-[11px] font-black uppercase text-slate-400 mb-1.5 ml-1 block">Pincode</label>
                                    <input type="text" name="pincode" value="{{ old('pincode', $player->pincode) }}" class="w-full bg-slate-50 border-2 border-slate-100 rounded-2xl px-5 py-3.5 font-bold text-slate-700">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT COLUMN: Athletic Stats & Docs -->
                <div class="space-y-6">

                    <!-- SECTION 3: FENCING -->
                    <div class="bg-slate-900 rounded-[2.5rem] p-8 shadow-xl shadow-slate-200">
                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-emerald-400 mb-8 flex items-center gap-3">
                            <span class="h-6 w-1 bg-emerald-400 rounded-full"></span>
                            Athletic Registry
                        </h2>
                        <div class="space-y-5">
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-500 mb-1.5 ml-1 block">Primary Weapon</label>
                                <select name="category" class="w-full bg-slate-800 border-2 border-slate-700 rounded-2xl px-5 py-3.5 font-bold text-white focus:border-emerald-500 outline-none transition-all appearance-none">
                                    <option value="FOIL" {{ $player->category == 'FOIL' ? 'selected' : '' }}>FOIL</option>
                                    <option value="EPEE" {{ $player->category == 'EPEE' ? 'selected' : '' }}>EPEE</option>
                                    <option value="SABRE" {{ $player->category == 'SABRE' ? 'selected' : '' }}>SABRE</option>
                                </select>
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-500 mb-1.5 ml-1 block">Date of Birth</label>
                                <input type="date" name="dob" value="{{ old('dob', $player->dob) }}" class="w-full bg-slate-800 border-2 border-slate-700 rounded-2xl px-5 py-3.5 font-bold text-white focus:border-emerald-500 outline-none transition-all">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-500 mb-1.5 ml-1 block">Experience Level</label>
                                <input type="text" name="experience" value="{{ old('experience', $player->experience) }}" class="w-full bg-slate-800 border-2 border-slate-700 rounded-2xl px-5 py-3.5 font-bold text-white focus:border-emerald-500 outline-none transition-all" placeholder="e.g. 3 Years">
                            </div>
                            <div>
                                <label class="text-[10px] font-black uppercase text-slate-500 mb-1.5 ml-1 block">Current Age Group</label>
                                <input type="text" name="age_group" value="{{ old('age_group', $player->age_group) }}" class="w-full bg-slate-800 border-2 border-slate-700 rounded-2xl px-5 py-3.5 font-bold text-white focus:border-emerald-500 outline-none transition-all" placeholder="e.g. U-17">
                            </div>
                        </div>
                    </div>

                    <!-- SECTION 4: DOCUMENTS -->
                    <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-200/60">
                        <h2 class="text-sm font-black uppercase tracking-[0.2em] text-indigo-600 mb-6 flex items-center gap-3">
                            <span class="h-6 w-1 bg-indigo-600 rounded-full"></span>
                            Credentials
                        </h2>
                        <div class="grid grid-cols-1 gap-3">
                            <a href="{{ $player->aadhar_photo }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition border border-slate-100 group">
                                <span class="text-xs font-black uppercase text-slate-600 group-hover:text-indigo-700">Aadhar Card</span>
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            <a href="{{ $player->dob_photo }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition border border-slate-100 group">
                                <span class="text-xs font-black uppercase text-slate-600 group-hover:text-indigo-700">DOB Proof</span>
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @if($player->passport_photo)
                            <a href="{{ $player->passport_photo }}" target="_blank" class="flex items-center justify-between p-4 bg-slate-50 rounded-2xl hover:bg-indigo-50 transition border border-slate-100 group">
                                <span class="text-xs font-black uppercase text-slate-600 group-hover:text-indigo-700">Passport Photo</span>
                                <svg class="w-5 h-5 text-slate-400 group-hover:text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>

                    <!-- UPDATE BUTTON -->
                    <button type="submit" class="w-full group bg-blue-600 hover:bg-blue-700 text-white p-6 rounded-[2rem] font-black uppercase tracking-[0.2em] text-sm transition-all shadow-xl shadow-blue-200 flex items-center justify-center gap-3">
                        Save Changes
                        <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
    /* Premium font rendering */
    body { -webkit-font-smoothing: antialiased; }
    input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1); /* Makes date icon visible on dark background */
        cursor: pointer;
    }
</style>
@endsection
