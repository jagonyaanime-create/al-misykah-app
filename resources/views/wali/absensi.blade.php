@extends('layouts.wali')

@section('content')
<div class="max-w-5xl mx-auto px-4 pb-12">
    
    <!-- Tombol Kembali -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('wali.dashboard') }}" class="flex items-center text-emerald-600 font-bold hover:underline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <h2 class="text-sm font-black text-gray-400 uppercase tracking-widest">Laporan Kehadiran</h2>
    </div>

    <!-- Judul & Nama Anak -->
    <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 mb-8 flex items-center justify-between">
        <div>
            <p class="text-[10px] font-black text-emerald-600 uppercase tracking-[0.2em] mb-1">Data Santri</p>
            <h3 class="text-2xl font-black text-gray-800 uppercase">{{ $santri->nama }}</h3>
        </div>
        <div class="bg-emerald-100 p-3 rounded-2xl text-emerald-600 hidden sm:block">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
    </div>

    <!-- SISTEM TAB -->
    <div x-data="{ tab: 'sholat' }" class="space-y-8">
        
        <!-- Menu Tab Modern -->
        <div class="flex bg-gray-200/50 p-1.5 rounded-2xl w-full max-w-lg mx-auto shadow-inner">
            <button @click="tab = 'sholat'" :class="tab === 'sholat' ? 'bg-white shadow-md text-emerald-700' : 'text-gray-400'" class="flex-1 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all">🕌 Sholat</button>
            <button @click="tab = 'ngaji'" :class="tab === 'ngaji' ? 'bg-white shadow-md text-emerald-700' : 'text-gray-400'" class="flex-1 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all">📖 Ngaji</button>
            <button @click="tab = 'muhadhoroh'" :class="tab === 'muhadhoroh' ? 'bg-white shadow-md text-emerald-700' : 'text-gray-400'" class="flex-1 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all">Muhadhoroh</button>
        </div>

        <!-- =========================== 
            TAB ISI: SHOLAT 
        ============================ -->
        <div x-show="tab === 'sholat'" x-cloak class="space-y-6">
            @forelse($dataSholat as $tanggal => $items)
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-emerald-900/5 overflow-hidden border border-gray-100">
                <!-- Header Tanggal & Hari -->
                <div class="p-6 bg-slate-50/80 border-b border-gray-100 flex justify-between items-center">
                    <h4 class="font-black text-xs uppercase tracking-widest text-emerald-800">
                        <i class="fa-solid fa-calendar-day mr-2"></i>
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                    </h4>
                    <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[9px] font-black uppercase">Sesi Lengkap</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-gray-50">
                            @foreach($items as $s)
                            <tr class="hover:bg-emerald-50/30 transition">
                                <td class="px-8 py-5 text-xs font-black text-gray-500 uppercase w-1/3">{{ $s->waktu }}</td>
                                <td class="px-8 py-5 text-right">
                                    <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase tracking-widest 
                                    {{ $s->status == 'hadir' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-200' : 'bg-rose-500 text-white shadow-lg shadow-rose-200' }}">
                                        {{ $s->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @empty
            <div class="p-20 text-center text-gray-400 italic font-bold">Belum ada data absensi sholat.</div>
            @endforelse
        </div>

        <!-- =========================== 
            TAB ISI: NGAJI 
        ============================ -->
        <div x-show="tab === 'ngaji'" x-cloak class="space-y-6">
            @forelse($dataNgaji as $tanggal => $items)
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-emerald-900/5 overflow-hidden border border-gray-100">
                <div class="p-6 bg-slate-50/80 border-b border-gray-100">
                    <h4 class="font-black text-xs uppercase tracking-widest text-emerald-800">
                        <i class="fa-solid fa-calendar-day mr-2"></i>
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                    </h4>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($items as $n)
                        <tr class="hover:bg-emerald-50/30 transition">
                            <td class="px-8 py-5 text-xs font-black text-gray-500 uppercase">{{ $n->sesi }}</td>
                            <td class="px-8 py-5 text-right">
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $n->status == 'hadir' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                    {{ $n->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @empty
            <div class="p-20 text-center text-gray-400 italic font-bold">Belum ada data absensi ngaji.</div>
            @endforelse
        </div>

        <!-- =========================== 
            TAB ISI: MUHADHOROH 
        ============================ -->
        <div x-show="tab === 'muhadhoroh'" x-cloak class="space-y-6">
            @forelse($dataMuhadhoroh as $tanggal => $items)
            <div class="bg-white rounded-[2.5rem] shadow-xl shadow-emerald-900/5 overflow-hidden border border-gray-100">
                <div class="p-6 bg-slate-50/80 border-b border-gray-100">
                    <h4 class="font-black text-xs uppercase tracking-widest text-emerald-800">
                        <i class="fa-solid fa-calendar-day mr-2"></i>
                        {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('l, d F Y') }}
                    </h4>
                </div>
                <table class="w-full text-left">
                    <tbody class="divide-y divide-gray-50">
                        @foreach($items as $m)
                        <tr class="hover:bg-emerald-50/30 transition">
                            <td class="px-8 py-5 text-xs font-black text-gray-500 uppercase">{{ $m->sesi }}</td>
                            <td class="px-8 py-5 text-right">
                                <span class="px-4 py-1.5 rounded-xl text-[10px] font-black uppercase {{ $m->status == 'hadir' ? 'bg-emerald-500 text-white' : 'bg-rose-500 text-white' }}">
                                    {{ $m->status }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @empty
            <div class="p-20 text-center text-gray-400 italic font-bold">Belum ada data absensi muhadhoroh.</div>
            @endforelse
        </div>

    </div>
</div>
@endsection