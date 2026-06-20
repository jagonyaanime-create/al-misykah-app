<x-app-layout>
    <!-- DIV UTAMA (WAJIB ADA X-DATA DI SINI) -->
    <div class="max-w-7xl mx-auto py-8 px-4" x-data="{ openSpp: false, openMasal: false }">
        
        <!-- HEADER & TOMBOL SAKTI -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-3xl font-black text-slate-800 tracking-tight">Manajemen Pembayaran</h1>
                <p class="text-slate-500 text-sm">Gunakan fitur masal untuk efisiensi waktu input data.</p>
            </div>
            
            <div class="flex flex-wrap gap-3">
                <!-- Tombol Sakti 1: SPP -->
                <button @click="openSpp = true" type="button" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-blue-500/30 transition-all active:scale-95 flex items-center">
                    <i class="fa-solid fa-calendar-plus mr-2 text-base"></i> TERBITKAN SPP MASAL
                </button>

                <!-- Tombol Sakti 2: Iuran Global -->
                <button @click="openMasal = true" type="button" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold text-xs shadow-lg shadow-emerald-500/30 transition-all active:scale-95 flex items-center">
                    <i class="fa-solid fa-bullhorn mr-2 text-base"></i> INPUT IURAN MASAL
                </button>
            </div>
        </div>

        <!-- SEARCH & FILTER BAR -->
        <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-slate-200 mb-8 flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[250px] relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" placeholder="Cari nama santri..." class="w-full pl-11 pr-4 py-3 bg-slate-50 border-slate-200 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 transition-all font-medium">
            </div>
            <select class="rounded-2xl border-slate-200 bg-slate-50 text-sm font-bold px-6 py-3 text-slate-600">
                <option>Semua Kelas</option>
            </select>
            <button class="bg-slate-800 text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest hover:bg-slate-900 transition-all">Filter</button>
        </div>

        <!-- DAFTAR KARTU SANTRI -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($santri as $s)
            <div class="bg-white rounded-[35px] p-6 shadow-sm border border-slate-200 hover:border-emerald-300 transition-all group relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-emerald-50 rounded-full -mr-10 -mt-10 group-hover:bg-emerald-100 transition-colors"></div>
                
                <div class="flex items-center mb-6 relative">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-black shadow-inner">
                        {{ substr($s->nama, 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <h3 class="font-bold text-slate-800 group-hover:text-emerald-700 transition-colors leading-tight text-lg">{{ $s->nama }}</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">{{ $s->kelas }} • {{ $s->kamar }}</p>
                    </div>
                </div>

                <a href="{{ route('pembayaran.show', $s->id) }}" class="block w-full text-center bg-emerald-600 hover:bg-emerald-700 text-white py-4 rounded-[20px] font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-500/20 transition-all transform active:scale-95">
                    Detail & Input Bayar
                </a>
            </div>
            @endforeach
        </div>

        <!-- ==========================================
             MODAL 1: TERBITKAN SPP MASAL
        =========================================== -->
        <div x-show="openSpp" x-cloak class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition>
            <div class="bg-white w-full max-w-md rounded-[40px] overflow-hidden shadow-2xl" @click.away="openSpp = false">
                <div class="bg-blue-600 p-8 text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-lg">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <h3 class="text-2xl font-bold">Terbitkan Tagihan SPP</h3>
                    <p class="text-xs opacity-70 mt-2">Semua santri yang aktif akan mendapatkan tagihan "Belum Bayar" untuk periode yang dipilih.</p>
                </div>
                <form action="{{ route('pembayaran.generate_spp') }}" method="POST" class="p-8 space-y-4">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Bulan</label>
                            <select name="bulan" required class="w-full rounded-2xl border-slate-200 font-bold text-slate-700 focus:ring-blue-500">
                                @foreach(['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'] as $m)
                                    <option value="{{ $m }}">{{ $m }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Tahun</label>
                            <input type="number" name="tahun" value="{{ date('Y') }}" required class="w-full rounded-2xl border-slate-200 font-bold text-slate-700">
                        </div>
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Nominal (Rp)</label>
                        <input type="number" name="jumlah" value="420000" required class="w-full rounded-2xl border-slate-200 font-bold text-blue-600">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="openSpp = false" class="flex-1 py-4 font-bold text-slate-400 uppercase text-xs tracking-widest">Batal</button>
                        <button type="submit" class="flex-[2] bg-blue-600 text-white py-4 rounded-[20px] font-black shadow-lg shadow-blue-500/30 uppercase tracking-widest text-xs active:scale-95 transition-all">Terbitkan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ==========================================
             MODAL 2: INPUT IURAN MASAL (LAIN-LAIN)
        =========================================== -->
        <div x-show="openMasal" x-cloak class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm" x-transition>
            <div class="bg-white w-full max-w-md rounded-[40px] overflow-hidden shadow-2xl" @click.away="openMasal = false">
                <div class="bg-emerald-700 p-8 text-white text-center">
                    <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl shadow-lg">
                        <i class="fa-solid fa-bullhorn"></i>
                    </div>
                    <h3 class="text-2xl font-bold">Input Tagihan Global</h3>
                    <p class="text-xs opacity-70 mt-2">Gunakan ini untuk iuran satu kali seperti Gedung, Khataman, atau Seragam ke seluruh santri.</p>
                </div>
                <form action="{{ route('pembayaran.tagihan_masal') }}" method="POST" class="p-8 space-y-4">
                    @csrf
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Nama Tagihan (Kategori)</label>
                        <input type="text" name="kategori" required class="w-full rounded-2xl border-slate-200 font-bold" placeholder="Contoh: Uang Gedung 2026">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Nominal (Rp)</label>
                        <input type="number" name="jumlah" required class="w-full rounded-2xl border-slate-200 font-bold text-emerald-700">
                    </div>
                    <div>
                        <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 ml-1">Keterangan Singkat</label>
                        <input type="text" name="keterangan" class="w-full rounded-2xl border-slate-200" placeholder="Contoh: Wajib bagi santri baru">
                    </div>
                    <div class="flex gap-3 pt-4">
                        <button type="button" @click="openMasal = false" class="flex-1 py-4 font-bold text-slate-400 uppercase text-xs">Batal</button>
                        <button type="submit" class="flex-[2] bg-emerald-600 text-white py-4 rounded-[20px] font-black shadow-lg shadow-emerald-500/30 uppercase tracking-widest text-xs active:scale-95 transition-all">Simpan Tagihan</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-app-layout>