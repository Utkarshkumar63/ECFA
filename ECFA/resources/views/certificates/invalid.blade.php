<!-- resources/views/certificates/verify_fail.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Failed | ECFA</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@700;900&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #020617;
            font-family: 'Montserrat', sans-serif;
            background-image: radial-gradient(circle at center, #0f172a 0%, #020617 100%);
        }
        .font-cinzel { font-family: 'Cinzel', serif; }

        .error-card {
            border-top: 4px solid #ef4444;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
        }

        .shake {
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 text-white">

    <div class="max-w-md w-full text-center">
        <!-- Logo -->
        <img src="{{ asset('images/logo.jpeg') }}" class="h-20 mx-auto mb-8 rounded-lg grayscale opacity-50 border border-white/10 p-1">

        <!-- Error Card -->
        <div class="error-card p-10 rounded-2xl border border-white/10 shadow-2xl shake">
            <!-- Warning Icon -->
            <div class="w-20 h-20 bg-red-500/10 border border-red-500/50 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>

            <h1 class="font-cinzel text-2xl font-black tracking-widest text-red-500 mb-4 uppercase">
                Verification Failed
            </h1>

            <p class="text-slate-400 text-sm leading-relaxed mb-8">
                The certificate record you are looking for is <span class="text-white font-bold italic underline decoration-red-500">invalid</span>, expired, or may have been tampered with. It does not exist in the East Champaran Fencing Association official registry.
            </p>

            <!-- Action Buttons -->
            <div class="space-y-3">
                <a href="/" class="block w-full bg-white/5 hover:bg-white/10 text-white font-bold py-3 px-6 rounded-lg border border-white/10 transition-all text-xs uppercase tracking-[0.2em]">
                    Return to Website
                </a>
                <a href="mailto:support@ecfencing.com" class="block w-full text-[#c5a059] font-bold py-2 text-[10px] uppercase tracking-widest hover:underline">
                    Report Fraudulent Document
                </a>
            </div>
        </div>

        <!-- Footer Meta -->
        <div class="mt-8">
            <p class="text-[9px] text-slate-500 uppercase tracking-[0.3em]">
                Secure Verification System &bull; ECFA
            </p>
            <p class="text-[8px] text-slate-600 mt-2 italic">
                IP Address Recorded: {{ request()->ip() }}
            </p>
        </div>
    </div>

</body>
</html>
