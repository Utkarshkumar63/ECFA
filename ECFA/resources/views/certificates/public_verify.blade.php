<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Certificate | ECFA Official Registry</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <!-- QR Scanner Library -->
    <script src="https://unpkg.com/html5-qrcode"></script>

    <style>
        body { font-family: 'Montserrat', sans-serif; background-color: #f8fafc; }
        .font-cinzel { font-family: 'Cinzel', serif; }
        .gold-border { border-top: 5px solid #c5a059; }
        .btn-premium { background: #0f172a; color: white; transition: all 0.3s; }
        .btn-premium:hover { background: #1e293b; transform: translateY(-2px); }

        /* Custom QR Scanner Styling */
        #reader { border: none !important; border-radius: 2rem; overflow: hidden; background: #f1f5f9; }
        #reader__dashboard_section_csr button {
            background: #0f172a !important; color: white !important;
            padding: 12px 24px !important; border-radius: 12px !important;
            font-size: 11px !important; font-weight: 800 !important;
            text-transform: uppercase !important; border: none !important;
            letter-spacing: 1px; margin-top: 15px;
        }
        video { border-radius: 1.5rem; }
    </style>
</head>
<body class="min-h-screen py-12 px-4 bg-[radial-gradient(#e2e8f0_1px,transparent_1px)] [background-size:20px_20px]">

    <div class="max-w-2xl mx-auto">
        <!-- Official Header -->
        <div class="text-center mb-10">
            <div class="inline-block p-4 bg-white shadow-xl rounded-[2rem] mb-6 border border-slate-50">
                <img src="{{ asset('images/logo.jpeg') }}" class="h-20 w-20 rounded-2xl object-cover">
            </div>
            <h1 class="font-cinzel text-3xl text-slate-900 font-black tracking-widest leading-none">ECFA REGISTRY</h1>
            <p class="text-slate-400 text-[10px] font-bold uppercase tracking-[0.4em] mt-3">Public Authenticity Verification Portal</p>
        </div>

        <!-- Main Interaction Card -->
        <div class="bg-white rounded-[3rem] shadow-2xl shadow-slate-200/50 border border-slate-100 overflow-hidden">

            <!-- Tab Navigation -->
            <div class="flex bg-slate-50/50 p-2 m-4 rounded-[2rem] border border-slate-100">
                <button onclick="switchTab('manual')" id="tab-manual" class="flex-1 py-4 text-[10px] font-black uppercase tracking-widest rounded-[1.5rem] bg-white shadow-sm text-indigo-600 transition-all">
                    Manual ID Search
                </button>
                <button onclick="switchTab('scan')" id="tab-scan" class="flex-1 py-4 text-[10px] font-black uppercase tracking-widest rounded-[1.5rem] text-slate-400 hover:text-slate-600 transition-all">
                    Live QR Scanner
                </button>
            </div>

            <div class="p-8 md:p-12 pt-4">
                <!-- Manual Search -->
                <div id="section-manual" class="block animate-in fade-in duration-500">
                    <form action="{{ route('public.verify.check') }}" method="POST">
                        @csrf
                        <div class="space-y-5">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-3 ml-2">Unique Certificate ID</label>
                                <input type="text" name="cert_id" required value="{{ old('cert_id', isset($cert) ? $cert->cert_id : '') }}"
                                    placeholder="ECFA-2026-XXXXXXXX"
                                    class="w-full bg-slate-50 border-2 border-transparent focus:border-indigo-600 focus:bg-white rounded-3xl px-8 py-5 text-slate-900 font-black tracking-widest outline-none transition-all uppercase placeholder:text-slate-300">
                            </div>
                            <button type="submit" class="w-full btn-premium py-5 rounded-3xl font-black text-xs uppercase tracking-[0.3em] shadow-xl shadow-slate-200">
                                Verify Now
                            </button>
                        </div>
                    </form>
                </div>

                <!-- QR Scanner -->
                <div id="section-scan" class="hidden text-center animate-in zoom-in-95 duration-500">
                    <div class="relative group">
                        <div id="reader" class="w-full aspect-square md:aspect-video"></div>
                        <!-- Scanner Overlay UI -->
                        <div id="scanner-ui" class="hidden absolute inset-0 pointer-events-none flex flex-col items-center justify-center">
                            <div class="w-48 h-48 border-2 border-indigo-500 rounded-3xl animate-pulse relative">
                                <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-8 bg-indigo-600 text-white text-[8px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Scanning...</div>
                            </div>
                        </div>
                    </div>
                    <p class="mt-6 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Center the QR Code within the frame to detect</p>
                </div>

                @if(session('error'))
                <div class="mt-8 p-6 bg-rose-50 border border-rose-100 rounded-3xl flex items-center gap-4 animate-in slide-in-from-top-2">
                    <div class="bg-rose-500 text-white p-2 rounded-xl shadow-lg shadow-rose-200">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/></svg>
                    </div>
                    <div>
                        <p class="text-[11px] font-black text-rose-600 uppercase tracking-widest">Verification Failed</p>
                        <p class="text-[10px] text-rose-400 font-bold uppercase mt-0.5">{{ session('error') }}</p>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Result Card (Clean White Certificate Style) -->
        @if(isset($cert))
        <div class="mt-10 animate-in fade-in slide-in-from-bottom-10 duration-700">
            <div class="bg-white rounded-[3rem] shadow-2xl border border-slate-100 p-10 gold-border relative">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 bg-emerald-500 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-100">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-black text-slate-900 uppercase italic tracking-tighter leading-none">Record Found</h2>
                            <p class="text-emerald-500 text-[10px] font-black uppercase tracking-widest mt-1">Verified Authentic</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest">Status Code</p>
                        <p class="text-xs font-mono font-bold text-slate-600">{{ $cert->cert_id }}</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Full Name of Athlete</label>
                        <p class="font-cinzel text-2xl text-slate-900 font-black">{{ $cert->user->name }}</p>
                    </div>
                    <div class="space-y-1">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Official Award Rank</label>
                        <p class="text-lg font-bold text-indigo-600 uppercase italic">{{ $cert->medal_type ?? 'Certified Player' }}</p>
                    </div>
                    <div class="space-y-1 md:col-span-2">
                        <label class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Tournament & Venue</label>
                        <div class="bg-slate-50 p-5 rounded-2xl border border-slate-100">
                            <p class="text-sm font-black text-slate-800 uppercase italic">{{ $cert->event_name }}</p>
                            <p class="text-xs font-bold text-slate-500 mt-1">{{ $cert->location ?? 'East Champaran Region' }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-12 flex flex-col sm:flex-row items-center justify-between gap-6 pt-10 border-t border-slate-50">
                    <p class="text-[10px] font-bold text-slate-400 uppercase">Issued: {{ \Carbon\Carbon::parse($cert->issue_date)->format('d F, Y') }}</p>
                    <a href="{{ route('cert.verify', ['cert_id' => $cert->cert_id, 'hash' => $cert->verification_hash]) }}"
                       class="bg-indigo-600 text-white px-8 py-4 rounded-2xl font-black text-[10px] uppercase tracking-widest hover:bg-indigo-700 shadow-xl shadow-indigo-100 transition-all flex items-center gap-2">
                        View Honors
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <!-- Footer -->
        <div class="mt-20 text-center">
            <p class="text-slate-300 text-[9px] font-black uppercase tracking-[0.4em]">&copy; {{ date('Y') }} ECFA Regional Authority</p>
        </div>
    </div>

    <script>
        function switchTab(type) {
            const manualBtn = document.getElementById('tab-manual');
            const scanBtn = document.getElementById('tab-scan');
            const manualSection = document.getElementById('section-manual');
            const scanSection = document.getElementById('section-scan');

            if (type === 'scan') {
                manualBtn.classList.remove('bg-white', 'shadow-sm', 'text-indigo-600');
                manualBtn.classList.add('text-slate-400');
                scanBtn.classList.add('bg-white', 'shadow-sm', 'text-indigo-600');
                scanSection.classList.remove('hidden');
                manualSection.classList.add('hidden');
                startScanner();
            } else {
                scanBtn.classList.remove('bg-white', 'shadow-sm', 'text-indigo-600');
                scanBtn.classList.add('text-slate-400');
                manualBtn.classList.add('bg-white', 'shadow-sm', 'text-indigo-600');
                manualSection.classList.remove('hidden');
                scanSection.classList.add('hidden');
                if(html5QrCode) html5QrCode.stop();
            }
        }

        let html5QrCode;
        function startScanner() {
            document.getElementById('scanner-ui').classList.remove('hidden');
            html5QrCode = new Html5QrcodeScanner("reader", { fps: 15, qrbox: {width: 250, height: 250} });
            html5QrCode.render(onScanSuccess);
        }

        function onScanSuccess(decodedText, decodedResult) {
            if (decodedText.includes('http')) {
                window.location.href = decodedText;
            } else {
                switchTab('manual');
                document.getElementsByName('cert_id')[0].value = decodedText;
            }
        }
    </script>
</body>
</html>
