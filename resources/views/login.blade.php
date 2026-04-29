<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grandcitra System</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                }
            }
        }
    </script>
    <style>
        .glass { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.5); }
        .fade-in { animation: fadeIn 0.6s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .bg-animated { background: linear-gradient(-45deg, #4f46e5, #3b82f6, #06b6d4, #10b981); background-size: 400% 400%; animation: gradientBG 15s ease infinite; }
        @keyframes gradientBG { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }
    </style>
</head>
<body class="font-sans antialiased text-slate-800 bg-slate-50 min-h-screen flex">
    
    <!-- Left Section: Branding & Graphics -->
    <div class="hidden lg:flex lg:w-1/2 bg-animated relative overflow-hidden items-center justify-center">
        <!-- Abstract Shapes -->
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] bg-white/20 rounded-full blur-[80px]"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] bg-black/10 rounded-full blur-[60px]"></div>
        
        <div class="z-10 text-center text-white px-12 fade-in">
            <div class="inline-flex items-center justify-center w-24 h-24 bg-white/20 rounded-3xl backdrop-blur-md mb-8 shadow-2xl border border-white/30">
                <i class="fa-solid fa-gem text-5xl"></i>
            </div>
            <h1 class="text-6xl font-bold tracking-tight mb-4 leading-tight">Grandcitra<br><span class="font-light text-blue-100">Sales System</span></h1>
            <p class="text-xl text-blue-100 font-medium mt-4 max-w-md mx-auto leading-relaxed">Sistem Informasi Penjualan Terintegrasi dengan pemantauan stok real-time.</p>
        </div>
        
        <!-- Copyright -->
        <div class="absolute bottom-10 left-0 w-full text-center text-white/60 text-sm font-medium">
            &copy; {{ date('Y') }} PT Grandcitra. Hak Cipta Dilindungi.
        </div>
    </div>

    <!-- Right Section: Login Form -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 lg:p-24 relative overflow-hidden bg-slate-50">
        <!-- Mobile Decorative Background -->
        <div class="absolute inset-0 bg-animated opacity-[0.03] lg:hidden"></div>
        <div class="absolute top-[-20%] right-[-10%] w-64 h-64 bg-blue-500/10 rounded-full blur-3xl pointer-events-none lg:hidden"></div>
        
        <div class="w-full max-w-[420px] glass p-10 sm:p-12 rounded-[2rem] shadow-2xl z-10 fade-in relative border-white">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-gradient-to-tr from-blue-600 to-indigo-600 rounded-2xl mx-auto flex items-center justify-center text-white shadow-xl mb-6 lg:hidden">
                    <i class="fa-solid fa-gem text-3xl"></i>
                </div>
                <h2 class="text-3xl font-extrabold text-slate-800">Masuk Akun</h2>
                <p class="text-slate-500 mt-3 font-medium">Masukkan kredensial Anda untuk melanjutkan</p>
            </div>

            @if($errors->any())
                <div class="mb-8 p-4 rounded-2xl bg-red-50 border border-red-100 flex items-start shadow-sm">
                    <div class="text-red-500 mr-3 mt-0.5"><i class="fa-solid fa-circle-exclamation text-lg"></i></div>
                    <ul class="text-red-700 text-sm font-medium space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.proses') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-regular fa-envelope text-slate-400 text-lg"></i>
                        </div>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus
                            class="w-full pl-12 pr-4 py-4 bg-white/70 backdrop-blur-sm border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 text-slate-800 transition-all font-medium shadow-sm outline-none placeholder-slate-400" 
                            placeholder="nama@email.com">
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-bold text-slate-700">Kata Sandi</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fa-solid fa-lock text-slate-400 text-lg"></i>
                        </div>
                        <input type="password" name="password" required 
                            class="w-full pl-12 pr-4 py-4 bg-white/70 backdrop-blur-sm border border-slate-200 rounded-2xl focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 text-slate-800 transition-all font-medium shadow-sm outline-none placeholder-slate-400" 
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center pt-2">
                    <label class="flex items-center cursor-pointer group">
                        <div class="relative flex items-center justify-center">
                            <input type="checkbox" name="remember" class="peer sr-only">
                            <div class="w-5 h-5 border-2 border-slate-300 rounded peer-checked:bg-indigo-600 peer-checked:border-indigo-600 transition-all"></div>
                            <i class="fa-solid fa-check absolute text-white text-xs opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity"></i>
                        </div>
                        <span class="ml-3 text-sm text-slate-600 font-semibold group-hover:text-slate-800 transition">Ingat sesi saya</span>
                    </label>
                </div>

                <button type="submit" class="w-full py-4 mt-2 bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 text-white rounded-2xl font-bold text-lg shadow-xl shadow-indigo-600/30 hover:shadow-indigo-600/50 transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center">
                    <span>Masuk ke Sistem</span>
                    <i class="fa-solid fa-arrow-right-to-bracket ml-2"></i>
                </button>
            </form>
            
            <div class="mt-10 text-center text-sm text-slate-400 font-medium">
                Dilindungi dengan enkripsi berlapis
            </div>
        </div>
    </div>

</body>
</html>