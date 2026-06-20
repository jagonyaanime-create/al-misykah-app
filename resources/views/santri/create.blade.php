<x-app-layout>

<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Tambah Santri Baru</h1>
        <p class="text-slate-500 mt-1">Lengkapi formulir di bawah untuk mendaftarkan santri ke sistem Al-Misykah.</p>
    </div>

    <form action="{{ route('santri.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- SISI KIRI: Upload Foto & Status -->
            <div class="space-y-6">
                <div class="bg-white p-6 rounded-[32px] shadow-sm border border-slate-200">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Foto & Status</h3>
                    
                    <!-- Input Foto -->
                    <div x-data="{photoPreview: null}" class="mb-6">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Foto Profil</label>
                        <div class="relative group">
                            <div class="w-full h-48 rounded-2xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden transition-all group-hover:border-emerald-400">
                                <template x-if="!photoPreview">
                                    <div class="text-center text-slate-400">
                                        <i class="fa-solid fa-camera text-3xl mb-2"></i>
                                        <p class="text-xs">Klik untuk pilih foto</p>
                                    </div>
                                </template>
                                <template x-if="photoPreview">
                                    <img :src="photoPreview" class="w-full h-full object-cover">
                                </template>
                            </div>
                            <input type="file" name="foto" class="absolute inset-0 opacity-0 cursor-pointer" 
                                @change="const file = $event.target.files[0]; if (file) { const reader = new FileReader(); reader.onload = (e) => { photoPreview = e.target.result; }; reader.readAsDataURL(file); }">
                        </div>
                    </div>

                    <!-- Input Status -->
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Status Keaktifan</label>
                        <select name="status" class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 text-sm font-medium">
                            <option value="aktif">Aktif</option>
                            <option value="alumni">Alumni</option>
                            <option value="berhenti">Berhenti</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- SISI KANAN: Detail Identitas & Akademik -->
            <div class="lg:col-span-2 space-y-6">
                
                <!-- CARD 1: Identitas Diri -->
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-200">
                    <div class="flex items-center space-x-3 mb-8 border-b border-slate-50 pb-4">
                        <div class="p-2 bg-emerald-50 text-emerald-600 rounded-lg"><i class="fa-solid fa-user"></i></div>
                        <h2 class="text-lg font-bold text-slate-800">Identitas Diri</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap Santri</label>
                            <input type="text" name="nama" required class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Masukkan nama sesuai ijazah...">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">NIS (Nomor Induk)</label>
                            <input type="text" name="nis" required class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: 12345678">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Jenis Kelamin</label>
                            <select name="jenis_kelamin" required class="w-full rounded-xl border-slate-200 focus:ring-emerald-500">
                                <option value="">Pilih Gender</option>
                                <option value="Laki-Laki">Laki-Laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" required class="w-full rounded-xl border-slate-200" placeholder="Contoh: Grobogan">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" required class="w-full rounded-xl border-slate-200 focus:ring-emerald-500">
                        </div>
                    </div>
                </div>

                <!-- CARD 2: Pendidikan & Kamar -->
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-200">
                    <div class="flex items-center space-x-3 mb-8 border-b border-slate-50 pb-4">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-lg"><i class="fa-solid fa-graduation-cap"></i></div>
                        <h2 class="text-lg font-bold text-slate-800">Data Akademik & Asrama</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas Sekolah Formal</label>
                            <input type="text" name="kelas" required class="w-full rounded-xl border-slate-200" placeholder="Contoh: 3 Tsanawiyah">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kelas Muhadhoroh</label>
                            <input type="text" name="kelas_muhadhoroh" class="w-full rounded-xl border-slate-200" placeholder="Contoh: 3 Muhadhoroh">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Kamar / Asrama</label>
                            <input type="text" name="kamar" required class="w-full rounded-xl border-slate-200" placeholder="Contoh: Abu Bakar Ash-Shidiq">
                        </div>
                    </div>
                </div>

                <!-- CARD 3: Kontak & Relasi Wali -->
                <div class="bg-white p-8 rounded-[32px] shadow-sm border border-slate-200">
                    <div class="flex items-center space-x-3 mb-8 border-b border-slate-50 pb-4">
                        <div class="p-2 bg-orange-50 text-orange-600 rounded-lg"><i class="fa-solid fa-link"></i></div>
                        <h2 class="text-lg font-bold text-slate-800">Informasi Wali Santri</h2>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-emerald-700 mb-2 p-3 bg-emerald-50 rounded-xl">
                                <i class="fa-solid fa-circle-info mr-2"></i> Hubungkan ke Akun Login Wali (Untuk akses monitoring)
                            </label>
                            <select name="user_id" required class="w-full rounded-xl border-slate-200 focus:ring-emerald-500 font-bold text-slate-700">
                                <option value="">-- Pilih User Akun Wali --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nama Ayah / Wali</label>
                            <input type="text" name="wali" required class="w-full rounded-xl border-slate-200" placeholder="Nama Bapak/Wali">
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Nomor WhatsApp Wali</label>
                            <input type="text" name="no_hp" required class="w-full rounded-xl border-slate-200" placeholder="08xxxxxxxxxx">
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-slate-700 mb-1">Alamat Lengkap Rumah</label>
                            <textarea name="alamat" rows="3" required class="w-full rounded-xl border-slate-200" placeholder="Tuliskan alamat lengkap..."></textarea>
                        </div>
                    </div>
                </div>

                @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6 rounded-r-xl">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <i class="fa-solid fa-circle-xmark text-red-500"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-bold text-red-800">Terjadi Kesalahan Input:</h3>
                            <ul class="mt-1 text-xs text-red-700 list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="flex items-center justify-between pt-6 border-t mt-8">
                <!-- Tombol Kembali -->
                <a href="{{ route('santri.index') }}" class="flex items-center text-slate-500 hover:text-slate-800 font-semibold transition">
                    <i class="fa-solid fa-arrow-left mr-2"></i>
                    Kembali ke Data Santri
                </a>

                <div class="flex space-x-3">
                    <button type="reset" class="px-6 py-3 rounded-2xl font-bold text-slate-400 hover:bg-slate-100 transition">Reset</button>
                    <button type="submit" class="bg-emerald-600 text-white px-10 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-500/20 hover:bg-emerald-700 transition active:scale-95">
                        Simpan Data Santri
                    </button>
                </div>
            </div>

            </div>
        </div>
    </form>
</div>

</x-app-layout>