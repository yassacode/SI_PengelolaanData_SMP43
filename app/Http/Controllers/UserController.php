<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('main.user',[
            'user' => $users
        ]);
    }

    public function create()
    {
        // $roles = Role::all();
        return view('tambah.add-user',[
            'today' => date('Y-m-d'),
            // 'roles' => $roles
       ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required',
            'jabatan' => 'required',
            'nip' => 'nullable',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
            'roles' => 'nullable|array' // Asumsi form akan mengirimkan array roles
        ]);

        $user = User::create([
            'nama' => $data['nama'],
            'username' => $data['username'],
            'email' => $data['email'],
            'jabatan' => $data['jabatan'],
            'nip' => $data['nip'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
            'password' => Hash::make($data['password']),
        ]);

        if (!empty($data['roles'])) {
            $user->assignRole($data['roles']);
        }

        return redirect()->route('user.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    // method show dihapus karena kosong

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        // $roles = Role::all();
        return view('tambah.edit-user',[
            'user' => $user,
            'today' => date('Y-m-d'),
            // 'roles' => $roles
       ]);
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        
        $data = $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:users,username,' . $user->id,
            'email' => 'required|unique:users,email,' . $user->id,
            'password' => 'nullable',
            'jabatan' => 'required',
            'nip' => 'nullable',
            'no_hp' => 'nullable',
            'alamat' => 'nullable',
            'roles' => 'nullable|array'
        ]);
        
        $updateData = [
            'nama' => $data['nama'],
            'username' => $data['username'],
            'email' => $data['email'],
            'jabatan' => $data['jabatan'],
            'nip' => $data['nip'] ?? null,
            'no_hp' => $data['no_hp'] ?? null,
            'alamat' => $data['alamat'] ?? null,
        ];

        if (!empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        $user->update($updateData);

        if (isset($data['roles'])) {
            $user->syncRoles($data['roles']);
        }

        return redirect()->route('user.index')->with([
            'success'=> 'Data Berhasil diupdate',
        ]);
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success','Berhasil Dihapus');
    }
}
