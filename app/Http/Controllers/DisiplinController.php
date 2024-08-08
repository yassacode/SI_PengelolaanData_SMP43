<?php

namespace App\Http\Controllers;

use App\Models\Discipline;
use App\Models\Student;
use Illuminate\Http\Request;

class DisiplinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dicipline =Discipline::all();
        $students = Student::all();
        return view('main.disiplin',[
            'disiplin'=>$dicipline,
            'siswa' => $students
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = date('Y-m-d');
        return view('tambah.add-disiplin',[
            'today'=>$today,
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
            "masalah",
            "kelas",
            "tanggal",
            "foto",
            "solusi",
            "keterangan",
            "status"=>'nullable'
        ]);
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
        $dicipline = Discipline::find($id);
        $today = date('Y-m-d');
        return view('tambah.edit-disiplin',[
            'disiplin'=>$dicipline,
            'today'=>$today
            ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $dicipline = Discipline::findOrFail($id);
        $dicipline->update($dicipline);

        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Diperbarui');
   }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dicipline = Discipline::findOrFail($id);
        $dicipline->delete();
        return redirect()->route('siswa.index')->with('success', 'Data Berhasil Dihapus');            }
    }
