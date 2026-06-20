<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4" x-data="absensiManager()">
        
        <!-- HEADER -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Presensi Santri</h1>
                <p class="text-slate-500 text-sm">Pilih kategori kegiatan untuk memulai absensi.</p>
            </div>
            
            <!-- Tombol Kirim Utama -->
            <button @click="submitAll()" 
                    class="bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-500/30 transition-all transform active:scale-95 flex items-center justify-center">
                <i class="fa-solid fa-paper-plane mr-2"></i>
                Simpan & Kirim Absensi
            </button>
        </div>

        <!-- FILTER MODERN -->
        <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-200 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4 items-end text-sm">
                
                <div class="lg:col-span-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Tanggal</label>
                    <input type="date" id="tanggal" value="{{ $tanggal }}" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 text-xs font-semibold">
                </div>

                <div class="lg:col-span-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kategori</label>
                    <select id="jenis" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 text-xs font-bold text-emerald-700" onchange="loadWaktu()">
                        <option value="sholat" {{ $jenis=='sholat'?'selected':'' }}>Sholat</option>
                        <option value="muhadhoroh" {{ $jenis=='muhadhoroh'?'selected':'' }}>Muhadhoroh</option>
                        <option value="ngaji" {{ $jenis=='ngaji'?'selected':'' }}>Ngaji</option>
                    </select>
                </div>

                 <div class="lg:col-span-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Sesi Waktu</label>
                    <select id="waktu" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 text-xs font-semibold"></select>
                </div>

                <div class="lg:col-span-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kelas</label>
                    <select id="kelas" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 text-xs font-semibold">
                        <option value="">Semua Kelas</option>
                        @foreach($listKelas as $k)
                            <option value="{{ $k }}" {{ $kelas==$k?'selected':'' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="lg:col-span-1">
                    <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Kamar</label>
                    <select id="kamar" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 text-xs font-semibold">
                        <option value="">Semua Kamar</option>
                        @foreach($listKamar as $k)
                            <option value="{{ $k }}" {{ $kamar==$k?'selected':'' }}>{{ $k }}</option>
                        @endforeach
                    </select>
                </div>          
                
               
                <div class="lg:col-span-1">
                    <button onclick="reloadPage()" class="w-full bg-slate-800 text-white py-2.5 rounded-xl font-bold hover:bg-slate-900 transition flex items-center justify-center">
                        <i class="fa-solid fa-magnifying-glass mr-2"></i> Tampilkan
                    </button>
                </div>
            </div>
        </div>

        <!-- INFO BAR -->
        <div class="flex items-center space-x-4 mb-6 px-4">
             <span class="text-xs font-bold text-slate-400">STATUS DEFAULT: </span>
             <span class="bg-emerald-100 text-emerald-700 px-3 py-1 rounded-full text-[10px] font-bold">AUTO HADIR</span>
        </div>

        <!-- LIST SANTRI GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($santri as $s)
            @php 
                // Jika belum ada di DB, default ke 'hadir'
                $st = $absensi[$s->id]->status ?? 'hadir'; 
            @endphp

            <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-200 hover:border-emerald-300 transition-all relative overflow-hidden group">
                <!-- Indikator Status -->
                <div class="absolute top-0 left-0 w-2 h-full transition-colors"
                     :class="dataAbsensi[{{ $s->id }}] == 'hadir' ? 'bg-emerald-500' : 
                            (dataAbsensi[{{ $s->id }}] == 'izin' ? 'bg-yellow-500' : 
                            (dataAbsensi[{{ $s->id }}] == 'sakit' ? 'bg-blue-500' : 'bg-red-500'))">
                </div>

                <div class="flex items-center mb-4 ml-2">
                    <div class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 font-bold group-hover:bg-emerald-50 group-hover:text-emerald-600 transition-colors">
                        {{ substr($s->nama, 0, 1) }}
                    </div>
                    <div class="ml-3">
                        <h3 class="font-bold text-slate-800 leading-tight">{{ $s->nama }}</h3>
                        <p class="text-[10px] text-slate-400 font-medium uppercase tracking-tight">{{ $s->kelas }} • {{ $s->kamar }}</p>
                    </div>
                </div>

                <!-- Tombol Status Profesional -->
                <div class="grid grid-cols-4 gap-2 ml-2">
                    <button @click="setStatus({{ $s->id }}, 'hadir')" 
                            :class="dataAbsensi[{{ $s->id }}] == 'hadir' ? 'bg-emerald-600 text-white' : 'bg-slate-50 text-slate-500 hover:bg-emerald-50'"
                            class="py-2 rounded-xl text-[10px] font-bold transition-all border border-transparent shadow-sm">HADIR</button>
                    
                    <button @click="setStatus({{ $s->id }}, 'izin')" 
                            :class="dataAbsensi[{{ $s->id }}] == 'izin' ? 'bg-yellow-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-yellow-50'"
                            class="py-2 rounded-xl text-[10px] font-bold transition-all border border-transparent shadow-sm">IZIN</button>

                    <button @click="setStatus({{ $s->id }}, 'sakit')" 
                            :class="dataAbsensi[{{ $s->id }}] == 'sakit' ? 'bg-blue-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-blue-50'"
                            class="py-2 rounded-xl text-[10px] font-bold transition-all border border-transparent shadow-sm">SAKIT</button>

                    <button @click="setStatus({{ $s->id }}, 'alfa')" 
                            :class="dataAbsensi[{{ $s->id }}] == 'alfa' ? 'bg-red-500 text-white' : 'bg-slate-50 text-slate-500 hover:bg-red-50'"
                            class="py-2 rounded-xl text-[10px] font-bold transition-all border border-transparent shadow-sm">ALFA</button>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Tombol Kirim Bawah (Sticky) -->
        <div class="fixed bottom-8 right-8 lg:hidden">
            <button @click="submitAll()" class="bg-emerald-600 text-white p-4 rounded-full shadow-2xl active:scale-95">
                <i class="fa-solid fa-paper-plane">Simpan</i>
            </button>
        </div>
    </div>

    <script>
        function absensiManager() {
            return {
                // Initial data: Ambil status dari DB, jika kosong set ke 'hadir'
                dataAbsensi: {
                    @foreach($santri as $s)
                        {{ $s->id }}: '{{ $absensi[$s->id]->status ?? "hadir" }}',
                    @endforeach
                },

                setStatus(id, status) {
                    this.dataAbsensi[id] = status;
                },

                submitAll() {
                // Tombol ini akan mengirim semua status (baik yang baru dirubah maupun yang default Hadir)
                fetch("{{ route('absensi.bulk_store') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        data: this.dataAbsensi, // Objek [id: status]
                        tanggal: document.getElementById('tanggal').value,
                        jenis: document.getElementById('jenis').value,
                        waktu: document.getElementById('waktu').value
                    })
                })
                .then(res => res.json())
                .then(res => {
                    if(res.success) {
                        alert('Sukses: ' + res.message);
                        window.location.reload();
                    }
                });
            }
            }
        }

        function reloadPage() {
            let t = document.getElementById('tanggal').value;
            let j = document.getElementById('jenis').value;
            let w = document.getElementById('waktu').value;
            let kls = document.getElementById('kelas').value;
            let kmr = document.getElementById('kamar').value;
            window.location.href = `/absensi?tanggal=${t}&jenis=${j}&waktu=${w}&kelas=${kls}&kamar=${kmr}`;
        }

        function loadWaktu() {
            let jenis = document.getElementById('jenis').value;
            let waktu = document.getElementById('waktu');
            let currentWaktu = "{{ $waktu }}"; // Mengambil pilihan sebelumnya dari Laravel

            waktu.innerHTML = '';
            let options = [];

            if (jenis == 'sholat') {
                options = [
                    {val: 'subuh', text: 'Subuh'},
                    {val: 'dzuhur', text: 'Dzuhur'},
                    {val: 'ashar', text: 'Ashar'},
                    {val: 'maghrib', text: 'Maghrib'},
                    {val: 'isya', text: 'Isya'}
                ];
            } else if (jenis == 'muhadhoroh') {
                options = [
                    {val: 'sore', text: 'Sore (Setelah Ashar)'},
                    {val: 'malam', text: 'Malam (Setelah Isya)'}
                ];
            } else {
                options = [
                    {val: 'pagi', text: 'Pagi (Setelah Subuh)'},
                    {val: 'malam', text: 'Malam (Setelah Maghrib)'}
                ];
            }

            options.forEach(opt => {
                let selected = (currentWaktu == opt.val) ? 'selected' : '';
                waktu.innerHTML += `<option value="${opt.val}" ${selected}>${opt.text}</option>`;
            });
        }

        // Jalankan loadWaktu saat pertama kali halaman dibuka
        document.addEventListener('DOMContentLoaded', loadWaktu);
    </script>

    <style>
        /* Menghilangkan scrollbar default untuk tampilan lebih clean */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }
    </style>
</x-app-layout>