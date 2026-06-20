@extends('layouts.wali')

@section('content')
<div class="max-w-4xl mx-auto px-4 pb-12">
    
    <!-- Tombol Kembali & Navigasi Atas -->
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('wali.dashboard') }}" class="flex items-center text-emerald-600 font-bold hover:text-emerald-700 transition group">
            <div class="bg-emerald-100 p-2 rounded-lg mr-3 group-hover:bg-emerald-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </div>
            <span class="text-sm">Kembali</span>
        </a>
        <h2 class="text-[10px] font-black text-gray-400 uppercase tracking-[0.2em]">Profil Santri</h2>
    </div>

    @forelse($anak as $item)
    <!-- KARTU UTAMA -->
    <div class="bg-emerald-700 rounded-[2.5rem] p-8 sm:p-10 relative overflow-hidden mx-2 mt-2">
        <div class="relative z-10 flex flex-col sm:flex-row items-center text-center sm:text-left gap-6">
            <!-- FOTO PROFIL -->
            <div class="w-24 h-24 sm:w-28 sm:h-28 bg-white/20 rounded-2xl border-4 border-white/30 flex items-center justify-center shadow-lg backdrop-blur-sm overflow-hidden">
                @if($item->foto)
                    <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto {{ $item->nama }}" class="w-full h-full object-cover">
                @else
                    <!-- Placeholder jika foto kosong -->
                    <svg class="w-12 h-12 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path>
                    </svg>
                @endif
            </div>

            <!-- NAMA & STATUS DARI DATABASE -->
            <div class="flex-1">
                <h1 class="text-2xl sm:text-3xl font-black text-white mb-2 leading-tight uppercase">
                    {{ $item->nama }}
                </h1>
                <div class="flex flex-wrap justify-center sm:justify-start gap-2">
                    <span class="bg-black/20 text-white text-[10px] font-bold px-3 py-1 rounded-full border border-white/10 uppercase tracking-widest">
                        NIS: {{ $item->nis }}
                    </span>

                    <!-- LOGIK WARNA STATUS -->
                    @if($item->status == 'aktif')
                        <span class="bg-emerald-400 text-emerald-900 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                            Santri Aktif
                        </span>
                    @else
                        <span class="bg-gray-400 text-white text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest shadow-sm">
                            Alumni
                        </span>
                    @endif
                </div>
            </div>
        </div>
    </div>

        <!-- BODY KARTU (Responsif: 1 Kolom di HP, 2 Kolom di PC) -->
        <div class="p-6 sm:p-10 grid grid-cols-1 md:grid-cols-2 gap-8 sm:gap-12">
            
            <!-- Kolom Kiri: Biodata Diri -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-50 pb-3">
                    <div class="bg-emerald-100 p-1.5 rounded-md text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <h3 class="font-black text-xs uppercase tracking-widest text-emerald-800">Biodata Diri</h3>
                </div>

                <div class="space-y-5">
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter mb-1">Jenis Kelamin</span>
                        <span class="text-sm text-gray-800 font-bold">{{ $item->jenis_kelamin ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter mb-1">Tempat, Tanggal Lahir</span>
                        <span class="text-sm text-gray-800 font-bold">{{ $item->tempat_lahir ?? '-' }}, {{ $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->translatedFormat('d F Y') : '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter mb-1">Alamat Lengkap</span>
                        <span class="text-sm text-gray-800 font-bold leading-relaxed">{{ $item->alamat ?? '-' }}</span>
                    </div>
                    <!-- DATA BARU -->
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter mb-1">Nama Wali</span>
                        <span class="text-sm text-gray-800 font-bold uppercase">{{ $item->wali ?? '-' }}</span>
                    </div>
                    <div class="flex flex-col">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter mb-1">Nomor HP Wali</span>
                        <span class="text-sm text-emerald-700 font-black tracking-widest">{{ $item->no_hp ?? '-' }}</span>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Status Akademik -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 border-b border-gray-50 pb-3">
                    <div class="bg-emerald-100 p-1.5 rounded-md text-emerald-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <h3 class="font-black text-xs uppercase tracking-widest text-emerald-800">Status Akademik</h3>
                </div>

                <div class="space-y-5">
                    <div class="flex justify-between items-end border-b border-dashed border-gray-100 pb-2">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">Kelas Sekolah Formal</span>
                        <span class="text-sm text-emerald-700 font-black bg-emerald-50 px-3 py-1 rounded-lg">{{ $item->kelas ?? '-' }}</span>
                    </div>
                    <!-- DATA BARU -->
                    <div class="flex justify-between items-end border-b border-dashed border-gray-100 pb-2">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">Kelas Muhadhoroh</span>
                        <span class="text-sm text-emerald-700 font-black bg-emerald-50 px-3 py-1 rounded-lg">{{ $item->kelas_muhadhoroh ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-end border-b border-dashed border-gray-100 pb-2">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">Kamar / Asrama</span>
                        <span class="text-sm text-gray-800 font-bold uppercase">{{ $item->kamar ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-end border-b border-dashed border-gray-100 pb-2">
                        <span class="text-[10px] text-gray-400 font-black uppercase tracking-tighter">Terdaftar Sejak</span>
                        <span class="text-sm text-gray-800 font-bold">{{ $item->created_at->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- FOOTER KARTU -->
        <div class="bg-gray-50/50 p-6 sm:px-10 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4 text-center sm:text-left">
            <div class="max-w-xs">
                <p class="text-[9px] text-gray-400 leading-tight uppercase font-bold tracking-tighter">
                    Data ini divalidasi oleh sistem Al-Misykah. <br> Perubahan data hanya dapat dilakukan oleh Admin.
                </p>
            </div>
            <div class="flex items-center gap-3 bg-white p-2 px-4 rounded-xl border border-gray-200 shadow-sm">
                <span class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Verified</span>
                <div class="w-8 h-8 bg-emerald-600 rounded flex items-center justify-center text-white font-bold text-[8px]">QR</div>
            </div>
        </div>
    </div>
    @empty
    <div class="bg-white p-20 rounded-3xl text-center shadow-sm">
        <p class="text-gray-400 italic font-bold">Data santri tidak ditemukan.</p>
    </div>
    @endforelse

</div>
@endsection