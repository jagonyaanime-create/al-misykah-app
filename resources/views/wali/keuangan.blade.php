@extends('layouts.wali')

@section('content')
<!-- 1. UPDATE X-DATA: Tambahkan variabel untuk Modal Bukti -->
<div class="max-w-5xl mx-auto px-4 pb-12" x-data="{ tab: 'spp', openBuktiModal: false, buktiUrl: '' }">
    
    <!-- Navigasi & Statistik -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('wali.dashboard') }}" class="flex items-center text-emerald-600 font-bold hover:underline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-8">
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="bg-emerald-100 p-3 rounded-2xl text-emerald-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Total Lunas</p>
                <h4 class="text-2xl font-black text-gray-800">{{ $totalLunas }} Transaksi</h4>
            </div>
        </div>
        <div class="bg-white p-6 rounded-3xl shadow-sm border border-gray-100 flex items-center space-x-4">
            <div class="bg-red-100 p-3 rounded-2xl text-red-600">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Tunggakan SPP</p>
                <h4 class="text-2xl font-black text-gray-800">{{ $totalBelum }} Bulan</h4>
            </div>
        </div>
    </div>

    <!-- Switcher Tab -->
    <div class="flex bg-gray-200/50 p-1 rounded-2xl mb-6 max-w-md mx-auto sm:mx-0">
        <button @click="tab = 'spp'" :class="tab === 'spp' ? 'bg-white shadow-sm text-emerald-700' : 'text-gray-500'" class="flex-1 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all">💳 SPP Bulanan</button>
        <button @click="tab = 'lain'" :class="tab === 'lain' ? 'bg-white shadow-sm text-emerald-700' : 'text-gray-500'" class="flex-1 py-3 text-xs font-black uppercase tracking-widest rounded-xl transition-all">📦 Lain-lain</button>
    </div>

    <!-- ISI TAB SPP -->
    <div x-show="tab === 'spp'" x-transition:enter.duration.300ms class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Periode Bulan</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal Bayar</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest">Jumlah</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-center">Bukti</th>
                    <th class="px-6 py-4 text-[10px] font-black text-gray-400 uppercase tracking-widest text-right">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($riwayatSpp as $item)
                <tr class="hover:bg-emerald-50/30 transition-all group">
                    <td class="px-6 py-5">
                        <p class="text-sm font-bold text-gray-800 tracking-tight">
                            {{ $item->bulan }} <span class="text-gray-400 font-medium">{{ $item->tahun ?? now()->year }}</span>
                        </p>
                    </td>
                    <td class="px-6 py-5">
                        @if($item->status == 'Lunas' || $item->status == 'lunas')
                            <div class="flex items-center text-xs text-gray-500 font-medium">
                                <svg class="w-4 h-4 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->translatedFormat('d F Y') : '—' }}
                            </div>
                        @else
                            <span class="text-xs text-gray-300 italic">— Belum Tercatat —</span>
                        @endif
                    </td>
                    <td class="px-6 py-5">
                        <p class="text-sm font-black text-gray-700">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</p>
                    </td>
                    <!-- KOLOM BUKTI SPP -->
                    <td class="px-6 py-5 text-center">
                        @if(($item->status == 'Lunas' || $item->status == 'lunas') && isset($item->bukti_bayar))
                            <button type="button" @click="openBuktiModal = true; buktiUrl = '{{ asset('storage/bukti_bayar/' . $item->bukti_bayar) }}'" class="text-emerald-600 hover:scale-110 transition-transform">
                                <svg class="w-6 h-6 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </button>
                        @else
                            <span class="text-gray-200">—</span>
                        @endif
                    </td>
                    <td class="px-6 py-5 text-right">
                        @if($item->status == 'Lunas' || $item->status == 'lunas')
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-emerald-100 text-emerald-700 border border-emerald-200 uppercase tracking-tighter">LUNAS</span>
                        @else
                            <span class="inline-flex items-center px-4 py-1.5 rounded-full text-[10px] font-black bg-red-50 text-red-600 border border-red-100 uppercase tracking-tighter">BELUM BAYAR</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- ISI TAB LAIN-LAIN -->
    <div x-show="tab === 'lain'" x-cloak class="bg-white rounded-[2.5rem] shadow-xl border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-black text-xs uppercase tracking-widest text-emerald-800">Pembayaran Lainnya</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-tighter border-b border-gray-50">
                        <th class="px-6 py-4">Nama Pembayaran</th>
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Jumlah</th>
                        <th class="px-6 py-4 text-center">Bukti</th>
                        <th class="px-6 py-4 text-center">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($riwayatLain as $item)
                    <tr class="hover:bg-gray-50/50 transition">
                        <td class="px-6 py-4">
                            <span class="text-sm font-bold text-gray-800 uppercase block">{{ $item->kategori }}</span>
                            <span class="text-[10px] text-gray-400 italic">{{ $item->keterangan }}</span>
                        </td>
                        <td class="px-6 py-4 text-xs text-gray-500">
                            {{ $item->tanggal_bayar ? \Carbon\Carbon::parse($item->tanggal_bayar)->format('d/m/Y') : '—' }}
                        </td>
                        <td class="px-6 py-4 font-bold text-gray-800">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                        <!-- KOLOM BUKTI LAIN-LAIN -->
                        <td class="px-6 py-4 text-center">
                            @if($item->bukti_bayar)
                                <button type="button" @click="openBuktiModal = true; buktiUrl = '{{ asset('storage/bukti_bayar/' . $item->bukti_bayar) }}'" class="text-emerald-600 hover:scale-110 transition-transform">
                                    <svg class="w-5 h-5 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </button>
                            @else
                                <span class="text-gray-200">—</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-center">
                            @if($item->status == 'Lunas' || $item->status == 'lunas')
                                <span class="bg-emerald-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Lunas</span>
                            @else
                                <span class="bg-red-500 text-white text-[9px] font-black px-3 py-1 rounded-full uppercase tracking-widest">Belum</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="p-10 text-center text-gray-400 italic">Belum ada pembayaran lain-lain.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 2. MODAL PREVIEW BUKTI (Pop-up) -->
    <div x-show="openBuktiModal" 
         x-transition 
         class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm" 
         x-cloak>
        <div class="bg-white w-full max-w-md rounded-[40px] overflow-hidden shadow-2xl" @click.away="openBuktiModal = false">
            <div class="bg-emerald-800 p-6 text-white flex justify-between items-center">
                <h3 class="font-bold uppercase text-xs tracking-widest italic">Bukti Pembayaran Sah</h3>
                <button @click="openBuktiModal = false" class="text-white/50 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
            </div>
            <div class="p-4 bg-slate-50 flex justify-center">
                <img :src="buktiUrl" class="max-w-full h-auto rounded-3xl shadow-lg border-2 border-white" alt="Kuitansi">
            </div>
            <div class="p-6 text-center">
                <button @click="openBuktiModal = false" class="w-full py-3 bg-slate-100 text-slate-600 rounded-2xl font-bold text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection