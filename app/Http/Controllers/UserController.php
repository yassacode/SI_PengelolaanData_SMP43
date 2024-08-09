<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'level'=>'required',
            'jabatan'=>'required',
            'nip'=>'required',
            'no_hp'=>'required',
            'alamat'=>'required',
        ]);

        $users=User::create($users);
        
        return redirect()->route('user.index')->with([
            'success' => 'Data Berhasil Ditambahkan'
        ]);
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
        $users = User::find($id);
        $this->validate($request,[
            'name'=>'required',
            'email'=>'required',
            'password'=>'required',
            'level'=>'required',
            'jabatan'=>'required',
            'nip'=>'required',
            'no_hp'=>'required',
            'alamat'=>'required',
        ]);

        $users->update($users);
        return redirect()->route('user.index')->with([
            'success'=> 'Data Berhasil Ditambahkan',
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
