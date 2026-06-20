<x-app-layout>

<div class="max-w-6xl mx-auto py-6 px-4" x-data="{ detailModal: false, selectedSantri: {} }">
    
    <!-- Header & Tombol Tambah (Diperbaiki agar rapi di HP) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Data Santri</h1>
            <p class="text-slate-500 text-sm">Total: {{ $santri->count() }} Santri Terdaftar</p>
        </div>
        <a href="{{ route('santri.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg shadow-emerald-500/20 transition-all flex items-center shrink-0">
            <i class="fa-solid fa-plus mr-2"></i> Tambah Santri
        </a>
    </div>

    <!-- TABEL (Ditambah overflow-x-auto agar bisa digeser di HP) -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left min-w-[500px]">
                <thead class="bg-slate-50 border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Nama Santri</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($santri as $s)
                    <tr class="hover:bg-slate-50/50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold mr-3 shrink-0">
                                    {{ substr($s->nama, 0, 1) }}
                                </div>
                                <div class="overflow-hidden text-ellipsis">
                                    <span class="font-semibold text-slate-700 block truncate">{{ $s->nama }}</span>
                                    <!-- Opsional: Info tambahan kecil buat mobile -->
                                    <span class="md:hidden text-[10px] text-slate-400 font-bold uppercase">{{ $s->kelas }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <!-- whitespace-nowrap agar tombol tidak turun ke bawah -->
                            <div class="flex justify-end space-x-2 whitespace-nowrap">
                                <!-- Tombol Detail -->
                                <button @click="detailModal = true; selectedSantri = {{ json_encode($s) }}" 
                                        class="p-2 px-3 sm:px-4 bg-emerald-50 text-emerald-600 rounded-lg text-xs font-bold hover:bg-emerald-600 hover:text-white transition">
                                    <i class="fa-solid fa-eye md:mr-1"></i> <span class="hidden md:inline">Detail</span>
                                </button>
                                
                                <!-- Tombol Edit -->
                                <a href="{{ route('santri.edit', $s->id) }}" class="p-2 px-3 sm:px-4 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition">
                                    <i class="fa-solid fa-pen-to-square md:mr-1"></i> <span class="hidden md:inline">Edit</span>
                                </a>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('santri.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus?')" class="inline">
                                    @csrf @method('DELETE')
                                    <button class="p-2 px-3 bg-red-50 text-red-600 rounded-lg text-xs font-bold hover:bg-red-600 hover:text-white transition">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL DETAIL (Responsif: Max height dan Scroll) -->
    <div x-show="detailModal" 
         class="fixed inset-0 z-[99] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-cloak>
        
        <div class="bg-white w-full max-w-2xl max-h-[90vh] rounded-[32px] overflow-hidden shadow-2xl flex flex-col" @click.away="detailModal = false">
            <!-- Header Modal -->
            <div class="bg-emerald-700 p-6 text-white flex justify-between items-center shrink-0">
                <h3 class="text-xl font-bold">Detail Profil Santri</h3>
                <button @click="detailModal = false" class="hover:bg-white/20 p-2 rounded-full transition">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Isi Detail (Bisa scroll jika hpnya kecil/pendek) -->
            <div class="p-8 overflow-y-auto">
                <div class="flex flex-col sm:flex-row items-center sm:items-start text-center sm:text-left space-y-4 sm:space-y-0 sm:space-x-6 mb-8 border-b pb-6 text-slate-800">
                    <div class="w-24 h-24 bg-emerald-100 rounded-3xl flex items-center justify-center text-3xl font-bold text-emerald-700 border-2 border-emerald-200 shrink-0 uppercase">
                         <span x-text="selectedSantri.nama ? selectedSantri.nama.substring(0,1) : ''"></span>
                    </div>
                    <div class="overflow-hidden w-full">
                        <h2 class="text-2xl font-bold uppercase tracking-tight truncate" x-text="selectedSantri.nama"></h2>
                        <p class="text-emerald-600 font-bold" x-text="'NIS: ' + selectedSantri.nis"></p>
                    </div>
                </div>

                <!-- Grid Data Detail -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-10 text-sm text-left">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Jenis Kelamin</p>
                        <p class="font-bold text-slate-700" x-text="selectedSantri.jenis_kelamin"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelas Sekolah</p>
                        <p class="font-bold text-slate-700" x-text="selectedSantri.kelas"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tempat, Tgl Lahir</p>
                        <p class="font-bold text-slate-700" x-text="selectedSantri.tempat_lahir + ', ' + selectedSantri.tanggal_lahir"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kelas Muhadhoroh</p>
                        <p class="font-bold text-slate-700" x-text="selectedSantri.kelas_muhadhoroh"></p>
                    </div>                    
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Wali Santri</p>
                        <p class="font-bold text-slate-700" x-text="selectedSantri.wali"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Kamar / Asrama</p>
                        <p class="font-bold text-slate-700 uppercase" x-text="selectedSantri.kamar"></p>
                    </div>                    
                    <div class="col-span-1 sm:col-span-2">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Alamat Lengkap</p>
                        <p class="font-bold text-slate-700" x-text="selectedSantri.alamat"></p>
                    </div>
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">No. HP Wali</p>
                        <p class="font-bold text-emerald-600 text-lg" x-text="selectedSantri.no_hp"></p>
                    </div>
                </div>
            </div>

            <!-- Footer Modal -->
            <div class="p-6 bg-slate-50 border-t flex justify-end shrink-0">
                <button @click="detailModal = false" class="w-full sm:w-auto px-8 py-2.5 bg-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-300 transition">Tutup</button>
            </div>
        </div>
    </div>
</div>

</x-app-layout>