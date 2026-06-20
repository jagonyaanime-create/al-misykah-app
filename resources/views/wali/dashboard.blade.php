@extends('layouts.wali')

@section('content')
<div class="space-y-6 sm:space-y-10">
    
    <!-- Header Welcome -->
    <div class="text-center sm:text-left">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-gray-800 tracking-tight">Dashboard Utama</h2>
        <p class="text-sm sm:text-base text-gray-500">Pilih layanan santri di bawah ini.</p>
    </div>

    <!-- Grid Menu: Tampilan Permanen (Tanpa Hover) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Data Anak (Emerald Border) -->
        <a href="{{ route('wali.santri') }}" class="flex items-center p-4 sm:p-6 bg-white rounded-2xl shadow-md border-2 border-emerald-500">
            <div class="p-3 sm:p-4 bg-emerald-500 rounded-xl mr-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-800 leading-tight">Data Anak</h3>
                <p class="text-[11px] sm:text-xs text-gray-400">Profil Lengkap</p>
            </div>
        </a>

        <!-- Absensi (Emerald Border) -->
        <a href="{{ route('wali.absensi') }}" class="flex items-center p-4 sm:p-6 bg-white rounded-2xl shadow-md border-2 border-emerald-500">
            <div class="p-3 sm:p-4 bg-emerald-500 rounded-xl mr-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-800 leading-tight">Absensi</h3>
                <p class="text-[11px] sm:text-xs text-gray-400">Kehadiran</p>
            </div>
        </a>

        <!-- Keuangan (Emerald Border) -->
        <a href="{{ route('wali.keuangan') }}" class="flex items-center p-4 sm:p-6 bg-white rounded-2xl shadow-md border-2 border-emerald-500">
            <div class="p-3 sm:p-4 bg-emerald-500 rounded-xl mr-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-800 leading-tight">Keuangan</h3>
                <p class="text-[11px] sm:text-xs text-gray-400">Info Tagihan</p>
            </div>
        </a>

        <!-- Pelanggaran (Red Border - Karena bersifat peringatan) -->
        <a href="{{ route('wali.pelanggaran') }}" class="flex items-center p-4 sm:p-6 bg-white rounded-2xl shadow-md border-2 border-red-500">
            <div class="p-3 sm:p-4 bg-red-500 rounded-xl mr-4">
                <svg class="w-6 h-6 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <h3 class="text-base sm:text-lg font-bold text-gray-800 leading-tight">Pelanggaran</h3>
                <p class="text-[11px] sm:text-xs text-gray-400">Kedisiplinan</p>
            </div>
        </a>

    </div>

    <!-- Info Detail Anak -->
    <div class="bg-emerald-700 rounded-[2rem] p-6 sm:p-10 text-white shadow-xl relative overflow-hidden">
        <div class="relative z-10">
            <h3 class="text-lg font-bold flex items-center mb-6">
                <span class="bg-emerald-500/30 p-2 rounded-lg mr-3">👦</span> 
                Status Santri Anda
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($anak as $item)
                <div class="bg-white/10 backdrop-blur-md border border-white/20 p-5 rounded-2xl flex flex-col sm:flex-row justify-between items-start sm:items-center">
                    <div class="mb-3 sm:mb-0">
                        <p class="text-[10px] uppercase font-bold text-emerald-300 tracking-widest">Nama Santri</p>
                        <h4 class="text-lg font-bold">{{ $item->nama }}</h4>
                        <p class="text-xs opacity-70">NIS: {{ $item->nis }}</p>
                    </div>
                    <div class="flex flex-row sm:flex-col items-center sm:items-end space-x-2 sm:space-x-0 sm:space-y-2">
                        <span class="bg-white text-emerald-700 px-3 py-1 rounded-full text-[10px] font-black uppercase">Aktif</span>
                        <span class="bg-red-500 text-white px-3 py-1 rounded-full text-[10px] font-black uppercase">{{ $item->pelanggaran_sum_poin ?? 0 }} POIN</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <!-- Dekorasi Background -->
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-500 rounded-full opacity-20"></div>
    </div>

</div>
@endsection