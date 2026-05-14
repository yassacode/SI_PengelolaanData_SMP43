<?php

namespace App\Http\Controllers;

use App\Models\MasterEkskul;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MasterEkskulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ekskuls = MasterEkskul::withCount('siswas')->get();
        return view('master-ekskul.index', compact('ekskuls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('master-ekskul.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:master_ekskuls,nama',
            'keterangan' => 'nullable|string',
        ]);

        MasterEkskul::create($request->all());

        return redirect()->route('master-ekskul.index')->with('success', 'Ekskul berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $ekskul = MasterEkskul::with('siswas')->findOrFail($id);
        return view('master-ekskul.show', compact('ekskul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $ekskul = MasterEkskul::findOrFail($id);
        return view('master-ekskul.edit', compact('ekskul'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $ekskul = MasterEkskul::findOrFail($id);
        
        $request->validate([
            'nama' => 'required|string|max:255|unique:master_ekskuls,nama,' . $id,
            'keterangan' => 'nullable|string',
        ]);

        $ekskul->update($request->all());

        return redirect()->route('master-ekskul.index')->with('success', 'Ekskul berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        $ekskul = MasterEkskul::findOrFail($id);
        $ekskul->delete();

        return redirect()->route('master-ekskul.index')->with('success', 'Ekskul berhasil dihapus');
    }
}
