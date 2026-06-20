<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Attendance;
use App\Models\Payment;
use App\Models\Violation;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Dashboard untuk Pengurus / Admin
     */
    public function adminIndex()
    {
        // Mengambil statistik global untuk Dashboard Admin
        $data = [
            'total_santri'      => Santri::count(),
            'total_pelanggaran' => Violation::whereDate('created_at', today())->count(),
            'total_pembayaran'  => Payment::where('status', 'lunas')->whereMonth('created_at', now()->month)->sum('nominal'),
            
            // Mengambil 5 absensi terbaru untuk ditampilkan di tabel dashboard
            'recent_absensi'    => Attendance::with('santri')->latest()->take(5)->get(),
            
            // Mengambil 5 pelanggaran terbaru
            'recent_violations' => Violation::with('santri')->latest()->take(5)->get(),
        ];

        return view('admin.dashboard', $data);
    }

    /**
     * Dashboard untuk Wali Santri
     */
    public function waliIndex()
    {
        $user = Auth::user();

        // MENCARI DATA ANAK: Mencari santri yang terhubung dengan akun Wali (user_id)
        // Pastikan di tabel santris ada kolom 'user_id'
        $santri = Santri::where('user_id', $user->id)->first();

        if (!$santri) {
            return view('wali.dashboard')->with('error', 'Data santri belum dihubungkan ke akun ini.');
        }

        // Mengambil data spesifik HANYA UNTUK ANAK TERSEBUT
        $data = [
            'santri'        => $santri,
            
            // Absensi (Sholat, Muhadhoroh, Musyafahah)
            'absensi'       => Attendance::where('santri_id', $santri->id)
                                ->orderBy('tanggal', 'desc')
                                ->take(10)->get(),
            
            // Riwayat Pembayaran (Satu tahun terakhir)
            'pembayaran'    => Payment::where('santri_id', $santri->id)
                                ->orderBy('tahun', 'desc')
                                ->orderBy('bulan', 'desc')
                                ->get(),
            
            // Data Pelanggaran
            'pelanggaran'   => Violation::where('santri_id', $santri->id)
                                ->latest()
                                ->get(),
        ];

        return view('wali.dashboard', $data);
    }
}