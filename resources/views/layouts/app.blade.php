<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Grandcitra System')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: { primary: '#4f46e5', secondary: '#10b981', dark: '#0f172a' }
                }
            }
        }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.75); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); }
        .glass-dark { background: rgba(15, 23, 42, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-right: 1px solid rgba(255, 255, 255, 0.1); }
        .fade-in { animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased overflow-hidden flex h-screen">
    
    <!-- Sidebar -->
    <aside class="w-72 glass-dark text-white flex flex-col shadow-2xl z-20 h-full relative overflow-y-auto">
        <div class="p-6 border-b border-white/10 flex items-center">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-tr from-indigo-500 to-purple-500 flex items-center justify-center shadow-lg mr-3">
                <i class="fa-solid fa-gem text-xl"></i>
            </div>
            <div>
                <h2 class="text-xl font-bold tracking-tight">Grandcitra</h2>
                <p class="text-[10px] text-indigo-300 tracking-widest uppercase font-semibold">Sales Info System</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-8 space-y-2">
            <p class="px-4 text-xs font-semibold text-slate-400 uppercase tracking-wider mb-4">Menu Utama</p>
            
            @if(Auth::user()->role == 'admin_pusat')
                <a href="{{ route('dashboard.adminPusat') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.adminPusat') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-6 opacity-80"></i> <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('adminPusat.barang.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('adminPusat.barang.*') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-box-open w-6 opacity-80"></i> <span class="font-medium">Master Barang</span>
                </a>
                <a href="{{ route('adminPusat.permintaan.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('adminPusat.permintaan.*') ? 'bg-gradient-to-r from-indigo-500 to-purple-600 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-truck-fast w-6 opacity-80"></i> <span class="font-medium">Permintaan Cabang</span>
                </a>
            @elseif(Auth::user()->role == 'kepala_cabang')
                <a href="{{ route('dashboard.kepalaCabang') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.kepalaCabang') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-house w-6 opacity-80"></i> <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('kepalaCabang.stok.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('kepalaCabang.stok.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-boxes-stacked w-6 opacity-80"></i> <span class="font-medium">Stok Cabang</span>
                </a>
                <a href="{{ route('kepalaCabang.permintaan.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('kepalaCabang.permintaan.*') ? 'bg-gradient-to-r from-emerald-500 to-teal-600 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-cart-flatbed w-6 opacity-80"></i> <span class="font-medium">Riwayat Permintaan</span>
                </a>
            @elseif(Auth::user()->role == 'kasir')
                <a href="{{ route('dashboard.kasir') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.kasir') ? 'bg-gradient-to-r from-pink-500 to-rose-500 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-desktop w-6 opacity-80"></i> <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('kasir.pos.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('kasir.pos.*') ? 'bg-gradient-to-r from-pink-500 to-rose-500 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-cash-register w-6 opacity-80"></i> <span class="font-medium">Point of Sale</span>
                </a>
                <a href="{{ route('kasir.keep.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('kasir.keep.*') ? 'bg-gradient-to-r from-pink-500 to-rose-500 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-bookmark w-6 opacity-80"></i> <span class="font-medium">Keep Barang</span>
                </a>
            @elseif(Auth::user()->role == 'manager')
                <a href="{{ route('dashboard.manager') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('dashboard.manager') ? 'bg-gradient-to-r from-amber-500 to-orange-500 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line w-6 opacity-80"></i> <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('manager.laporan.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-300 {{ request()->routeIs('manager.laporan.*') ? 'bg-gradient-to-r from-amber-500 to-orange-500 shadow-md text-white' : 'text-slate-300 hover:bg-white/10 hover:text-white' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-6 opacity-80"></i> <span class="font-medium">Laporan Penjualan</span>
                </a>
            @endif
        </nav>

        <div class="p-4 mt-auto">
            <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-slate-200 to-slate-400 flex items-center justify-center text-slate-800 font-bold shadow-inner border-2 border-white/20">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-semibold text-white truncate">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-slate-400 capitalize">{{ str_replace('_', ' ', Auth::user()->role) }}</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center px-4 py-2 rounded-xl bg-red-500/10 hover:bg-red-500 hover:text-white text-red-400 font-medium transition-all duration-300">
                        <i class="fa-solid fa-power-off mr-2"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Abstract Background -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[-10%] right-[-5%] w-[40%] h-[40%] rounded-full bg-blue-300/20 blur-[100px]"></div>
            <div class="absolute bottom-[-10%] left-[-5%] w-[50%] h-[50%] rounded-full bg-purple-300/20 blur-[120px]"></div>
        </div>

        <header class="h-20 glass flex items-center justify-between px-10 z-10 sticky top-0">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('header')</h1>
            </div>
            <div class="flex items-center space-x-5">
                <div class="text-sm font-medium text-slate-500 bg-white/50 px-4 py-2 rounded-full border border-slate-200 shadow-sm">
                    <i class="fa-regular fa-calendar mr-2"></i> {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10 z-0 relative fade-in">
            @if(session('success'))
                <div class="mb-8 p-4 rounded-xl bg-white border-l-4 border-emerald-500 flex items-center shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 mr-4">
                        <i class="fa-solid fa-check"></i>
                    </div>
                    <p class="text-slate-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif
            
            @if($errors->any())
                <div class="mb-8 p-4 rounded-xl bg-white border-l-4 border-red-500 flex items-start shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600 mr-4 shrink-0 mt-0.5">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                    </div>
                    <ul class="text-slate-700 font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @stack('scripts')
</body>
</html>
