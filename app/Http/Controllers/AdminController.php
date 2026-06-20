<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Pembayaran;
use App\Models\Pelanggaran;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        // --- DATA STATISTIK ATAS (Tetap gunakan yang kemarin) ---
        $totalSantri = Santri::count();
        $totalTunggakan = Pembayaran::where('status', 'Belum Bayar')->where('kategori', 'SPP')->count();
        $hariIni = now()->toDateString();

        // 1. Ambil yang Alfa di Sholat + Tambah Label
        $alfaSholat = \App\Models\AbsensiSholat::with('santri')
                        ->where('tanggal', $hariIni)
                        ->where('status', 'alfa')
                        ->get()
                        ->map(function ($item) {
                            $item->kategori_absen = 'Sholat';
                            $item->sesi_absen = $item->waktu; // Sholat pakai kolom 'waktu'
                            return $item;
                        });

        // 2. Ambil yang Alfa di Ngaji + Tambah Label
        $alfaNgaji = \App\Models\AbsensiNgaji::with('santri')
                        ->where('tanggal', $hariIni)
                        ->where('status', 'alfa')
                        ->get()
                        ->map(function ($item) {
                            $item->kategori_absen = 'Ngaji';
                            $item->sesi_absen = $item->sesi; // Ngaji pakai kolom 'sesi'
                            return $item;
                        });

        // 3. Ambil yang Alfa di Muhadhoroh + Tambah Label
        $alfaMuha = \App\Models\AbsensiMuhadhoroh::with('santri')
                        ->where('tanggal', $hariIni)
                        ->where('status', 'alfa')
                        ->get()
                        ->map(function ($item) {
                            $item->kategori_absen = 'Muhadhoroh';
                            $item->sesi_absen = $item->sesi; // Muhadhoroh pakai kolom 'sesi'
                            return $item;
                        });

        // GABUNGKAN SEMUANYA
        $rekapAlfa = $alfaSholat->concat($alfaNgaji)->concat($alfaMuha);

        // --- 2. REKAP SANTRI BELUM BAYAR SPP ---
        // Kita ambil santri yang punya tagihan SPP 'Belum Bayar'
        // Menggunakan groupBy agar satu anak tidak muncul berkali-kali jika nunggak banyak bulan
        $rekapTunggakan = \App\Models\Pembayaran::with('santri')
                            ->where('kategori', 'SPP')
                            ->where('status', 'Belum Bayar')
                            ->select('santri_id', \DB::raw('count(*) as total_bulan'), \DB::raw('sum(jumlah) as total_nominal'))
                            ->groupBy('santri_id')
                            ->orderByDesc('total_bulan')
                            ->take(10) // Tampilkan 10 teratas
                            ->get();

        // Kirim data ke blade
        return view('admin.dashboard', compact(
            'totalSantri', 'totalTunggakan', 'rekapAlfa', 'rekapTunggakan'
        ));
    }
}