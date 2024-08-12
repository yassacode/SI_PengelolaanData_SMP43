<?php

    namespace App\Http\Controllers;

    use App\Models\Achievement;
    use App\Models\History;
    use App\Models\School;
    use App\Models\Sibling;
    use App\Models\Student;
    use App\Models\StudentParent;
    use Illuminate\Http\Request;

    class SiswaController extends Controller
    {
        /**
         * Display a listing of the resource.
         */
        public function index()
        {
            $students = Student::with('history','school','studentparent','sibling','achievement')->get();
            $histories = History::all();
            $schools = School::all();
            $studentParents = StudentParent::all();
            $siblings = Sibling::all();
            $achievements = Achievement::all();
            
            return view('main.siswa', [
            'siswa' => $students,
            'riwayat' => $histories,
            'sekolah' => $schools,
            'ortu' => $studentParents,
            'saudara' => $siblings,
            'prestasi' => $achievements,
        ]);
        }

        /**
         * Show the form for creating a new resource.
         */
        public function createStep1()
        {
            $today = date('Y-m-d');
            // $students= Student::all();
            return view('tambah.add-step1-siswa',[
                'today'=>$today,
                // 'siswa '=> $students
            ]);
        }
        public function createStep2()
        {
            $today = date('Y-m-d');
            return view('tambah.add-step2-siswa',[
                'today'=>$today,
            ]);
        }
        public function createStep3()
        {
            $today = date('Y-m-d');
            return view('tambah.add-step3-siswa',[
                'today'=>$today,
            ]);
        }

        /**
         * Store a newly created resource in storage.
         */
        public function storeStep1(Request $request)
        {
            $students = $request -> validate([
                "school_id"=>'nullable',
                "student_parent_id"=>'nullable',
                "sibling_id"=>'nullable',
                "history_id"=>'nullable',
                "user_id"=>'nullable',
                "achievement_id"=>'nullable',
                "nama"=>'required',
                "nisn"=>'required',
                "ttl"=>'required',
                "alamat"=>'required',
                "no_hp"=>'required',
                "tb"=>'required',
                "bb"=>'required',
                "hobi"=>'required',
                "agama"=>'required',
                "thn_msk"=>'required',
                "status=>'nullable'"
            ]);
        
            // dd($request->all());
            session()->put('siswa', $students);
            return redirect()->route('siswa.create2');
        }

        public function storeStep2(Request $request)
        {
            $schools = $request -> validate([
            "asal_paud"=>'nullable',
            "asal_tk"=>'required',
            "asal_sd"=>'required',
            "jrk_sklh"=>'required'
            ]);
            $histories = $request -> validate([
            "sakit"=>"nullable",
            "beasiswa"=>"nullable",
            ]);
            $siblings = $request -> validate([
                "jumlah"=>'required',
                "anak_ke"=>'required'
            ]);
            $achievments = $request-> validate([
                'kegiatan'=>'nullable',
                'juara'=>'nullable'
            ]);

            session()->put('sekolah', $schools);
            session()->put('riwayat', $histories);
            session()->put('saudara', $siblings);
            session()->put('prestasi', $achievments);
            return redirect()->route('siswa.create3');
        }
        public function store(Request $request)
        {
        $studentParents = $request -> validate([
            "nama_ayah"=>'nullable',
            "nama_ibu"=>'nullable',
            "nama_wali"=>'nullable',
            "pekerjaan_ayah"=>'nullable',
            "pekerjaan_ibu"=>'nullable',
            "pekerjaan_wali"=>'nullable',
            "alamat_ayah"=>'nullable',
            "alamat_ibu"=>'nullable',
            "alamat_wali"=>'nullable',
            "no_hp_ayah"=>'nullable',
            "no_hp_ibu"=>'nullable',
            "no_hp_wali"=>'nullable',
            "identitas_wali"=>'nullable'
            ]);
            session()->put('ortu', $studentParents);
            $students = session()->get('siswa');
            $histories = session()->get('riwayat');
            // $studentParents = session()->get('ortu');
            $schools = session()->get('sekolah');
            $siblings = session()->get('saudara');
            $achievements = session()->get('prestasi');

            $histories = History::create($histories);
            $studentParents = StudentParent::create($studentParents);
            $schools = School::create($schools);
            $siblings = Sibling::create($siblings);
            $achievements = Achievement::create($achievements);

            Student::create(array_merge($students, [
                'history_id' => $histories->id,
                'school_id' => $schools->id,
                'student_parent_id' => $studentParents->id,
                'sibling_id' => $siblings->id,
                'achievement_id' => $achievements->id,
            ]));

            session()->forget([
                'siswa',
                'riwayat',
                'ortu',
                'sekolah',
                'saudara',
                'prestasi',
            ]);
            return redirect()->route('siswa.index')->with('success', 'Data Berhasil Ditambahkan');
        }

        public function show1(string $id)
        {
            $histories = History::all();
            $schools = School::all();
            $studentParents = StudentParent::all();
            $siblings = Sibling::all();
            $achievements = Achievement::all();
            $students = Student::with('history', 'school', 'studentparent', 'sibling', 'achievement')->find($id);
            return view('main.view-siswa',[
                'students'=>$students,
                'school'=>$schools,
                'studentparent'=>$studentParents,
                'sibling'=>$siblings,
                'achievement'=>$achievements,
                'history'=>$histories
                
            ]);
        }

        public function show2(string $id)
        {
        
            $histories = History::all();
            $schools = School::all();
            $studentParents = StudentParent::all();
            $siblings = Sibling::all();
            $achievements = Achievement::all();
            $students = Student::with('history', 'school', 'studentparent', 'sibling', 'achievement')->find($id);
            return view('cetak.cetak-siswa',[
                'students'=>$students,
                'school'=>$schools,
                'studentparent'=>$studentParents,
                'sibling'=>$siblings,
                'achievement'=>$achievements,
                'history'=>$histories
                
            ]);
        }

        public function edit(string $id)
        {
            $students = Student::find($id);
            $today = date ('Y-m-d');
            return view('tambah.edit-siswa',[
                'siswa'=>$students,
                'today'=>$today,
            ]);
        }

        /**
         * Update the specified resource in storage.
         */
        public function update(Request $request, string $id)
        {
            $students = Student::findOrFail($id);
            $histories = History::findOrFail($id);
            $studentParents= StudentParent::findOrFail($id);
            $schools = School::findOrFail($id);
            $achievements = Achievement::findOrFail($id);
            $siblings = Sibling::findOrFail($id);

            $students -> update($students);
            $histories ->update($histories);
            $studentParents ->update($studentParents);
            $schools ->update($schools);
            $siblings ->update($siblings);
            $achievements ->update($achievements);  
            
            session()->forget([
                'siswa',
                'riwayat',
                'ortu',
                'sekolah',
                'saudara',
                'prestasi',
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data Berhasil Diperbarui');
        }

        /**
         * Remove the specified resource from storage.
         */
        public function destroy(string $id)
        {
            $students = Student::findOrFail($id);
            $histories = History::findOrFail($id);
            $studentParents= StudentParent::findOrFail($id);
            $schools = School::findOrFail($id);
            $achievements = Achievement::findOrFail($id);
            $siblings = Sibling::findOrFail($id);

            $students -> delete();
            $histories ->delete();
            $studentParents ->delete();
            $schools ->delete();
            $siblings ->delete();
            $achievements ->delete();

            return redirect()->route('siswa.index')->with('success', 'Data Berhasil Dihapus');
            
        }
    }
