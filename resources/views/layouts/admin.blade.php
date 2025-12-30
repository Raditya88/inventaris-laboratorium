<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel Inventaris</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f8fafc; }
        .sidebar-link:hover { background-color: rgba(255, 255, 255, 0.1); transition: 0.3s; }
        .active-link { background-color: #3b82f6; color: white !important; border-radius: 8px; }
    </style>
</head>
<body class="text-gray-800">

    <div class="flex min-h-screen">

        <aside class="w-64 bg-slate-900 text-slate-300 flex-shrink-0 flex flex-col shadow-xl">
            <div class="p-6">
                <h1 class="text-white text-xl font-bold flex items-center gap-3">
                    <span class="bg-blue-600 p-2 rounded-lg text-white">
                        <i class="fas fa-boxes-stacked"></i>
                    </span>
                    INV-APP
                </h1>
            </div>

            <nav class="flex-1 px-4 mt-4">
                <p class="text-xs font-semibold uppercase text-slate-500 mb-4 px-2">Utama</p>

                <a href="/admin/inventaris" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-lg mb-1 transition-all">
                    <i class="fas fa-box w-5"></i>
                    <span>Inventaris</span>
                </a>

                <a href="/admin/peminjaman"
                class="sidebar-link flex items-center justify-between py-3 px-4 rounded-lg mb-1 transition-all">

                    <div class="flex items-center gap-3">
                        <i class="fas fa-file-signature w-5"></i>
                        <span>Peminjaman</span>
                    </div>

                    @if(isset($pendingCount) && $pendingCount > 0)
                        <span class="bg-rose-600 text-white text-xs font-semibold px-2 py-1 rounded-full">
                            {{ $pendingCount }}
                        </span>
                    @endif
                </a>

                <a href="/admin/laporan" class="sidebar-link flex items-center gap-3 py-3 px-4 rounded-lg mb-1 transition-all">
                    <i class="fas fa-chart-line w-5"></i>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white py-2 px-4 rounded-lg flex items-center justify-center gap-2 transition-all font-medium">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </aside>

        <main class="flex-1 flex flex-col h-screen overflow-hidden">

            <header class="bg-white border-b border-gray-200 h-16 flex items-center justify-between px-8">
                <div>
                    <h2 class="text-lg font-semibold text-gray-700">Dashboard Inventaris</h2>
                </div>

                <div class="flex items-center gap-4">
                    <button class="text-gray-500 hover:text-blue-600"><i class="fas fa-bell"></i></button>
                    <div class="h-8 w-8 bg-gray-200 rounded-full flex items-center justify-center border border-gray-300">
                        <i class="fas fa-user text-gray-500"></i>
                    </div>
                </div>
            </header>

            <div class="p-8 overflow-y-auto bg-slate-50">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 min-h-[80vh]">
                    @yield('content')
                </div>
            </div>

        </main>
    </div>

</body>
</html>
