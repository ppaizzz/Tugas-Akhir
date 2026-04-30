@extends('layouts.app')
@section('title', 'Manajemen Akun - Admin Pusat')
@section('header', 'Manajemen Akun')

@section('content')
<div class="flex justify-between items-center mb-8">
    <div>
        <p class="text-slate-500 mt-1">Kelola data profil, akses, dan kata sandi seluruh pengguna sistem.</p>
    </div>
    <a href="{{ route('adminPusat.users.create') }}" class="bg-gradient-to-r from-blue-600 to-blue-700 text-white px-6 py-3 rounded-xl font-semibold hover:from-blue-700 hover:to-blue-800 transition-all shadow-lg shadow-blue-600/20 flex items-center">
        <i class="fa-solid fa-user-plus mr-2"></i> Tambah Akun
    </a>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
    <div class="p-6 border-b border-slate-100 bg-slate-50">
        <h2 class="text-lg font-bold text-slate-800">Daftar Pengguna Sistem</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-white border-b border-slate-200 text-slate-600 text-sm">
                    <th class="px-6 py-4 font-semibold">Nama / Email</th>
                    <th class="px-6 py-4 font-semibold">Role (Hak Akses)</th>
                    <th class="px-6 py-4 font-semibold">Lokasi / Cabang</th>
                    <th class="px-6 py-4 font-semibold text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($users as $user)
                <tr class="hover:bg-slate-50 transition">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 font-bold mr-3 border border-slate-200">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-slate-800 text-sm">{{ $user->name }} {!! $user->id === auth()->id() ? '<span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full ml-1">Anda</span>' : '' !!}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        @php
                            $roleColors = [
                                'admin_pusat' => 'bg-purple-100 text-purple-700',
                                'manager' => 'bg-indigo-100 text-indigo-700',
                                'kepala_cabang' => 'bg-blue-100 text-blue-700',
                                'kasir' => 'bg-emerald-100 text-emerald-700',
                            ];
                        @endphp
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold uppercase {{ $roleColors[$user->role] ?? 'bg-slate-100 text-slate-600' }}">
                            {{ str_replace('_', ' ', $user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-medium text-slate-700">
                        {{ optional($user->cabang)->nama ?? 'Pusat / Semua Akses' }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <a href="{{ route('adminPusat.users.edit', $user->id) }}" class="w-8 h-8 rounded-lg bg-amber-100 hover:bg-amber-200 text-amber-600 transition flex items-center justify-center" title="Edit Profil & Sandi">
                                <i class="fa-solid fa-pen-to-square text-xs"></i>
                            </a>
                            @if($user->id !== auth()->id())
                            <form action="{{ route('adminPusat.users.destroy', $user->id) }}" method="POST" id="form-delete-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete({{ $user->id }})" class="w-8 h-8 rounded-lg bg-red-100 hover:bg-red-200 text-red-500 transition flex items-center justify-center" title="Hapus Akun">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Akun?',
            text: "Akun ini akan dihapus permanen dari sistem.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('form-delete-' + id).submit();
            }
        })
    }
</script>
@endpush
@endsection
