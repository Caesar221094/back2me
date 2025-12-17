<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id','desc')->paginate(20);
        return view('back2me.admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('back2me.admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:superadmin,petugas,user',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('back2me.admin.users.index')->with('success','Akun dibuat');
    }

    public function edit(User $user)
    {
        return view('back2me.admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|in:superadmin,petugas,user',
            'is_banned' => 'nullable|boolean',
        ]);

        $user->update($request->only(['name','role']) + ['is_banned' => (bool)$request->is_banned]);

        return redirect()->route('back2me.admin.users.index')->with('success','Akun diperbarui');
    }

    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make('password123')]);
        return redirect()->back()->with('success','Password di-reset (password123)');
    }

    public function destroy(User $user)
    {
        // Jangan hapus superadmin satu-satunya atau diri sendiri
        if ($user->id === auth()->id()) {
            return redirect()->back()->with('error','Tidak bisa menghapus akun Anda sendiri');
        }

        $user->delete();
        return redirect()->route('back2me.admin.users.index')->with('success','Akun berhasil dihapus');
    }
}
