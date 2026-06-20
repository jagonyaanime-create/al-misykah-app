<x-app-layout>
    <div class="max-w-6xl mx-auto py-8 px-4" 
        x-data="{ 
            tab: 'spp', 
            openModal: false, 
            openBayarModal: false, 
            openBuktiModal: false, 
            buktiUrl: '',          
            kategori: 'SPP', 
            selectedId: null 
        }">
        
        <!-- Header Kembali -->
        <div class="mb-8 flex items-center justify-between">
            <a href="{{ route('pembayaran.index') }}" class="inline-flex items-center text-emerald-700 font-bold hover:underline transition-all">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Daftar
            </a>
            <h2 class="text-slate-400 text-xs font-bold uppercase tracking-widest italic">Detail Keuangan Santri</h2>
        </div>

        <!-- SUMMARY CARDS -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center">
                <div class="w-16 h-16 rounded-3xl bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="ml-6">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total Lunas</p>
                    <p class="text-2xl font-black text-slate-800">{{ $pembayaran->where('status','Lunas')->count() }} Transaksi</p>
                </div>
            </div>
            <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 flex items-center">
                <div class="w-16 h-16 rounded-3xl bg-red-50 text-red-400 flex items-center justify-center text-2xl shadow-inner">
                    <i class="fa-solid fa-clock-rotate-left"></i>
                </div>
                <div class="ml-6">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tunggakan SPP</p>
                    <p class="text-2xl font-black text-slate-800">{{ $tunggakan }} Bulan</p>
                </div>
            </div>
        </div>

        <!-- TOMBOL AKSI -->
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div class="inline-flex p-1.5 bg-slate-100 rounded-2xl w-full md:w-auto">
                <button type="button" @click="tab = 'spp'" :class="tab === 'spp' ? 'bg-white shadow-sm text-emerald-700' : 'text-slate-500'" class="flex-1 px-8 py-2.5 rounded-xl font-bold text-xs transition-all uppercase">SPP BULANAN</button>
                <button type="button" @click="tab = 'lain'" :class="tab === 'lain' ? 'bg-white shadow-sm text-emerald-700' : 'text-slate-500'" class="flex-1 px-8 py-2.5 rounded-xl font-bold text-xs transition-all ml-1 uppercase">IURAN LAIN</button>
            </div>

            <button type="button" 
                    @click="openModal = true; kategori = (tab === 'spp' ? 'SPP' : 'Lainnya')" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-10 py-3 rounded-2xl font-bold text-sm shadow-xl shadow-emerald-500/20 active:scale-95 transition-all w-full md:w-auto">
                <i class="fa-solid fa-plus-circle mr-2"></i> TAMBAH TAGIHAN / BAYAR
            </button>
        </div>

        <!-- TAB CONTENT: SPP -->
        <div x-show="tab === 'spp'" x-cloak class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm min-w-[750px]">
                    <thead class="bg-slate-50/80 text-slate-400 font-bold uppercase text-[10px] tracking-widest border-b">
                        <tr>
                            <th class="px-8 py-5">Periode</th>
                            <th class="px-6 py-5">Tgl Bayar</th>
                            <th class="px-6 py-5">Jumlah</th>
                            <th class="px-6 py-5">Status</th>
                            <th class="px-6 py-5 text-center">Bukti</th>
                            <th class="px-6 py-5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($spp_data as $row)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-5 font-bold text-slate-700 uppercase">{{ $row->bulan }} {{ $row->tahun }}</td>
                            <td class="px-6 py-5 text-slate-400 font-medium italic">{{ $row->tanggal_bayar ?? '—' }}</td>
                            <td class="px-6 py-5 font-black text-slate-800">Rp {{ number_format($row->jumlah, 0, ',', '.') }}</td>
                            <td class="px-6 py-5">
                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase {{ $row->status == 'Lunas' ? 'bg-emerald-50 text-emerald-600' : 'bg-red-50 text-red-600' }}">
                                    {{ $row->status }}
                                </span>
                            </td>
                            <td class="px-6 py-5 text-center">
                                @if($row->status == 'Lunas' && $row->bukti_bayar)
                                    <button type="button" @click="openBuktiModal = true; buktiUrl = '{{ asset('storage/bukti_bayar/' . $row->bukti_bayar) }}'" class="text-emerald-600 hover:scale-110 transition-transform">
                                        <i class="fa-solid fa-file-invoice text-xl"></i>
                                    </button>
                                @else
                                    <span class="text-slate-200">—</span>
                                @endif
                            </td>
                            <td class="px-6 py-5 text-center">
                                <div class="flex justify-center space-x-2">
                                    @if($row->status != 'Lunas')
                                        <button type="button" @click="openBayarModal = true; selectedId = {{ $row->id }}" class="bg-emerald-600 text-white px-5 py-1.5 rounded-lg text-[10px] font-black uppercase shadow-lg active:scale-95">Bayar</button>
                                    @else
                                        <form action="{{ route('pembayaran.update', $row->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="Belum Bayar">
                                            <input type="hidden" name="jumlah" value="{{ $row->jumlah }}">
                                            <button type="submit" class="p-2.5 bg-amber-50 text-amber-600 rounded-xl hover:bg-amber-600 hover:text-white transition shadow-sm"><i class="fa-solid fa-rotate-left"></i></button>
                                        </form>
                                    @endif
                                    <form action="{{ route('pembayaran.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Hapus permanen?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="p-2.5 bg-red-50 text-red-600 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- 5. TAB CONTENT: LAIN-LAIN -->
        <div x-show="tab === 'lain'" x-cloak class="bg-white rounded-[32px] shadow-sm border border-slate-200 p-8 min-h-[300px]">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($pembayaran->where('kategori', '!=', 'SPP') as $lain)
                <div class="bg-white border border-slate-100 p-6 rounded-[2rem] flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 hover:shadow-xl hover:shadow-emerald-900/5 transition-all shadow-sm group relative overflow-hidden">
                    
                    <!-- SISI KIRI: INFORMASI IURAN -->
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">{{ $lain->kategori }}</span>
                            @if($lain->status == 'Lunas' || $lain->status == 'lunas')
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                            @endif
                        </div>
                        <p class="font-black text-slate-800 text-xl uppercase tracking-tighter">
                            Rp {{ number_format($lain->jumlah, 0, ',', '.') }}
                        </p>
                        <p class="text-[11px] text-slate-400 font-medium mt-1 flex items-center">
                            <i class="fa-solid fa-quote-left mr-2 opacity-30 text-[8px]"></i>
                            {{ $lain->keterangan ?? 'Tanpa catatan tambahan' }}
                        </p>
                    </div>

                    <!-- SISI KANAN: STATUS & AKSI (DITATA RAPI) -->
                    <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-end border-t sm:border-0 pt-4 sm:pt-0">
                        
                        <!-- GROUP STATUS & LIHAT BUKTI -->
                        <div class="flex flex-col items-end gap-2">
                            @if($lain->status != 'Lunas')
                                <button type="button" 
                                        @click="openBayarModal = true; selectedId = {{ $lain->id }}" 
                                        class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-[10px] font-black uppercase shadow-lg shadow-emerald-500/20 active:scale-95 transition-all">
                                    BAYAR SEKARANG
                                </button>
                            @else
                                <div class="flex flex-col items-end gap-1.5">
                                    <!-- Badge Lunas yang lebih slim -->
                                    <div class="bg-emerald-50 text-emerald-600 px-4 py-1.5 rounded-full text-[10px] font-black uppercase border border-emerald-100 flex items-center shadow-sm">
                                        <i class="fa-solid fa-check-circle mr-1.5"></i> LUNAS
                                    </div>
                                    
                                    <!-- Tombol Lihat Bukti yang lebih elegan -->
                                    @if($lain->bukti_bayar)
                                    <button type="button" 
                                            @click="openBuktiModal = true; buktiUrl = '{{ asset('storage/bukti_bayar/' . $lain->bukti_bayar) }}'"
                                            class="flex items-center text-emerald-600 hover:text-emerald-800 transition-all group/btn">
                                        <i class="fa-solid fa-file-invoice text-xs mr-1.5 group-hover/btn:rotate-12 transition-transform"></i>
                                        <span class="text-[9px] font-bold uppercase tracking-widest border-b border-emerald-200 group-hover/btn:border-emerald-600">Lihat Bukti</span>
                                    </button>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- TOMBOL HAPUS (Diberi jarak dan background agar tegas) -->
                        <div class="pl-3 border-l border-slate-100">
                            <form action="{{ route('pembayaran.destroy', $lain->id) }}" method="POST" onsubmit="return confirm('Hapus data iuran ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="w-10 h-10 flex items-center justify-center bg-rose-50 text-rose-500 rounded-xl hover:bg-rose-500 hover:text-white transition-all shadow-sm active:scale-90">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- MODAL 6: INPUT PEMBAYARAN BARU -->
        <div x-show="openModal" x-transition class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/70 backdrop-blur-md" x-cloak>
            <div class="bg-white w-full max-w-lg rounded-[40px] overflow-hidden shadow-2xl" @click.away="openModal = false">
                <div class="bg-emerald-700 p-8 text-white text-center">
                    <h3 class="text-2xl font-bold tracking-tight italic">Input Pembayaran</h3>
                    <p class="text-xs opacity-70 mt-1 uppercase tracking-widest">SANTRI: {{ $santri->nama }}</p>
                </div>
                <form action="{{ route('pembayaran.store') }}" method="POST" class="p-8 space-y-5">
                    @csrf
                    <input type="hidden" name="santri_id" value="{{ $santri->id }}">
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Kategori Tagihan</label>
                        <select name="kategori" x-model="kategori" required class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 font-bold text-slate-700">
                            <option value="SPP">Khataman / Bulanan</option>
                            <option value="Pembangunan">Daftar Ulang / Gedung</option>                           
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <template x-if="kategori === 'SPP'">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Bulan</label>
                                <select name="bulan" class="w-full rounded-2xl border-slate-200 font-bold">
                                    @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                                        <option value="{{ $m }}">{{ $m }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black text-slate-400 uppercase mb-1">Tahun</label>
                                <input type="number" name="tahun" value="{{ date('Y') }}" class="w-full rounded-2xl border-slate-200 font-bold">
                            </div>
                        </div>
                    </template>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Jumlah Iuran (Rp)</label>
                        <input type="number" name="jumlah" required class="w-full rounded-2xl border-slate-200 font-black text-lg text-emerald-700" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase mb-1 ml-1">Status Pembayaran</label>
                        <select name="status" class="w-full rounded-2xl border-slate-200 font-bold">
                            <option value="Belum Bayar" class="text-red-500">Kirim Tagihan (Belum Lunas)</option>
                        </select>
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="openModal = false" class="flex-1 font-bold text-slate-400 uppercase text-[10px]">Batal</button>
                        <button type="submit" class="flex-[2] bg-emerald-600 text-white py-4 rounded-2xl font-black shadow-lg uppercase text-xs tracking-widest">Simpan Iuran</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL KONFIRMASI BAYAR & UPLOAD KUITANSI -->
        <div x-show="openBayarModal" x-transition class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-cloak>
            <div class="bg-white w-full max-w-md rounded-[40px] overflow-hidden shadow-2xl" @click.away="openBayarModal = false">
                <div class="bg-emerald-800 p-8 text-white text-center">
                    <div class="w-16 h-16 bg-white/10 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-white/20">
                        <i class="fa-solid fa-camera-retro text-2xl text-yellow-400"></i>
                    </div>
                    <h3 class="text-xl font-bold">Konfirmasi Pelunasan</h3>
                    <p class="text-xs opacity-70 mt-1 uppercase tracking-widest">Santri: {{ $santri->nama }}</p>
                </div>
                <form :action="'{{ url('/pembayaran-lunas') }}/' + selectedId" method="POST" enctype="multipart/form-data" class="p-8 space-y-6">
                    @csrf
                    @method('PUT')
                    <div x-data="{ preview: null }">
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Upload Bukti Pembayaran</label>
                        <div class="relative group">
                            <div class="w-full h-44 rounded-[2rem] bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-emerald-400">
                                <template x-if="!preview">
                                    <div class="text-center text-slate-300">
                                        <i class="fa-solid fa-image text-4xl mb-2"></i>
                                        <p class="text-[10px] font-bold uppercase">Klik Foto Kuitansi</p>
                                    </div>
                                </template>
                                <template x-if="preview">
                                    <img :src="preview" class="w-full h-full object-cover">
                                </template>
                            </div>
                            <input type="file" name="bukti_bayar" required class="absolute inset-0 opacity-0 cursor-pointer"
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { preview = e.target.result; }; reader.readAsDataURL(file); }">
                        </div>
                        <p class="text-[9px] text-rose-500 mt-3 text-center font-bold italic">* Maks. 2MB</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" @click="openBayarModal = false" class="flex-1 py-4 font-bold text-slate-400 uppercase text-xs">Batal</button>
                        <button type="submit" class="flex-[2] bg-emerald-600 text-white py-4 rounded-2xl font-black shadow-lg uppercase text-xs active:scale-95 transition-all">Simpan & Lunaskan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- MODAL PREVIEW KUITANSI -->
        <div x-show="openBuktiModal" x-transition class="fixed inset-0 z-[1001] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm" x-cloak>
            <div class="bg-white w-full max-w-lg rounded-[40px] overflow-hidden shadow-2xl" @click.away="openBuktiModal = false">
                <div class="bg-slate-800 p-6 text-white flex justify-between items-center">
                    <h3 class="font-bold uppercase text-xs tracking-widest">Bukti Pembayaran Sah</h3>
                    <button @click="openBuktiModal = false" class="text-white/50 hover:text-white"><i class="fa-solid fa-xmark text-xl"></i></button>
                </div>
                <div class="p-4 bg-slate-100 flex justify-center">
                    <img :src="buktiUrl" class="max-w-full h-auto rounded-3xl shadow-lg border-4 border-white" alt="Kuitansi">
                </div>
                <div class="p-6 text-center">
                    <a :href="buktiUrl" download class="inline-flex items-center text-emerald-600 font-bold text-xs uppercase tracking-widest hover:underline">
                        <i class="fa-solid fa-download mr-2"></i> Simpan Gambar
                    </a>
                </div>
            </div>
        </div>

    </div> <!-- TUTUP X-DATA UTAMA -->
</x-app-layout>