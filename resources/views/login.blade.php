<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grandcitra System</title>
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
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(24px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .fade-in { animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards; opacity: 0; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Modern Animated Mesh Gradient */
        .bg-mesh {
            background-color: #0f172a;
            background-image: 
                radial-gradient(at 0% 0%, hsla(253,16%,7%,1) 0, transparent 50%), 
                radial-gradient(at 50% 0%, hsla(225,39%,30%,1) 0, transparent 50%), 
                radial-gradient(at 100% 0%, hsla(339,49%,30%,1) 0, transparent 50%);
            animation: meshBG 15s ease infinite alternate;
        }
        @keyframes meshBG {
            0% { background-position: 0% 0%; }
            100% { background-position: 100% 100%; }
        }

        .input-floating:focus-within label,
        .input-floating input:not(:placeholder-shown) + label {
            transform: translateY(-120%) scale(0.85);
            color: #eab308;
        }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen flex">
    
    <!-- Left Section: Ultra Modern Graphics -->
    <div class="hidden lg:flex lg:w-1/2 bg-slate-900 relative overflow-hidden items-center justify-center">
        <!-- Animated Blobs -->
        <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] bg-yellow-400/20 rounded-full blur-[120px] mix-blend-screen animate-pulse"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-blue-600/30 rounded-full blur-[100px] mix-blend-screen animate-pulse" style="animation-delay: 2s;"></div>
        
        <!-- Grid Pattern Overlay -->
        <div class="absolute inset-0 opacity-[0.03]" style="background-image: linear-gradient(#fff 1px, transparent 1px), linear-gradient(90deg, #fff 1px, transparent 1px); background-size: 30px 30px;"></div>

        <div class="z-10 text-left px-16 xl:px-24 w-full fade-in" style="animation-delay: 0.2s;">
            <div class="inline-flex items-center justify-center p-5 bg-white/10 backdrop-blur-md rounded-3xl mb-10 border border-white/10 shadow-2xl">
                <img src="{{ asset('images/logo_GCM.png') }}" alt="GCM Logo" class="h-20 w-auto object-contain drop-shadow-lg">
            </div>
            <h1 class="text-5xl xl:text-7xl font-extrabold tracking-tight mb-6 leading-tight text-white drop-shadow-xl">
                Elevate Your <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-amber-500">Sales Flow.</span>
            </h1>
            <p class="text-lg text-slate-300 font-medium max-w-lg leading-relaxed">Sistem Informasi Penjualan generasi terbaru dengan pemantauan stok cerdas dan pengalaman kasir yang mulus.</p>
            
            <div class="mt-12 flex items-center space-x-4">
                <div class="flex -space-x-3">
                    <div class="w-10 h-10 rounded-full bg-slate-700 border-2 border-slate-900 flex items-center justify-center text-xs font-bold text-white">AP</div>
                    <div class="w-10 h-10 rounded-full bg-blue-700 border-2 border-slate-900 flex items-center justify-center text-xs font-bold text-white">KC</div>
                    <div class="w-10 h-10 rounded-full bg-emerald-600 border-2 border-slate-900 flex items-center justify-center text-xs font-bold text-white">KSR</div>
                </div>
                <p class="text-sm font-medium text-slate-400">Digunakan oleh seluruh divisi</p>
            </div>
        </div>
        
        <!-- Copyright -->
        <div class="absolute bottom-10 left-16 xl:left-24 text-slate-500 text-sm font-medium">
            &copy; {{ date('Y') }} PT Grandcitra Mandiri.
        </div>
    </div>

    <!-- Right Section: Sleek Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-hidden bg-[#F8FAFC]">
        <!-- Mobile Decorative -->
        <div class="absolute top-[-20%] right-[-10%] w-64 h-64 bg-yellow-400/20 rounded-full blur-3xl pointer-events-none lg:hidden"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-64 h-64 bg-blue-400/10 rounded-full blur-3xl pointer-events-none lg:hidden"></div>
        
        <div class="w-full max-w-[440px] glass p-10 sm:p-12 rounded-[2.5rem] shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] z-10 fade-in relative" style="animation-delay: 0.4s;">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-slate-900 rounded-2xl mx-auto flex items-center justify-center shadow-lg mb-6 lg:hidden border border-slate-800 p-3">
                    <img src="{{ asset('images/logo_GCM.png') }}" alt="GCM Logo" class="h-full w-auto object-contain">
                </div>
                <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight">Selamat Datang</h2>
                <p class="text-slate-500 mt-2 font-medium text-sm">Masuk untuk mengelola sistem GCM</p>
            </div>

            @if($errors->any())
                <div class="mb-8 p-4 rounded-2xl bg-red-50/80 border border-red-100 flex items-start shadow-sm backdrop-blur-sm">
                    <div class="text-red-500 mr-3 mt-0.5"><i class="fa-solid fa-circle-exclamation"></i></div>
                    <ul class="text-red-700 text-sm font-semibold space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-5">
                @csrf
                
                <!-- Modern Floating Input -->
                <div class="relative input-floating pt-2">
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder=" "
                        class="block w-full px-5 py-4 bg-white/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-yellow-400/20 focus:border-yellow-400 text-slate-800 transition-all shadow-sm outline-none peer font-medium" 
                        >
                    <label for="email" class="absolute left-5 top-6 text-slate-400 text-sm font-medium transition-all pointer-events-none flex items-center bg-transparent px-1">
                        <i class="fa-regular fa-envelope mr-2"></i> Alamat Email
                    </label>
                </div>

                <div class="relative input-floating pt-2">
                    <input type="password" id="password" name="password" required placeholder=" "
                        class="block w-full px-5 py-4 bg-white/50 border border-slate-200 rounded-2xl focus:ring-4 focus:ring-yellow-400/20 focus:border-yellow-400 text-slate-800 transition-all shadow-sm outline-none peer font-medium" 
                        >
                    <label for="password" class="absolute left-5 top-6 text-slate-400 text-sm font-medium transition-all pointer-events-none flex items-center bg-transparent px-1">
                        <i class="fa-solid fa-lock mr-2"></i> Kata Sandi
                    </label>
                </div>

                <div class="flex items-center justify-between pt-2">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div class="w-5 h-5 border-2 border-slate-300 rounded-md peer-checked:bg-yellow-400 peer-checked:border-yellow-400 transition-all"></div>
                            <i class="fa-solid fa-check absolute text-slate-900 text-xs opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity font-bold"></i>
                        </div>
                        <span class="ml-3 text-sm text-slate-600 font-semibold group-hover:text-slate-900 transition">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm font-bold text-yellow-600 hover:text-yellow-500 transition">Lupa Sandi?</a>
                </div>

                <button type="submit" class="w-full py-4 mt-4 bg-slate-900 text-white rounded-2xl font-bold text-lg shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:shadow-[0_8px_30px_rgb(250,204,21,0.3)] hover:bg-slate-800 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center relative overflow-hidden group">
                    <div class="absolute inset-0 bg-gradient-to-r from-yellow-400 to-amber-500 opacity-0 group-hover:opacity-10 transition-opacity duration-300"></div>
                    <span class="relative z-10">Masuk ke Sistem</span>
                    <i class="fa-solid fa-arrow-right relative z-10 ml-2 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>
            
            <div class="mt-12 text-center flex items-center justify-center gap-2 text-xs text-slate-400 font-semibold uppercase tracking-wider">
                <i class="fa-solid fa-shield-halved"></i>
                End-to-End Secure
            </div>
        </div>
    </div>

</body>
</html>