<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Grandcitra System')</title>
    <link rel="icon" href="{{ asset('images/logo_GCM.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { gcm: '#FFE500', dark: '#0f172a' }
                }
            }
        }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); border-bottom: 1px solid rgba(255, 255, 255, 0.5); }
        .glass-dark { background: rgba(15, 23, 42, 0.98); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border-right: 1px solid rgba(255, 255, 255, 0.05); }
        .fade-in { animation: fadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1); }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(15px); } to { opacity: 1; transform: translateY(0); } }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 20px; border: 2px solid #f8fafc; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .active-nav { 
            background: linear-gradient(135deg, #facc15 0%, #eab308 100%); 
            color: #0f172a !important; 
            font-weight: 700; 
            box-shadow: 0 10px 15px -3px rgba(234, 179, 8, 0.3), 0 4px 6px -2px rgba(234, 179, 8, 0.15); 
            transform: scale(1.02);
        }
        .nav-link { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .nav-link:hover:not(.active-nav) { background: rgba(255,255,255,0.08); transform: translateX(4px); }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 font-sans antialiased overflow-hidden flex h-screen">
    
    <!-- Sidebar -->
    <aside class="w-72 glass-dark text-white flex flex-col shadow-2xl z-20 h-full relative overflow-y-auto">
        <div class="p-6 border-b border-white/10 flex items-center bg-slate-900/50">
            <img src="{{ asset('images/logo_GCM.png') }}" alt="GCM Logo" class="h-10 w-auto rounded shadow-sm mr-3 bg-white p-0.5">
            <div>
                <h2 class="text-xl font-bold tracking-tight text-white">Grandcitra</h2>
                <p class="text-[10px] text-yellow-400 tracking-widest uppercase font-bold">Sales Info System</p>
            </div>
        </div>

        <nav class="flex-1 px-4 py-8 space-y-2">
            <p class="px-4 text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-5">Menu Utama</p>
            
            @if(Auth::user()->role == 'admin_pusat')
                <a href="{{ route('dashboard.adminPusat') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('dashboard.adminPusat') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-chart-pie w-7 text-lg {{ request()->routeIs('dashboard.adminPusat') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('adminPusat.barang.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('adminPusat.barang.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-box-open w-7 text-lg {{ request()->routeIs('adminPusat.barang.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Master Barang</span>
                </a>
                <a href="{{ route('adminPusat.permintaan.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('adminPusat.permintaan.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-truck-fast w-7 text-lg {{ request()->routeIs('adminPusat.permintaan.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Permintaan Cabang</span>
                </a>
                <a href="{{ route('adminPusat.order.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('adminPusat.order.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-cart-shopping w-7 text-lg {{ request()->routeIs('adminPusat.order.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Order Supplier</span>
                </a>
                <a href="{{ route('adminPusat.users.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('adminPusat.users.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-users-gear w-7 text-lg {{ request()->routeIs('adminPusat.users.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Manajemen Akun</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-receipt w-7 text-lg {{ request()->routeIs('laporan.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Riwayat Transaksi</span>
                </a>
            @elseif(Auth::user()->role == 'kepala_cabang')
                <a href="{{ route('dashboard.kepalaCabang') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('dashboard.kepalaCabang') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-house w-7 text-lg {{ request()->routeIs('dashboard.kepalaCabang') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('kepalaCabang.stok.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('kepalaCabang.stok.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-boxes-stacked w-7 text-lg {{ request()->routeIs('kepalaCabang.stok.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Stok Cabang</span>
                </a>
                <a href="{{ route('kepalaCabang.permintaan.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('kepalaCabang.permintaan.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-cart-flatbed w-7 text-lg {{ request()->routeIs('kepalaCabang.permintaan.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Riwayat Permintaan</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-7 text-lg {{ request()->routeIs('laporan.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Laporan Penjualan</span>
                </a>
            @elseif(Auth::user()->role == 'kasir')
                <a href="{{ route('dashboard.kasir') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('dashboard.kasir') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-desktop w-7 text-lg {{ request()->routeIs('dashboard.kasir') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('kasir.pos.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('kasir.pos.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-cash-register w-7 text-lg {{ request()->routeIs('kasir.pos.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Point of Sale</span>
                </a>
                <a href="{{ route('kasir.keep.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('kasir.keep.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-bookmark w-7 text-lg {{ request()->routeIs('kasir.keep.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Keep Barang</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-receipt w-7 text-lg {{ request()->routeIs('laporan.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Riwayat Transaksi</span>
                </a>
            @elseif(Auth::user()->role == 'manager')
                <a href="{{ route('dashboard.manager') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('dashboard.manager') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-chart-line w-7 text-lg {{ request()->routeIs('dashboard.manager') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Dashboard</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="nav-link flex items-center px-4 py-3.5 rounded-xl {{ request()->routeIs('laporan.*') ? 'active-nav' : 'text-slate-300 hover:text-white' }}">
                    <i class="fa-solid fa-file-invoice-dollar w-7 text-lg {{ request()->routeIs('laporan.*') ? 'opacity-100' : 'opacity-70' }}"></i> <span>Laporan Penjualan</span>
                </a>
            @endif
        </nav>

        <div class="p-4 mt-auto border-t border-white/5">
            <div class="bg-white/5 rounded-2xl p-4 border border-white/10">
                <div class="flex items-center mb-4">
                    <div class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-yellow-400 font-bold shadow-inner border border-yellow-400/30">
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
        <!-- Premium Abstract Background -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <div class="absolute top-[-20%] right-[-10%] w-[50%] h-[50%] rounded-full bg-yellow-400/10 blur-[120px]"></div>
            <div class="absolute bottom-[-20%] left-[-10%] w-[60%] h-[60%] rounded-full bg-blue-400/5 blur-[150px]"></div>
            <div class="absolute top-[40%] left-[20%] w-[30%] h-[30%] rounded-full bg-emerald-400/5 blur-[100px]"></div>
        </div>

        <header class="h-20 glass flex items-center justify-between px-10 z-10 sticky top-0 border-b border-slate-200">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">@yield('header')</h1>
            </div>
            <div class="flex items-center space-x-5">
                <div class="text-sm font-medium text-slate-700 bg-white/80 px-4 py-2 rounded-full border border-yellow-300 shadow-sm flex items-center">
                    <i class="fa-regular fa-clock text-yellow-500 mr-2"></i> <span id="realtime-clock">{{ \Carbon\Carbon::now()->translatedFormat('d F Y, H:i:s') }}</span>
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
    
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Custom styling for SweetAlert to match GCM theme
        const toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
        });

        @if(session('success'))
            toast.fire({
                icon: 'success',
                title: '{{ session("success") }}'
            });
        @endif

        @if($errors->any())
            toast.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan',
                text: 'Silakan periksa kembali inputan Anda.'
            });
        @endif

        // Real-time Clock
        function updateClock() {
            const now = new Date();
            const options = { day: 'numeric', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: false };
            const formatter = new Intl.DateTimeFormat('id-ID', options);
            let formattedDate = formatter.format(now).replace('pukul ', '');
            
            // Format fallback manual if Intl behaves differently
            const months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            const day = String(now.getDate()).padStart(2, '0');
            const month = months[now.getMonth()];
            const year = now.getFullYear();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            
            document.getElementById('realtime-clock').textContent = `${day} ${month} ${year}, ${hours}:${minutes}:${seconds}`;
        }
        
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>
