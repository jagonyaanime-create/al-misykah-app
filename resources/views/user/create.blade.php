<x-app-layout>

<div class="max-w-2xl mx-auto py-8">
    <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden">
        <div class="bg-emerald-700 p-8 text-white text-center">
            <h2 class="text-2xl font-bold">Buat Akun Baru</h2>
            <p class="opacity-70 text-sm">Gunakan menu ini untuk mendaftarkan Wali Santri atau Admin baru.</p>
        </div>

        <form action="{{ route('users.store') }}" method="POST" class="p-8 space-y-5">
            @csrf
            
            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                <input type="text" name="name" required class="w-full rounded-xl border-slate-200 focus:ring-emerald-500" placeholder="Masukkan nama...">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Email</label>
                <input type="email" name="email" required class="w-full rounded-xl border-slate-200" placeholder="contoh@gmail.com">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full rounded-xl border-slate-200" placeholder="Minimal 6 karakter...">
            </div>

            <div>
                <label class="block text-sm font-bold text-slate-700 mb-1">Role / Hak Akses</label>
                <select name="role" required class="w-full rounded-xl border-slate-200 font-bold text-slate-700">
                    <option value="wali">Wali Santri (Akses Monitoring Anak)</option>
                    <option value="admin">Admin / Pengurus (Akses Input Data)</option>
                </select>
            </div>

            <div class="pt-4 flex flex-col space-y-3">
                <button type="submit" class="w-full bg-emerald-600 text-white py-3 rounded-2xl font-bold shadow-lg shadow-emerald-500/30 hover:bg-emerald-700 transition active:scale-95">
                    Buat User Sekarang
                </button>
                <a href="{{ route('users.index') }}" class="text-center py-2 text-slate-500 text-sm font-medium hover:text-slate-800">Kembali ke Daftar</a>
            </div>
        </form>
    </div>
</div>

</x-app-layout>