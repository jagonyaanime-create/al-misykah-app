<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Pelanggaran;

class PelanggaranController extends Controller
{
    public function index(Request $request)
    {
        $santri = Santri::all();

        $santri_id = $request->santri_id;

        if ($santri_id) {
            $data = Pelanggaran::where('santri_id', $santri_id)
                ->latest()
                ->get();
        } else {
            $data = collect(); // kosong kalau belum pilih
        }

        return view('pelanggaran.index', compact('santri','data','santri_id'));
    }

    public function store(Request $request)
    {
        Pelanggaran::create($request->all());
        return back();
    }
}