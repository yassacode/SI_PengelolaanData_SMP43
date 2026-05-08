<?php

namespace App\Http\Controllers;

use App\Models\Disiplin;
use App\Models\Siswa;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DisiplinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $month = $request->input('month');
    
        $disciplines = Discipline::with('student', 'user')
            ->when($search, function ($query) use ($search) {
                return $query->where(function ($query) use ($search) {
                    $query->where('masalah', 'like', "%{$search}%")
                        ->orWhere('tanggal', 'like', "%{$search}%")
                        ->orWhereHas('student', function ($query) use ($search) {
                            $query->where('nama', 'like', "%{$search}%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query->where('name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($month, function ($query) use ($month) {
                $query->whereMonth('tanggal', \Carbon\Carbon::parse($month)->month)
                      ->whereYear('tanggal', \Carbon\Carbon::parse($month)->year);
            })
            ->get();
    
        return view('main.disiplin', [
            'disiplin' => $disciplines,
            'search' => $search,
            'month' => $month,
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

        $dicipline['user_id'] = auth()->user()->id;
        if($request->file('foto')){
            $dicipline['foto'] = $request->file('foto')->store('fotoBuktiDisiplin', 'public');
        }
        $dicipline=Discipline::create($dicipline);
        // dd($request->all());
        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Ditambahkan');
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
        
        $dicipline = Discipline::with('student', 'user')
            ->where('status', 'ACCEPTED') 
            ->when($monthNumber, function ($query, $monthNumber) use ($year) {
                return $query->whereMonth('tanggal', $monthNumber)
                             ->whereYear('tanggal', $year);
            })
            ->get();
    
            // dd($request->all());
        return view('cetak.cetak-disiplin', [
            'disiplin' => $dicipline,
            'month'=>$month
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
        return redirect()->route('disiplin.index')->with('success', 'Data Berhasil Dihapus');
    }

    public function updateStts(Request $request, $id){
        try {
            $item = Discipline::findOrFail($id);
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
