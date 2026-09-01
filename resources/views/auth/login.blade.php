<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — {{ \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: {
                fontFamily: { display: ['Plus Jakarta Sans', 'sans-serif'], body: ['Inter', 'sans-serif'] },
                colors: { skblue: {
                    50:'#EFF6FF',100:'#DBEAFE',200:'#BFDBFE',300:'#93C5FD',400:'#60A5FA',
                    500:'#3B82F6',600:'#2563EB',700:'#1D4ED8',800:'#1E40AF',900:'#1E3A8A'
                }}
            }}
        }
    </script>
</head>
<body class="font-body bg-gradient-to-br from-skblue-50 via-white to-skblue-100 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md">

        {{-- Logo & judul --}}
        <div class="text-center mb-8">
            <div class="w-16 h-16 mx-auto mb-4">
                @php $logoPath = 'images/logo-smkn1sbl2.png'; @endphp
                @if(file_exists(public_path($logoPath)))
                    <img src="{{ asset($logoPath) }}" alt="Logo" class="w-full h-full object-contain drop-shadow">
                @else
                    <div class="w-full h-full rounded-2xl bg-gradient-to-br from-skblue-500 to-skblue-700 flex items-center justify-center text-white font-display font-bold text-xl shadow-lg">
                        S1
                    </div>
                @endif
            </div>
            <h1 class="font-display font-extrabold text-skblue-900 text-xl">
                {{ \App\Models\CMS\Setting::get('school_name', 'SMK Negeri 1 Sebulu') }}
            </h1>
            <p class="text-sm text-skblue-500 mt-1">Portal Administrasi</p>
        </div>

        {{-- Kartu form login --}}
        <div class="bg-white rounded-3xl shadow-2xl shadow-skblue-900/10 border border-skblue-100 p-8">
            <h2 class="font-display font-bold text-xl text-slate-800 mb-1">Masuk ke Panel Admin</h2>
            <p class="text-sm text-slate-500 mb-6">Khusus untuk staff dan pengelola sistem sekolah.</p>

            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('status'))
                <div class="mb-5 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:border-skblue-400 focus:outline-none transition"
                           placeholder="admin@smkn1sebulu.sch.id">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1.5">Password</label>
                    <input type="password" name="password" required
                           class="w-full rounded-xl border border-skblue-200 px-4 py-2.5 text-sm focus:ring-2 focus:ring-skblue-400 focus:border-skblue-400 focus:outline-none transition"
                           placeholder="••••••••">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-skblue-300 text-skblue-600 focus:ring-skblue-400">
                        Ingat saya
                    </label>
                </div>

                <button type="submit"
                        class="w-full rounded-xl bg-skblue-600 hover:bg-skblue-700 hover:-translate-y-0.5 hover:shadow-lg text-white font-bold py-3 shadow-md transition-all duration-200">
                    Masuk
                </button>
            </form>
        </div>

        <p class="text-center text-xs text-slate-400 mt-6">
            &larr; <a href="{{ route('home') }}" class="hover:text-skblue-600 transition">Kembali ke Beranda</a>
        </p>
    </div>

</body>
</html>