@extends('layouts.wali')

@section('content')
<div class="max-w-5xl mx-auto px-4 pb-12">
    
    <!-- Header & Navigasi -->
    <div class="flex items-center justify-between mb-8">
        <a href="{{ route('wali.dashboard') }}" class="flex items-center text-emerald-600 font-bold hover:underline">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        <h2 class="text-sm font-black text-gray-400 uppercase tracking-widest">Catatan Kedisiplinan</h2>
    </div>

    <!-- Ringkasan Poin -->
    <div class="bg-white rounded-[2.5rem] p-8 shadow-xl shadow-red-900/5 border border-red-50 mb-8 flex flex-col md:flex-row items-center justify-between gap-6">
        <div class="flex items-center space-x-6">
            <div class="bg-red-100 p-5 rounded-3xl text-red-600 shadow-inner">
                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
            </div>
            <div>
                <p class="text-xs font-black text-red-400 uppercase tracking-widest mb-1">Total Poin Pelanggaran</p>
                <h3 class="text-4xl font-black text-gray-800">{{ $totalPoin }} <span class="text-lg text-gray-400 font-bold">Poin</span></h3>
            </div>
        </div>
        <div class="bg-red-50 px-6 py-4 rounded-2xl border border-red-100">
            <p class="text-[10px] font-black text-red-800 uppercase tracking-widest leading-tight">
                Status Kedisiplinan: <br>
                <span class="text-sm font-bold">{{ $totalPoin > 50 ? 'Perlu Pembinaan Khusus' : 'Dalam Batas Wajar' }}</span>
            </p>
        </div>
    </div>

    <!-- Tabel Detail Pelanggaran -->
    <div class="bg-white rounded-[2.5rem] shadow-xl shadow-gray-900/5 border border-gray-100 overflow-hidden">
        <div class="p-6 sm:p-8 border-b border-gray-50 bg-gray-50/50">
            <h3 class="font-black text-xs uppercase tracking-widest text-gray-500">Riwayat Catatan Pelanggaran</h3>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="text-[10px] font-black text-gray-400 uppercase tracking-tighter border-b border-gray-50">
                        <th class="px-6 py-4">Tanggal</th>
                        <th class="px-6 py-4">Jenis Pelanggaran</th>
                        <th class="px-6 py-4">Keterangan</th>
                        <th class="px-6 py-4 text-center">Poin</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($data as $item)
                    <tr class="hover:bg-red-50/30 transition">
                        <td class="px-6 py-4 font-bold text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="bg-gray-100 text-gray-800 text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-widest">
                                {{ $item->jenis }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 italic">
                            "{{ $item->keterangan ?? 'Tanpa keterangan' }}"
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-red-600 font-black">+{{ $item->poin }}</span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-16 text-center">
                            <div class="bg-emerald-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <p class="text-gray-400 font-bold text-sm uppercase tracking-widest">Alhamdulillah, Tidak ada pelanggaran</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-6 bg-gray-50 border-t border-gray-100">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-gray-300 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                <p class="text-[10px] text-gray-400 font-medium leading-relaxed">
                    Sistem poin digunakan untuk memantau kedisiplinan santri selama di pondok. <br>
                    Wali diharapkan ikut membimbing anak jika poin sudah melebihi ambang batas yang ditentukan.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection