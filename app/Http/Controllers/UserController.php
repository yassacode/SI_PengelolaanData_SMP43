<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('main.user',[
            'user'=> $users
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = date('Y-m-d');
        return view('tambah.add-user',[
            'today'=>$today,
       ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    
    $users = $request->validate([
        'name' => 'required',
        'email' => 'required|unique:users,email',
        'password' => 'required',
        'level' => 'required',
        'jabatan' => 'required',
        'nip' => 'required',
        'no_hp' => 'required',
        'alamat' => 'required',
    ]);
    $users = User::create([
        'name' => $users['name'],
        'email' => $users['email'],
        'level'=> $users['level'],
        'jabatan'=> $users['jabatan'],
        'nip'=> $users['nip'],
        'no_hp'=> $users['no_hp'],
        'alamat'=>$users['alamat'],
        'password' => Hash::make($users['password']),
        
    ]);
    dd($request->all());

    return redirect()->route('user.index')->with('success', 'Data Berhasil Ditambahkan');

}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $users = User::find($id);
        $today = date ('Y-m-d');
        return view('tambah.edit-user',[
            'user'=>$users,
            'todat'=>$today
       ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $users = User::findOrFail($id);
        
        $user =$request->validate([
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'level'=>'required',
            'jabatan'=>'required',
            'nip'=>'required',
            'no_hp'=>'required',
            'alamat'=>'required',
        ]);
        
        $user['password'] = bcrypt($request->input('password'));
        $users->update($user);
        return redirect()->route('user.index')->with([
            'success'=> 'Data Berhasil diupdate',
            ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $users = User::find($id);
        $users->delete();
        return back()->with('success','Berhasil Dihapus');
    }
}
