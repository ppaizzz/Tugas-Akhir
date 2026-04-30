<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Tampilkan semua user kecuali admin pusat itu sendiri jika tidak ingin ditampilkan
        $users = User::with('cabang')->orderBy('role')->get();
        return view('adminPusat.users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::all();
        return view('adminPusat.users.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin_pusat,manager,kepala_cabang,kasir',
            'cabang_id' => 'nullable|required_if:role,kepala_cabang,kasir|exists:cabang,id',
        ], [
            'cabang_id.required_if' => 'Cabang wajib dipilih untuk Kasir atau Kepala Cabang.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'cabang_id' => in_array($request->role, ['kepala_cabang', 'kasir']) ? $request->cabang_id : null,
        ]);

        return redirect()->route('adminPusat.users.index')->with('success', 'Akun pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $branches = Branch::all();
        return view('adminPusat.users.edit', compact('user', 'branches'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin_pusat,manager,kepala_cabang,kasir',
            'cabang_id' => 'nullable|required_if:role,kepala_cabang,kasir|exists:cabang,id',
            'password' => 'nullable|string|min:6', // Password opsional saat update
        ], [
            'cabang_id.required_if' => 'Cabang wajib dipilih untuk Kasir atau Kepala Cabang.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'cabang_id' => in_array($request->role, ['kepala_cabang', 'kasir']) ? $request->cabang_id : null,
        ];

        // Jika password diisi, maka update password
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('adminPusat.users.index')->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'Anda tidak dapat menghapus akun Anda sendiri.']);
        }

        $user->delete();
        return back()->with('success', 'Akun berhasil dihapus.');
    }
}
