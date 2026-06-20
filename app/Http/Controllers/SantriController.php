<?php
namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class SantriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $santri = \App\Models\Santri::all();
        return view('santri.index', compact('santri'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::where('role', 'wali')->get(); // Ambil user yang rolenya wali saja
        return view('santri.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi Profesional
        // Jika NIS sudah ada, Laravel otomatis akan balik ke form dengan pesan error
        $request->validate([
            'nis' => 'required|unique:santri,nis', // Cek duplikat di tabel santri kolom nis
            'nama' => 'required',
            'user_id' => 'required',
            'foto' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ], [
            'nis.unique' => 'Maaf, NIS ini sudah terdaftar di sistem.',
            'nis.required' => 'NIS wajib diisi.',
            'nama.required' => 'Nama santri tidak boleh kosong.'
        ]);

        // 2. Handle Upload Foto (jika ada)
        $input = $request->all();
        if ($request->hasFile('foto')) {
            $namaFoto = time() . '.' . $request->foto->extension();
            $request->foto->move(public_path('images/santri'), $namaFoto);
            $input['foto'] = $namaFoto;
        }

        // 3. Simpan
        Santri::create($input);

        // 4. Redirect dengan Pesan Sukses
        return redirect()->route('santri.index')->with('success', 'Alhamdulillah! Data santri berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $santri = Santri::findOrFail($id);
        $users = User::where('role', 'wali')->get();
        return view('santri.edit', compact('santri', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $santri = Santri::findOrFail($id);
        $santri->update($request->all());
        return redirect()->route('santri.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Santri::destroy($id);
        return redirect()->route('santri.index');
    }
}
