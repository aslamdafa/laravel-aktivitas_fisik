<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{
    $siswa = Siswa::where('orangtua_id', auth()->id())->get();
    return view('siswa.index', compact('siswa'));
}

public function create()
{
    return view('siswa.create');
}

public function store(Request $request)
{
    $request->validate([
        'nama' => 'required',
        'kelas' => 'required',
    ]);

    Siswa::create([
        'nama' => $request->nama,
        'kelas' => $request->kelas,
        'orangtua_id' => auth()->id(),
        'sekolah_id' => auth()->user()->sekolah_id,
    ]);

    return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan.');
}

}
