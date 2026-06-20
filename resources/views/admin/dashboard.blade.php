<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        <!-- SECTION 1: WELCOME HERO -->
        <div class="relative overflow-hidden bg-emerald-800 rounded-[40px] p-8 md:p-12 mb-10 shadow-2xl shadow-emerald-900/20">
            <!-- Dekorasi Ornamen Background -->
            <div class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 bg-emerald-700/50 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-48 h-48 bg-yellow-500/20 rounded-full blur-2xl"></div>

            <div class="relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="text-center md:text-left text-white">
                    <h2 class="text-3xl md:text-4xl font-black leading-tight">Assalamu'alaikum, <br>Admin <span class="text-yellow-400">Al-Misykah</span></h2>
                    <p class="mt-4 text-emerald-100 font-medium max-w-md opacity-80 leading-relaxed">
                        Pantau aktivitas harian santri, keuangan, dan kedisiplinan dalam satu panel kendali terpadu hari ini.
                    </p>
                    <div class="mt-8 flex flex-wrap justify-center md:justify-start gap-3 text-[10px] font-bold uppercase tracking-widest">
                        <span class="px-4 py-2 bg-emerald-700/50 border border-emerald-600 rounded-full"><i class="fa-solid fa-clock mr-2 text-yellow-400"></i>{{ now()->format('H:i') }} WIB</span>
                        <span class="px-4 py-2 bg-emerald-700/50 border border-emerald-600 rounded-full"><i class="fa-solid fa-cloud-moon mr-2 text-yellow-400"></i>Sesi Malam</span>
                    </div>
                </div>
                <div class="hidden lg:block">
                     <!-- Ilustrasi Ikon Besar -->
                     <i class="fa-solid fa-shield-halved text-[120px] text-white/10 rotate-12"></i>
                </div>
            </div>
        </div>
   
        <!-- DUA KOLOM REKAP UTAMA -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mt-10">
            
            <!-- KOLOM 1: REKAP ALFA HARI INI -->
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-rose-50/30">
                    <h3 class="text-sm font-black text-rose-700 uppercase tracking-widest flex items-center">
                        <i class="fa-solid fa-user-xmark mr-3"></i> Alfa Hari Ini
                    </h3>
                    <span class="bg-rose-100 text-rose-700 px-3 py-1 rounded-xl text-[10px] font-bold">
                        {{ $rekapAlfa->count() }} Santri
                    </span>
                </div>
                
                <div class="max-h-[400px] overflow-y-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-50">
                            @forelse($rekapAlfa as $alfa)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-6">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-sm font-bold text-slate-800">{{ $alfa->santri?->nama }}</p>
                                            <div class="flex items-center gap-2 mt-1">
                                                <!-- Badge Kategori (Warna dinamis) -->
                                                <span class="px-2 py-0.5 rounded text-[9px] font-black uppercase tracking-tighter 
                                                    {{ $alfa->kategori_absen == 'Sholat' ? 'bg-blue-100 text-blue-600' : 
                                                    ($alfa->kategori_absen == 'Ngaji' ? 'bg-emerald-100 text-emerald-600' : 'bg-purple-100 text-purple-600') }}">
                                                    {{ $alfa->kategori_absen }}
                                                </span>
                                                
                                                <span class="text-[10px] text-slate-400 font-bold uppercase">
                                                    Sesi: <span class="text-slate-600">{{ $alfa->sesi_absen }}</span>
                                                </span>
                                            </div>
                                        </div>
                                        
                                        <div class="text-right">
                                            <span class="bg-rose-500 text-white px-3 py-1 rounded-lg text-[9px] font-black italic shadow-sm shadow-rose-200">ALFA</span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="p-20 text-center text-slate-400 font-medium italic text-sm">
                                    Alhamdulillah, hari ini semua santri hadir sholat.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- KOLOM 2: REKAP BELUM BAYAR SPP -->
            <div class="bg-white rounded-[40px] shadow-sm border border-slate-200 overflow-hidden">
                <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-amber-50/30">
                    <h3 class="text-sm font-black text-amber-700 uppercase tracking-widest flex items-center">
                        <i class="fa-solid fa-hand-holding-dollar mr-3"></i> Tunggakan SPP
                    </h3>
                    <a href="{{ route('pembayaran.index') }}" class="text-[10px] font-bold text-emerald-600 hover:underline">Kelola Keuangan</a>
                </div>

                <div class="max-h-[400px] overflow-y-auto">
                    <table class="w-full text-left">
                        <tbody class="divide-y divide-slate-50">
                            @forelse($rekapTunggakan as $tagihan)
                            <tr class="hover:bg-slate-50 transition">
                                <td class="p-6">
                                    <p class="text-sm font-bold text-slate-800">{{ $tagihan->santri?->nama ?? 'Santri Tidak Ditemukan' }}</p>
                                    <p class="text-[10px] text-amber-600 font-bold uppercase">{{ $tagihan->total_bulan }} Bulan Belum Bayar</p>
                                </td>
                                <td class="p-6 text-right">
                                    <p class="text-sm font-black text-slate-700 tracking-tighter">
                                        Rp {{ number_format($tagihan->total_nominal, 0, ',', '.') }}
                                    </p>
                                    
                                    <!-- Link Actionable ke Detail Pembayaran Santri -->
                                    <a href="{{ route('pembayaran.show', $tagihan->santri_id) }}" 
                                    class="inline-flex items-center mt-2 px-3 py-1 bg-emerald-50 text-emerald-600 rounded-lg text-[9px] font-black uppercase tracking-widest hover:bg-emerald-600 hover:text-white transition-all shadow-sm border border-emerald-100">
                                        <i class="fa-solid fa-file-invoice-dollar mr-1"></i>
                                        Buka Tagihan
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td class="p-20 text-center text-slate-400 font-medium italic text-sm">
                                    Luar biasa, semua SPP santri sudah lunas!
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        
    </div>
</x-app-layout>