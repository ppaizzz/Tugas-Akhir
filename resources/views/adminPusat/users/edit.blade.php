@extends('layouts.app')
@section('title', 'Edit Akun - Admin Pusat')
@section('header', 'Edit Profil & Sandi')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('adminPusat.users.index') }}" class="inline-flex items-center text-slate-500 hover:text-slate-800 font-medium mb-6 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Akun
    </a>

    <form action="{{ route('adminPusat.users.update', $user->id) }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        @csrf
        @method('PUT')

        <div class="flex items-center mb-6 border-b border-slate-100 pb-4">
            <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center text-yellow-400 font-bold text-xl mr-4 shadow-inner">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            <div>
                <h2 class="text-xl font-bold text-slate-800">Edit Akun: {{ $user->name }}</h2>
                <p class="text-sm text-slate-500">ID Pengguna: #{{ $user->id }}</p>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <h2 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-3 mt-8">Hak Akses & Keamanan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Role (Hak Akses) <span class="text-red-500">*</span></label>
                <select name="role" id="role" required onchange="toggleCabang()" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                    <option value="kasir" {{ old('role', $user->role) == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="kepala_cabang" {{ old('role', $user->role) == 'kepala_cabang' ? 'selected' : '' }}>Kepala Cabang</option>
                    <option value="manager" {{ old('role', $user->role) == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="admin_pusat" {{ old('role', $user->role) == 'admin_pusat' ? 'selected' : '' }}>Admin Pusat</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div id="cabang_container" style="display: none;">
                <label class="block text-sm font-medium text-slate-700 mb-2">Penempatan Cabang <span class="text-red-500">*</span></label>
                <select name="cabang_id" id="cabang_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ old('cabang_id', $user->cabang_id) == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                    @endforeach
                </select>
                @error('cabang_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-8 p-5 bg-amber-50 border border-amber-100 rounded-xl">
            <label class="block text-sm font-medium text-amber-800 mb-2">Ganti Kata Sandi Baru (Opsional)</label>
            <input type="password" name="password" minlength="6" placeholder="Biarkan kosong jika tidak ingin mengubah sandi" class="w-full px-4 py-3 border border-amber-200 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 bg-white text-slate-800 transition">
            <p class="text-xs text-amber-600 mt-1"><i class="fa-solid fa-circle-info mr-1"></i>Isi hanya jika pengguna ingin mengganti passwordnya.</p>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-4 border-t border-slate-100 pt-6">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 flex items-center">
                <i class="fa-solid fa-save mr-2"></i> Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function toggleCabang() {
        var role = document.getElementById('role').value;
        var container = document.getElementById('cabang_container');
        var select = document.getElementById('cabang_id');
        
        if (role === 'kasir' || role === 'kepala_cabang') {
            container.style.display = 'block';
            select.required = true;
        } else {
            container.style.display = 'none';
            select.required = false;
        }
    }
    
    // Jalankan saat load
    toggleCabang();
</script>
@endpush
@endsection
