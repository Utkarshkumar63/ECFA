<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal | ECFA</title>

    <!-- Premium Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .glass { background: rgba(15, 23, 42, 0.8); backdrop-filter: blur(20px); }
    </style>
</head>
<body class="min-h-screen bg-slate-950 flex flex-col justify-center relative overflow-hidden">

    <!-- Ambient Background Decorations -->
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-indigo-600/20 rounded-full blur-[120px]"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-amber-500/10 rounded-full blur-[120px]"></div>

    <!-- Navigation Bar (Minimalist) -->
    <nav class="absolute top-0 w-full p-8 flex justify-between items-center z-10">
        <a href="/" class="flex items-center gap-3 group">
            <div class="bg-white p-2 rounded-xl group-hover:rotate-6 transition">
                <img src="{{ asset('images/logo.jpeg') }}" class="h-8 w-auto">
            </div>
            <span class="text-white font-black uppercase tracking-widest text-sm">ECFA Portal</span>
        </a>
        <a href="/" class="text-slate-400 hover:text-white text-xs font-bold uppercase tracking-widest transition">
            ← Exit to site
        </a>
    </nav>

    <main class="relative z-10 w-full max-w-md mx-auto px-6">
        <div class="glass border border-white/10 rounded-[2.5rem] p-10 shadow-2xl overflow-hidden relative">

            <!-- Icon/Branding -->
            <div class="mb-10 text-center">
                <div class="inline-flex h-16 w-16 items-center justify-center rounded-2xl bg-indigo-600 text-white text-3xl shadow-lg shadow-indigo-600/30 mb-6">
                    🛡️
                </div>
                <h1 class="text-3xl font-black text-white tracking-tighter">Admin <span class="text-indigo-400">Login</span></h1>
                <p class="text-slate-400 text-sm mt-2">East Champaran Fencing Association</p>
            </div>

            <!-- Error Handling -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-500/10 border border-red-500/20 text-red-400 rounded-2xl text-xs font-bold">
                    ⚠️ {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Email Identifier</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:ring-4 focus:ring-indigo-600/20 focus:border-indigo-500 outline-none transition font-semibold"
                           placeholder="admin@ecfa.org">
                </div>

                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-2 ml-1">Access Token</label>
                    <input type="password" name="password" required
                           class="w-full bg-slate-900/50 border border-white/10 rounded-2xl px-5 py-4 text-white focus:ring-4 focus:ring-indigo-600/20 focus:border-indigo-500 outline-none transition font-semibold"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="checkbox" name="remember" class="rounded border-white/10 bg-slate-900 text-indigo-600 focus:ring-offset-slate-950">
                        <span class="text-[11px] font-bold text-slate-500 group-hover:text-slate-300 transition">Keep me signed in</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white py-5 rounded-2xl font-black text-sm transition shadow-xl shadow-indigo-600/30 uppercase tracking-[0.2em]">
                    Establish Session
                </button>
            </form>

            <!-- Status Footer -->
            <div class="mt-10 pt-8 border-t border-white/5 flex items-center justify-center gap-2">
                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                <span class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Encrypted Portal Access</span>
            </div>
        </div>

        <p class="mt-8 text-center text-[10px] font-bold text-slate-600 uppercase tracking-[0.3em]">
            &copy; {{ date('Y') }} ECFA Regional Authority
        </p>
    </main>
</body>
</html>
