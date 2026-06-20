<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\AbsensiSholat;
use App\Models\AbsensiMuhadhoroh;
use App\Models\AbsensiNgaji;
use Illuminate\Support\Facades\DB;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $tanggal = $request->tanggal ?? date('Y-m-d');
        $jenis   = $request->jenis ?? 'sholat';
        $waktu   = $request->waktu ?? ($jenis == 'sholat' ? 'subuh' : ($jenis == 'muhadhoroh' ? 'sore' : 'pagi'));
        $kelas   = $request->kelas;
        $kamar   = $request->kamar;

        // Filter Santri
        $santri = Santri::query();
        if ($kelas) $santri->where('kelas', $kelas);
        if ($kamar) $santri->where('kamar', $kamar);
        $santri = $santri->get();

        // Ambil absensi sesuai jenis (Merapikan logika keyBy)
        $absensi = collect();
        if ($jenis == 'sholat') {
            $absensi = AbsensiSholat::where('tanggal', $tanggal)->where('waktu', $waktu)->get();
        } elseif ($jenis == 'muhadhoroh') {
            $absensi = AbsensiMuhadhoroh::where('tanggal', $tanggal)->where('sesi', $waktu)->get();
        } else {
            $absensi = AbsensiNgaji::where('tanggal', $tanggal)->where('sesi', $waktu)->get();
        }
        
        $absensi = $absensi->keyBy('santri_id');

        // List untuk dropdown filter
        $listKelas = Santri::distinct()->pluck('kelas')->filter();
        $listKamar = Santri::distinct()->pluck('kamar')->filter();

        return view('absensi.index', compact(
            'santri', 'absensi', 'tanggal', 'jenis', 'waktu', 'kelas', 'kamar', 'listKelas', 'listKamar'
        ));
    }

    /**
     * Fungsi baru untuk Kirim Semua Absensi Sekaligus
     */
    public function bulkStore(Request $request)
    {
        $data    = $request->data; // Isinya: [id_santri => status]
        $jenis   = $request->jenis;
        $tanggal = $request->tanggal;
        $waktu   = $request->waktu;

        try {
            DB::beginTransaction();

            foreach ($data as $santri_id => $status) {
                if ($jenis == 'sholat') {
                    AbsensiSholat::updateOrCreate(
                        ['santri_id' => $santri_id, 'tanggal' => $tanggal, 'waktu' => $waktu],
                        ['status' => $status]
                    );
                } elseif ($jenis == 'muhadhoroh') {
                    AbsensiMuhadhoroh::updateOrCreate(
                        ['santri_id' => $santri_id, 'tanggal' => $tanggal, 'sesi' => $waktu],
                        ['status' => $status]
                    );
                } else {
                    AbsensiNgaji::updateOrCreate(
                        ['santri_id' => $santri_id, 'tanggal' => $tanggal, 'sesi' => $waktu],
                        ['status' => $status]
                    );
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Absensi berhasil disimpan']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // Fungsi quick tetap dipertahankan jika Anda ingin perubahan langsung tersimpan saat tombol diklik
    public function quick(Request $request)
    {
        // ... kode quick Anda yang lama (sama seperti sebelumnya) ...
        // (Pastikan logika quick tetap ada jika Anda ingin real-time update per tombol)
    }
}