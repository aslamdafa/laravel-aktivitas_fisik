<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JenisAktivitas;
use App\Models\Intensitas;

class JenisAktivitasController extends Controller
{
    public function index()
    {
        $data = JenisAktivitas::with('intensitas')->get();
        return view('admin.jenis-aktivitas.index', compact('data'));
    }

    public function create()
    {
        $intensitas = Intensitas::all();
        return view('admin.jenis-aktivitas.create', compact('intensitas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'intensitas_id' => 'required|exists:intensitas,id',
        ]);

        JenisAktivitas::create([
            'nama' => $request->nama,
            'intensitas_id' => $request->intensitas_id
        ]);

        return redirect()->route('jenis-aktivitas.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jenisAktivitas = JenisAktivitas::findOrFail($id);
        $intensitas = Intensitas::all();
        return view('admin.jenis-aktivitas.edit', compact('jenisAktivitas', 'intensitas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:100',
            'intensitas_id' => 'required|exists:intensitas,id',
        ]);

        $jenisAktivitas = JenisAktivitas::findOrFail($id);
        $jenisAktivitas->update([
            'nama' => $request->nama,
            'intensitas_id' => $request->intensitas_id
        ]);

        return redirect()->route('jenis-aktivitas.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jenisAktivitas = JenisAktivitas::findOrFail($id);
        $jenisAktivitas->delete();

        return redirect()->route('jenis-aktivitas.index')->with('success', 'Data berhasil dihapus');
    }
}
