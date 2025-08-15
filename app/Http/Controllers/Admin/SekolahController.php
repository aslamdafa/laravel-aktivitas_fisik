<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sekolah;

class SekolahController extends Controller
{
    public function index()
    {
        $sekolahs = Sekolah::all();
        return view('admin.sekolah.index', compact('sekolahs'));
    }

    public function create()
    {
        return view('admin.sekolah.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500', // tambahkan validasi jika kamu ingin alamat juga
        ]);

        Sekolah::create([
            'nama_sekolah' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.sekolah.index')->with('success', 'Sekolah berhasil ditambahkan.');
    }

    public function edit($id)
    {
    $sekolah = Sekolah::findOrFail($id);
    return view('admin.sekolah.edit', compact('sekolah'));
    }

    public function destroy($id)
{
    $sekolah = Sekolah::findOrFail($id);
    $sekolah->delete();

    return redirect()->route('admin.sekolah.index')->with('success', 'Sekolah berhasil dihapus.');
}
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:500',
        ]);

        $sekolah = Sekolah::findOrFail($id);
        $sekolah->update([
            'nama_sekolah' => $request->nama,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.sekolah.index')->with('success', 'Sekolah berhasil diperbarui.');
    }

    public function show(Sekolah $sekolah)
{
    return view('admin.sekolah.show', compact('sekolah'));
}

}
