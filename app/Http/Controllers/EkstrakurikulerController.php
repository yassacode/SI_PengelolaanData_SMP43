<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use Illuminate\Http\Request;

class EkstrakurikulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input("search");
        $data = Extracurricular::when($search, function ($query, $search) {
            return $query->where('ekskul', 'like', "%{$search}%");
        })->get();
        return view('main.ekskul',[
            'data'=>$data,
            'search'=>$search
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
            'foto'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($request->file('foto')){
            $data['foto'] = $request->file('foto')->store('fotoBuktiEkskul', 'public');
        }
        $data= Extracurricular::create($data);

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
        return view('cetak.cetak-ekskul',[
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
            $data['foto'] = $request->file('foto')->store('fotoBuktiEkskul', 'public');
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
