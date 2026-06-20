<?php
namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    // TAMPILAN DAFTAR SANTRI (Gunakan kode Index yang saya berikan terakhir)
    public function index()
    {
        $santri = Santri::where('status', 'aktif')->get();
        return view('pembayaran.index', compact('santri'));
    }

    public function showAuthForm() {
    return view('pembayaran.auth'); // Kita akan buat file tampilannya
    }

    public function verifyAuth(Request $request) {
        if ($request->password === 'rahasia123') { 
            $request->session()->put('pembayaran_verified', true);
            
            // redirect()->intended akan membawa kamu ke halaman yang tadi kamu klik
            // jika tidak ada, defaultnya ke index pembayaran
            return redirect()->intended(route('pembayaran.index'));
        }

        return back()->with('error', 'Password Keuangan Salah!');
    }

    // TAMPILAN RIWAYAT PER SANTRI (Sama seperti Gambar 21)
    public function show($id)
    {
        $santri = Santri::findOrFail($id);
        $pembayaran = Pembayaran::where('santri_id', $id)->get();
        $spp_data = Pembayaran::where('santri_id', $id)->where('kategori', 'SPP')->latest()->get();
        $tunggakan = $spp_data->where('status', '!=', 'Lunas')->count();

        return view('pembayaran.show', compact('santri', 'pembayaran', 'spp_data', 'tunggakan'));
    }

    // INPUT TAGIHAN SPP UNTUK SEMUA SANTRI (Tombol Biru di Index)
    public function generateSPP(Request $request)
    {
        $santris = Santri::where('status', 'aktif')->get();
        foreach ($santris as $s) {
            \App\Models\Pembayaran::updateOrCreate(
                [
                    'santri_id' => $s->id, 
                    'kategori'  => 'SPP', 
                    'bulan'     => $request->bulan, 
                    'tahun'     => $request->tahun ?? date('Y') // Beri default tahun sekarang
                ],
                [
                    'jumlah'     => $request->jumlah, 
                    'status'     => 'Belum Bayar', 
                    'keterangan' => 'Tagihan SPP Bulanan'
                ]
            );
        }
        return redirect()->back()->with('success', "Tagihan SPP {$request->bulan} berhasil diterbitkan.");
    }

    // INPUT TAGIHAN LAIN-LAIN UNTUK SEMUA SANTRI (Tombol Hijau di Index)
    public function tagihanMasal(Request $request)
    {
        $santris = Santri::where('status', 'aktif')->get();
        foreach ($santris as $s) {
            Pembayaran::create([
                'santri_id' => $s->id,
                'kategori' => $request->kategori,
                'jumlah' => $request->jumlah,
                'status' => 'Belum Bayar',
                'keterangan' => $request->keterangan
            ]);
        }
        return redirect()->back()->with('success', "Iuran {$request->kategori} dikirim ke seluruh santri.");
    }

    // FUNGSI UNTUK MENGUBAH STATUS MENJADI LUNAS (Klik tombol Bayar di tabel)
    // app/Http/Controllers/PembayaranController.php

    public function lunas(Request $request, $id)
    {
        $request->validate([
            'bukti_bayar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $pembayaran = \App\Models\Pembayaran::findOrFail($id);

        if ($request->hasFile('bukti_bayar')) {
            $file = $request->file('bukti_bayar');
            $namaFile = 'kuitansi_' . time() . '_' . $id . '.' . $file->getClientOriginalExtension();
            
            // Simpan file ke folder public/storage/bukti_bayar
            $file->move(public_path('storage/bukti_bayar'), $namaFile);
            
            // UPDATE DATABASE (Pastikan baris 'bukti_bayar' ini ada!)
            $pembayaran->update([
                'status' => 'Lunas',
                'tanggal_bayar' => now(),
                'bukti_bayar' => $namaFile // <--- INI HARUS ADA
            ]);

            return redirect()->back()->with('success', 'Berhasil bayar!');
        }
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'santri_id' => 'required',
            'kategori' => 'required',
            'jumlah' => 'required|numeric',
            'status' => 'required',
        ]);

        // 2. Simpan ke Database
        \App\Models\Pembayaran::create([
            'santri_id'     => $request->santri_id,
            'kategori'      => $request->kategori,
            'keterangan'    => $request->keterangan,
            'bulan'         => $request->bulan,   // Otomatis null jika bukan SPP
            'tahun'         => $request->tahun ?? date('Y'),
            'jumlah'        => $request->jumlah,
            'status'        => $request->status,
            'tanggal_bayar' => $request->status == 'Lunas' ? now() : null,
        ]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return redirect()->back()->with('success', 'Alhamdulillah, data pembayaran berhasil dicatat.');
    }

    // Tambahkan di dalam PembayaranController

    public function update(Request $request, $id)
    {
        $pembayaran = \App\Models\Pembayaran::findOrFail($id);
        
        // Logika pembatalan bayar: Jika status diubah ke 'Belum Bayar', hapus tanggal bayarnya
        $status = $request->status;
        $tanggal = ($status == 'Lunas') ? now() : null;

        $pembayaran->update([
            'jumlah' => $request->jumlah,
            'status' => $status,
            'tanggal_bayar' => $tanggal,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembayaran = \App\Models\Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->back()->with('success', 'Data iuran berhasil dihapus.');
    }
}