<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Admin Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-slate-100 flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-600 text-white rounded-2xl shadow-xl shadow-blue-200 mb-4">
                <i class="fas fa-boxes-stacked text-2xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-slate-500 mt-2 text-sm">Silakan masuk untuk mengelola inventaris</p>
        </div>

        <div class="glass-effect p-8 rounded-3xl shadow-xl shadow-slate-200/60 border border-white">

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 text-rose-700 text-sm flex items-center gap-3 rounded-r-lg">
                    <i class="fas fa-circle-exclamation text-lg"></i>
                    <p class="italic font-medium">{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2 ml-1">Username</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-user text-sm"></i>
                        </div>
                        <input
                            type="text"
                            name="username"
                            required
                            placeholder="Masukkan username"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm text-slate-700"
                        >
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input
                            type="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-sm text-slate-700"
                        >
                    </div>
                </div>

                <div class="flex items-center justify-between mt-2">
                    <label class="flex items-center text-xs text-slate-500 cursor-pointer">
                        <input type="checkbox" class="mr-2 rounded border-slate-300 text-blue-600 focus:ring-blue-500"> Ingat saya
                    </label>
                    <a href="#" class="text-xs text-blue-600 hover:underline font-medium">Lupa Password?</a>
                </div>

                <button
                    type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3.5 rounded-xl shadow-lg shadow-blue-200 hover:shadow-blue-300 transition-all active:scale-[0.98] mt-4"
                >
                    Masuk ke Panel
                </button>
            </form>
        </div>

        <p class="text-center text-slate-400 text-xs mt-10">
            &copy; 2025 INV-APP System. All rights reserved.
        </p>
    </div>

</body>
</html> 
