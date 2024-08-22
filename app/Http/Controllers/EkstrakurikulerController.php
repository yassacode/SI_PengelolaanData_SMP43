<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class EkstrakurikulerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input("search");
        $month = $request->input('month');
        $data = Extracurricular::with('user')
        ->when($search, function ($query, $search) {
            return $query->where('ekskul', 'like', "%{$search}%");
        })
        ->when($month, function ($query) use ($month) {
            $query->whereMonth('tanggal', \Carbon\Carbon::parse($month)->month)
                  ->whereYear('tanggal', \Carbon\Carbon::parse($month)->year);
        })
        ->get();
        return view('main.ekskul',[
            'data'=>$data,
            'search'=>$search,
            'month' => $month,

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
            "status"=>'nullable',
            'foto'=>'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $data['user_id'] = auth()->user()->id;
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
    public function show(Request $request)
    {
        $month = $request->input('month');
        
        $year = null;
        $monthNumber = null;
        
        if ($month) {
            list($year, $monthNumber) = explode('-', $month);
        }
        
        $data = Extracurricular::where('status', 'ACCEPTED') 
        ->when($monthNumber, function ($query, $monthNumber) use ($year) {
                return $query->whereMonth('tanggal', $monthNumber)
                            ->whereYear('tanggal', $year);
            })
            ->get();

            // dd($request->all());
        return view('cetak.cetak-ekskul', [
            'item' => $data,
            'month' => $month
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
        // Temukan item berdasarkan ID
        $item = Extracurricular::find($id);
    
        // Validasi input
        $this->validate($request, [
            'ekskul' => 'required',
            'kegiatan' => 'required',
            'tanggal' => 'required',
            'lokasi' => 'required',
            'keterangan' => 'required',
            "status"=>'nullable',
            'foto' => 'image|nullable',
        ]);
    
        // Inisialisasi array $data untuk menyimpan data yang akan diupdate
        $data = $request->only(['ekskul', 'kegiatan', 'tanggal', 'lokasi', 'keterangan']);
    
        // Jika ada file foto yang diunggah, tambahkan ke $data
        if ($request->file('foto')) {
            $data['foto'] = $request->file('foto')->store('fotoBuktiEkskul', 'public');
        }
    
        // Update item dengan data yang baru
        $item->update($data);
    
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('ekskul.index')->with([
            'success' => 'Data Berhasil Diupdate',
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

     public function updateStts(Request $request, $id){
         try {
                $item = Extracurricular::findOrFail($id);
                $validatedData = $request->validate([
                    'status' => 'required|in:WAITING,ACCEPTED,DENIED',
                ]);
        
                $item->update([
                    'status' => $validatedData['status'],
                    // 'status' => $request->status,
                ]);
        
                return back()->with('success','Berhasil Diperbarui');
            } catch (Exception $e) {
                return back()->with('error',$e->getMessage());
            } catch (ValidationException $va) {
                return back()->with('error',$va->getMessage());
            } catch (ModelNotFoundException $mn) {
                return back()->with('error',$mn->getMessage());
            }
     }
}
