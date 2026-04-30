@extends('layouts.app')
@section('title', 'Tambah Akun - Admin Pusat')
@section('header', 'Tambah Akun Pengguna')

@section('content')
<div class="max-w-3xl">
    <a href="{{ route('adminPusat.users.index') }}" class="inline-flex items-center text-slate-500 hover:text-slate-800 font-medium mb-6 transition">
        <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar Akun
    </a>

    <form action="{{ route('adminPusat.users.store') }}" method="POST" class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
        @csrf

        <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Informasi Profil</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Email Login <span class="text-red-500">*</span></label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <h2 class="text-xl font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4 mt-8">Hak Akses & Keamanan</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-sm font-medium text-slate-700 mb-2">Role (Hak Akses) <span class="text-red-500">*</span></label>
                <select name="role" id="role" required onchange="toggleCabang()" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                    <option value="">-- Pilih Role --</option>
                    <option value="kasir" {{ old('role') == 'kasir' ? 'selected' : '' }}>Kasir</option>
                    <option value="kepala_cabang" {{ old('role') == 'kepala_cabang' ? 'selected' : '' }}>Kepala Cabang</option>
                    <option value="manager" {{ old('role') == 'manager' ? 'selected' : '' }}>Manager</option>
                    <option value="admin_pusat" {{ old('role') == 'admin_pusat' ? 'selected' : '' }}>Admin Pusat</option>
                </select>
                @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div id="cabang_container" style="display: none;">
                <label class="block text-sm font-medium text-slate-700 mb-2">Penempatan Cabang <span class="text-red-500">*</span></label>
                <select name="cabang_id" id="cabang_id" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
                    <option value="">-- Pilih Cabang --</option>
                    @foreach($branches as $b)
                        <option value="{{ $b->id }}" {{ old('cabang_id') == $b->id ? 'selected' : '' }}>{{ $b->nama }}</option>
                    @endforeach
                </select>
                @error('cabang_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="mb-8">
            <label class="block text-sm font-medium text-slate-700 mb-2">Kata Sandi (Password) <span class="text-red-500">*</span></label>
            <input type="password" name="password" required minlength="6" class="w-full px-4 py-3 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-slate-50 text-slate-800 transition">
            <p class="text-xs text-slate-400 mt-1">Minimal 6 karakter.</p>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-4 border-t border-slate-100 pt-6">
            <button type="submit" class="bg-blue-600 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-500/30 flex items-center">
                <i class="fa-solid fa-save mr-2"></i> Simpan Akun
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
            select.value = '';
        }
    }
    
    // Jalankan saat load untuk mengecek old value
    toggleCabang();
</script>
@endpush
@endsection
