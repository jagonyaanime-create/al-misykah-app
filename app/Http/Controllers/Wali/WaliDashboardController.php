<?php

namespace App\Http\Controllers\Wali;
use App\Models\AbsensiSholat;
use App\Models\AbsensiNgaji;
use App\Models\AbsensiMuhadhoroh;
use App\Models\Pembayaran;
use App\Models\Pelanggaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Santri;

class WaliDashboardController extends Controller {
    public function index() {
        // Hanya ambil data santri yang user_id nya adalah ID Wali yang sedang login
        $anak = Santri::where('user_id', auth()->id())
            ->withSum('pelanggaran', 'poin') 
            ->get();
        return view('wali.dashboard', compact('anak'));
    }
    public function santri()
    {
        // Mengambil data anak dari wali yang login
        $anak = Santri::where('user_id', auth()->id())->get();
        
        // diarahkan ke resources/views/wali/profil.blade.php
        return view('wali.profil', compact('anak'));
    }

    // 2. Tambahkan fungsi ini di dalam class:
    public function absensi()
    {
        // 1. Ambil data santri milik wali yang login
        $santri = Santri::where('user_id', auth()->id())->first();

        if (!$santri) {
            return redirect()->route('wali.dashboard')->with('error', 'Data anak tidak ditemukan.');
        }

        // 2. Fungsi pembantu untuk mengambil data: Urut Desc -> Group by Tanggal -> Ambil 3 Hari Terakhir
        $getGroupedData = function($model) use ($santri) {
            return $model::where('santri_id', $santri->id)
                ->orderBy('tanggal', 'desc')
                ->get()
                ->groupBy('tanggal') // Mengelompokkan data berdasarkan tanggal yang sama
                ->take(3);           // Hanya ambil 3 grup (3 hari terakhir)
        };

        $dataSholat = $getGroupedData(\App\Models\AbsensiSholat::class);
        $dataNgaji = $getGroupedData(\App\Models\AbsensiNgaji::class);
        $dataMuhadhoroh = $getGroupedData(\App\Models\AbsensiMuhadhoroh::class);

        return view('wali.absensi', compact('santri', 'dataSholat', 'dataNgaji', 'dataMuhadhoroh'));
    }

    public function keuangan()
    {
        $santri = Santri::where('user_id', auth()->id())->first();
        if (!$santri) return back();

        // 1. Ambil data SPP dari DB, gabungkan bulan-tahun sebagai Kunci pencarian
        $pembayaranSpp = Pembayaran::where('santri_id', $santri->id)
                            ->where('kategori', 'SPP')
                            ->get()
                            ->keyBy(function($item) {
                                return $item->bulan . '-' . $item->tahun;
                            });

        $start = now()->startOfYear(); 
        $end = now();
        $riwayatSpp = [];

        // Array nama bulan Indonesia agar sinkron dengan Database
        $bulanIndo = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        while ($start <= $end) {
            $m = (int)$start->format('m');
            $y = $start->format('Y');
            
            $searchKey = $bulanIndo[$m] . '-' . $y;

            $dataMatch = $pembayaranSpp->get($searchKey);

            // PERBAIKAN DI SINI: Tambahkan 'bukti_bayar' => null pada objek dummy
            $riwayatSpp[] = $dataMatch ?? (object)[
                'bulan' => $bulanIndo[$m],
                'tahun' => $y,
                'tanggal_bayar' => null,
                'jumlah' => 420000,
                'status' => 'Belum Bayar',
                'bukti_bayar' => null // <--- Tambahkan ini agar Blade tidak error
            ];
            
            $start->addMonth();
        }

        $riwayatSpp = collect($riwayatSpp)->reverse();

        // --- LOGIKA PEMBAYARAN LAIN-LAIN ---
        $riwayatLain = Pembayaran::where('santri_id', $santri->id)
                            ->where('kategori', '!=', 'SPP')
                            ->latest()
                            ->get();

        // Hitung Statistik (Gunakan perbandingan string yang aman)
        $totalLunas = $pembayaranSpp->where('status', 'Lunas')->count() + $riwayatLain->where('status', 'Lunas')->count();
        $totalBelum = collect($riwayatSpp)->where('status', 'Belum Bayar')->count();

        return view('wali.keuangan', compact('santri', 'riwayatSpp', 'riwayatLain', 'totalLunas', 'totalBelum'));
    }
    public function pelanggaran()
    {
        // 1. Ambil data anak
        $santri = Santri::where('user_id', auth()->id())->first();

        if (!$santri) {
            return back()->with('error', 'Data anak tidak ditemukan.');
        }

        // 2. Ambil semua riwayat pelanggaran
        $data = Pelanggaran::where('santri_id', $santri->id)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        // 3. Hitung total poin
        $totalPoin = $data->sum('poin');

        return view('wali.pelanggaran', compact('santri', 'data', 'totalPoin'));
    }
}