<x-app-layout>
<div class="max-w-6xl mx-auto py-8 px-4">
    
    <!-- HEADER HALAMAN -->
    <div class="mb-8">
        <h1 class="text-3xl font-black text-slate-800 tracking-tight">Kedisiplinan Santri</h1>
        <p class="text-slate-500 text-sm">Pencatatan pelanggaran dan poin kedisiplinan santri Al-Misykah.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- KOLOM KIRI: FORM INPUT (STICKY) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden sticky top-24">
                <div class="bg-slate-800 p-6 text-white">
                    <h2 class="text-lg font-bold flex items-center">
                        <i class="fa-solid fa-pen-nib mr-3 text-emerald-400"></i>
                        Input Pelanggaran
                    </h2>
                </div>
                
                <form action="{{ url('/pelanggaran') }}" method="POST" class="p-6 space-y-5">
                    @csrf
                    
                    <!-- PILIH SANTRI -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Pilih Santri</label>
                        <select onchange="gantiSantri(this.value)" required class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 font-bold text-slate-700">
                            <option value="">-- Pilih Nama Santri --</option>
                            @foreach($santri as $s)
                            <option value="{{ $s->id }}" {{ ($santri_id ?? '') == $s->id ? 'selected' : '' }}>
                                {{ $s->nama }}
                            </option>
                            @endforeach
                        </select>
                        <input type="hidden" name="santri_id" value="{{ $santri_id }}">
                    </div>

                    <!-- TANGGAL -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Tanggal Kejadian</label>
                        <input type="date" name="tanggal" value="{{ date('Y-m-d') }}" required 
                               class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 font-semibold text-slate-600">
                    </div>

                    <!-- JENIS & POIN -->
                    <div class="grid grid-cols-3 gap-3">
                        <div class="col-span-2">
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Jenis</label>
                            <input name="jenis" placeholder="Misal: Terlambat" required 
                                   class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 font-semibold text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Poin</label>
                            <input type="number" name="poin" value="5" required 
                                   class="w-full rounded-2xl border-slate-200 focus:ring-rose-500 font-black text-rose-600 text-center">
                        </div>
                    </div>

                    <!-- KETERANGAN -->
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Keterangan Tambahan</label>
                        <textarea name="keterangan" rows="3" placeholder="Detail kronologi singkat..."
                                  class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 text-sm"></textarea>
                    </div>

                    <button type="submit" 
                            class="w-full bg-rose-600 hover:bg-rose-700 text-white py-4 rounded-2xl font-black shadow-lg shadow-rose-500/20 transition-all transform active:scale-95 flex items-center justify-center uppercase tracking-widest text-xs {{ !$santri_id ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ !$santri_id ? 'disabled' : '' }}>
                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                        Simpan Pelanggaran
                    </button>
                </form>
            </div>
        </div>

        <!-- KOLOM KANAN: RIWAYAT PELANGGARAN -->
        <div class="lg:col-span-2">
            @if(!$santri_id)
                <div class="bg-emerald-50 border-2 border-dashed border-emerald-200 rounded-[32px] p-20 text-center">
                    <div class="w-20 h-20 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4 text-emerald-600 text-3xl">
                        <i class="fa-solid fa-user-check"></i>
                    </div>
                    <h3 class="text-xl font-bold text-emerald-800">Siapa yang melanggar?</h3>
                    <p class="text-emerald-600/70 text-sm max-w-xs mx-auto mt-2">Pilih nama santri di panel kiri untuk melihat riwayat kedisiplinan mereka.</p>
                </div>
            @else
                <div class="space-y-4">
                    <div class="flex items-center justify-between px-4 mb-6">
                        <h3 class="font-black text-slate-700 uppercase tracking-widest text-sm">Riwayat Pelanggaran</h3>
                        <span class="bg-rose-100 text-rose-700 px-4 py-1 rounded-full text-[10px] font-black border border-rose-200">
                            TOTAL POIN: {{ $data->sum('poin') }}
                        </span>
                    </div>

                    @forelse($data as $d)
                    <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 flex items-start justify-between hover:border-rose-300 transition-all group">
                        <div class="flex items-start">
                            <!-- Ikon Kalender -->
                            <div class="w-12 h-12 rounded-2xl bg-slate-50 flex flex-col items-center justify-center border border-slate-100 mr-4 shrink-0">
                                <span class="text-[9px] font-black text-slate-400 uppercase leading-none">{{ \Carbon\Carbon::parse($d->tanggal)->format('M') }}</span>
                                <span class="text-lg font-black text-slate-700 leading-tight">{{ \Carbon\Carbon::parse($d->tanggal)->format('d') }}</span>
                            </div>
                            
                            <div>
                                <h4 class="font-black text-slate-800 uppercase tracking-tight text-sm group-hover:text-rose-600 transition-colors">{{ $d->jenis }}</h4>
                                <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $d->keterangan ?? 'Tidak ada keterangan tambahan.' }}</p>
                                <div class="mt-3 flex items-center">
                                    <span class="text-[10px] font-bold text-slate-500 flex items-center">
                                        <i class="fa-solid fa-user-ninja mr-1 text-[8px]"></i>
                                        Petugas: {{ auth()->user()->name }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Badge Poin -->
                        <div class="text-right flex flex-col items-end">
                            <span class="bg-rose-50 text-rose-600 px-3 py-1 rounded-xl text-[10px] font-black border border-rose-100 mb-2">
                                +{{ $d->poin }} POIN
                            </span>
                            <form action="{{ url('/pelanggaran/'.$d->id) }}" method="POST" onsubmit="return confirm('Hapus data pelanggaran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 text-slate-300 hover:text-rose-600 transition-colors">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-[32px] p-12 text-center border border-slate-200 shadow-sm">
                        <p class="text-slate-400 font-bold italic text-sm">Alhamdulillah, belum ada catatan pelanggaran.</p>
                    </div>
                    @endforelse
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function gantiSantri(id) {
    if(id) {
        window.location.href = '/pelanggaran?santri_id=' + id;
    } else {
        window.location.href = '/pelanggaran';
    }
}
</script>
</x-app-layout>