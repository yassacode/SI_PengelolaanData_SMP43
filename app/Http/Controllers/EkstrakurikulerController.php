<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data =Extracurricular::all();
        return view('main.ekskul',[
            'data'=>$data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $today = date('Y-m-d');
        return view('tambah.add-ekskul',[
            'today'=>$today,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $data = $request -> validate([
            'ekskul'=>'required',
            'kegiatan'=>'required',
            'tanggal'=>'required',
            'lokasi'=>'required',
            'keterangan'=>'required',
            'foto'=>'image|nullable',
        ]);
        if($request->file('foto')){
            $data['foto'] = $request->file('foto')->store('asset/scanKegiatan', 'public');
        }
        Extracurricular::create($data);

        return redirect()->route('ekskul.index')->with([
            'success' => 'Data Berhasil Ditambahkan',
        ]);
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = Extracurricular::find($id);
        return view('ekskul.print',[
            'item'=>$item,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = Extracurricular::find($id);
        $today = date ('Y-m-d');
        return view('tambah.edit-ekskul',[
            'item'=>$item,
            'today'=>$today,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $item = Extracurricular::find($id);
        $this->validate($request,[
            'ekskul'=>'required',
            'kegiatan'=>'required',
            'tanggal'=>'required',
            'lokasi'=>'required',
            'keterangan'=>'required',
            'foto'=>'image|nullable',
        ]);
        if($request->file('foto')){
            $data['foto'] = $request->file('foto')->store('asset/scanKegiatan', 'public');
        }

        $item->update($data);
        return redirect()->route('ekskul.index')->with([
            'success' => 'Data Berhasil Ditambahkan',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = Extracurricular::find($id);
        $item->delete();
        return back()->with('success','Berhasil Dihapus');
        }
}
