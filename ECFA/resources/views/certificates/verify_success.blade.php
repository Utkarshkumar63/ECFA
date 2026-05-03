<!-- resources/views/certificates/design.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Excellence - {{ $cert->user->name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Playfair+Display:ital,wght@0,400;0,700;1,900&family=Montserrat:wght@300;600&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0f172a; font-family: 'Montserrat', sans-serif; }
        .font-cinzel { font-family: 'Cinzel', serif; }
        .font-playfair { font-family: 'Playfair Display', serif; }

        /* Landscape Aspect Ratio for Certificate */
        .certificate-container {
            width: 1100px;
            height: 780px;
            background: white;
            position: relative;
            box-shadow: 0 50px 100px -20px rgba(0,0,0,0.6);
            border: 25px solid #0a192f;
            margin: auto;
        }

        /* Gold Gradient Border */
        .gold-border {
            border: 4px solid #c5a059;
            height: calc(100% - 20px);
            width: calc(100% - 20px);
            margin: 10px;
            position: relative;
            background-color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px;
        }

        .verified-seal {
            background: linear-gradient(135deg, #c5a059 0%, #f1d392 50%, #c5a059 100%);
            box-shadow: 0 10px 20px rgba(197, 160, 89, 0.4);
        }

        .fencing-bg {
            position: absolute;
            right: -30px;
            bottom: 20px;
            height: 75%;
            opacity: 0.12;
            filter: grayscale(1);
            pointer-events: none;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 450px;
            opacity: 0.04;
            pointer-events: none;
        }

        @media print {
            body { background: white !important; padding: 0; margin: 0; }
            .certificate-container { box-shadow: none !important; border-width: 15px !important; margin: 0; }
            .no-print { display: none !important; }
            .cert-body { -webkit-print-color-adjust: exact; }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center p-6 cert-body">

    <!-- Certificate Wrapper -->
    <div class="certificate-container rounded-sm overflow-hidden relative">

        <div class="gold-border text-center">

            <!-- Watermark Logo -->
            <img src="{{ asset('images/logo.jpeg') }}" class="watermark">

            <!-- Fencing Decorative Icon -->
            <img src="{{ asset('images/calo.png') }}" class="fencing-bg" alt="Fencing Icon">

            <!-- Header Section -->
            <div class="w-full flex justify-between items-start mb-6 z-10">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/logo.jpeg') }}" class="h-20 w-20 rounded shadow-sm border border-[#c5a059] p-1">
                    <div class="text-left">
                        <h2 class="font-cinzel text-lg font-black text-[#0a192f] leading-none uppercase">East Champaran</h2>
                        <h2 class="font-cinzel text-lg font-black text-[#0a192f] mb-1 uppercase">Fencing Association</h2>
                        <p class="text-[10px] text-[#c5a059] font-bold uppercase tracking-[0.2em]">Affiliated with Bihar Fencing Association</p>
                    </div>
                </div>

                <div class="text-right">
                    <p class="font-cinzel text-[10px] font-black text-[#0a192f] tracking-widest uppercase">Bihar Unit</p>
                    <p class="font-cinzel text-[8px] font-bold text-slate-400 uppercase tracking-widest">Official Award Certificate</p>
                </div>
            </div>

            <!-- Title Section -->
            <div class="mt-4 z-10">
                <h3 class="font-cinzel text-[#c5a059] text-sm font-bold uppercase tracking-[0.5em] mb-3">Certificate of Excellence</h3>
                <div class="h-[2px] w-32 bg-[#c5a059]/30 mx-auto mb-6"></div>
                <p class="font-playfair italic text-slate-500 text-xl">This prestigious award is proudly presented to</p>

                <h1 class="font-playfair text-6xl font-black text-[#0a192f] uppercase italic my-6 px-12 border-b-2 border-slate-100 inline-block">
                    {{ $cert->user->name }}
                </h1>
            </div>

            <!-- Achievement Text -->
            <div class="max-w-3xl z-10 mt-2">
                <p class="text-slate-700 text-xl leading-relaxed font-medium">
                    for demonstrating exceptional skill, determination, and sportsmanship in the <br>
                    <span class="font-cinzel font-black text-2xl text-[#0a192f] block mt-2 tracking-tight underline decoration-[#c5a059]/40 uppercase">
                        "{{ $cert->event_name }}"
                    </span>
                </p>
                <p class="mt-6 text-slate-500 text-sm italic max-w-2xl mx-auto font-playfair">
                    Through discipline, agility, and strategic mastery, the athlete has upheld the true spirit of fencing and set a high standard of excellence for the association.
                </p>
            </div>

            <!-- Footer Details -->
            <div class="mt-auto w-full flex justify-between items-end px-4 z-10">

                <!-- Signature 1 -->
                <div class="flex gap-12 mb-2">
                    <div class="text-center w-40">
                        <div class="h-12"></div> <!-- Placeholder for sign -->
                        <div class="border-t-2 border-slate-300 pt-2">
                            <p class="text-[9px] font-black text-[#0a192f] uppercase tracking-wider">Secretary General</p>
                            <p class="text-[7px] text-slate-400 font-bold uppercase tracking-widest">ECFA </p>
                        </div>
                    </div>
                </div>

                <!-- QR Verification & ID -->
                <div class="flex flex-col items-center gap-2">
                    <div class="verified-seal p-1.5 rounded-2xl shadow-xl">
                        <div class="bg-white p-1 rounded-xl">
                            @php
                                $verifyUrl = route('cert.verify', ['cert_id' => $cert->cert_id, 'hash' => $cert->verification_hash]);
                            @endphp
                            <img src="https://api.qrserver.com/v1/create-qr-code/?size=120x120&data={{ urlencode($verifyUrl) }}" class="w-20 h-20">
                        </div>
                    </div>
                    <div class="bg-[#0a192f] px-4 py-0.5 rounded-full">
                        <span class="text-white text-[9px] font-black tracking-widest uppercase">ID: {{ $cert->cert_id }}</span>
                    </div>
                </div>

                <!-- Signature 2 -->
                <div class="flex gap-12 mb-2">
                    <div class="text-center w-40">
                        <div class="h-12"></div> <!-- Placeholder for sign -->
                        <div class="border-t-2 border-slate-300 pt-2">
                            <p class="text-[9px] font-black text-[#0a192f] uppercase tracking-wider">Organizing Director</p>
                            <p class="text-[7px] text-slate-400 font-bold uppercase tracking-widest">Technical Committee</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Corner Accents -->
            <div class="absolute top-0 left-0 w-16 h-16 border-t-8 border-l-8 border-[#c5a059]"></div>
            <div class="absolute bottom-0 right-0 w-16 h-16 border-b-8 border-r-8 border-[#c5a059]"></div>

            <!-- Issued Date Text -->
            <p class="absolute bottom-4 left-1/2 -translate-x-1/2 text-[9px] text-slate-400 font-bold uppercase tracking-[0.3em] z-10">
                Issued on {{ \Carbon\Carbon::parse($cert->issue_date)->format('d F, Y') }}
            </p>
        </div>
    </div>

    <!-- Action Buttons (Hidden on Print) -->
    <div class="flex gap-4 mt-10 no-print">
        <button onclick="window.print()" class="bg-[#c5a059] hover:bg-[#a38446] text-white px-8 py-3 rounded-full font-bold text-sm uppercase tracking-widest transition-all shadow-lg">
            Download / Print PDF
        </button>
        <a href="/dashboard" class="bg-white/10 hover:bg-white/20 text-white px-8 py-3 rounded-full font-bold text-sm uppercase tracking-widest transition-all border border-white/20">
            Back to Dashboard
        </a>
    </div>

</body>
</html>
