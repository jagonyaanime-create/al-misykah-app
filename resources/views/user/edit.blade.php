<x-app-layout>
<div class="max-w-3xl mx-auto py-8 px-4">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-black text-slate-800 tracking-tight">Edit Akun User</h1>
            <p class="text-slate-500 mt-1 font-medium text-sm">Mengubah akses untuk: <span class="text-emerald-600 font-bold">{{ $user->email }}</span></p>
        </div>
        <div class="w-12 h-12 bg-emerald-50 text-emerald-600 rounded-2xl flex items-center justify-center shadow-inner">
            <i class="fa-solid fa-user-gear text-xl"></i>
        </div>
    </div>

    <!-- Form Container -->
    <div class="bg-white rounded-[40px] shadow-sm border border-slate-200 overflow-hidden">
        <form action="{{ route('users.update', $user->id) }}" method="POST" class="p-10 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nama -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required 
                           class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 font-bold text-slate-700">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                           class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 font-bold text-slate-700">
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Role / Akses</label>
                    <select name="role" required class="w-full rounded-2xl border-slate-200 focus:ring-emerald-500 font-black text-emerald-700">
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>ADMINISTRATOR</option>
                        <option value="wali" {{ $user->role == 'wali' ? 'selected' : '' }}>WALI SANTRI</option>
                    </select>
                </div>

                <!-- Password (Ganti warna khusus) -->
                <div class="md:col-span-2 bg-slate-50 p-6 rounded-[28px] border border-slate-100">
                    <div class="flex items-center space-x-2 mb-3">
                        <i class="fa-solid fa-lock text-amber-500 text-xs"></i>
                        <label class="block text-xs font-black text-slate-500 uppercase tracking-widest">Ganti Password</label>
                    </div>
                    <input type="password" name="password" placeholder="Kosongkan jika tidak ingin ganti password" 
                           class="w-full rounded-2xl border-slate-200 focus:ring-amber-500 text-sm italic">
                    <p class="text-[10px] text-slate-400 mt-2 font-medium">*Minimal 6 karakter jika ingin mengganti.</p>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-between pt-6">
                <a href="{{ route('users.index') }}" class="text-slate-400 font-bold hover:text-slate-800 transition uppercase text-xs tracking-widest">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Batal
                </a>
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white px-10 py-4 rounded-[22px] font-black shadow-lg shadow-emerald-500/30 transition-all active:scale-95 uppercase tracking-widest text-xs">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>