<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DisiplinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $disciplines = Discipline::with('student')->get();
        $students = Student::all();
    
        return view('main.disiplin', [
            'disiplin' => $disciplines,
            'siswa' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students=Student::all();
        $today = date('Y-m-d');
        return view('tambah.add-disiplin',[
            'today'=>$today,
            'siswa'=>$students
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dicipline = $request-> validate([
            "user_id"=>'nullable',
            "student_id"=>'nullable',
            "masalah"=>'required',
            "kelas"=>'required',
            "tanggal"=>'required',
            "foto"=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "solusi"=>'required',
            "keterangan"=>'required',
            "status"=>'nullable'
        ]);
        if($request->file('foto')){
            $dicipline['foto'] = $request->file('foto')->store('fotoBuktiDisiplin', 'public');
        }
        $dicipline=Discipline::create($dicipline);
        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dicipline = Discipline::find($id);
        return view('cetak.cetak-disiplin',[
            'disiplin'=>$dicipline
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $students=Student::all();
        $dicipline = Discipline::find($id);
        $today = date('Y-m-d');
        return view('tambah.edit-disiplin',[
            'disiplin'=>$dicipline,
            'today'=>$today,
            'siswa'=>$students
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
     

        $dicipline = Discipline::findOrFail($id);

        $validatedData = $request->validate([
            "user_id" => 'nullable',
            // "student_id" => 'nullable',
            "masalah" => 'required',
            "kelas" => 'required',
            "tanggal" => 'required',
            "foto" => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            "solusi" => 'required',
            "keterangan" => 'required',
            "status" => 'nullable'
        ]);

        if ($request->hasFile('foto')) {
            if ($dicipline->foto) {
                Storage::disk('public')->delete($dicipline->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('fotoBuktiDisiplin', 'public');
        } else {
            $validatedData['foto'] = $dicipline->foto;
        }
    
        $dicipline->update($validatedData);

        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Diperbarui');
   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dicipline = Discipline::findOrFail($id);
        $dicipline->delete();
        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Dihapus');            }
    }
