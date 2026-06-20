<x-app-layout>
<div class="min-h-[80vh] flex items-center justify-center">
    <div class="w-full max-w-md p-2">
        <div class="bg-white/80 backdrop-blur-xl border border-white rounded-[40px] shadow-2xl overflow-hidden">
            <div class="bg-emerald-800 p-10 text-white text-center relative">
                <!-- Ikon Gembok -->
                <div class="w-20 h-20 bg-white/10 rounded-3xl flex items-center justify-center mx-auto mb-4 border border-white/20 shadow-lg">
                    <i class="fa-solid fa-vault text-3xl text-yellow-400"></i>
                </div>
                <h2 class="text-2xl font-black tracking-tight italic uppercase">Area Sensitif</h2>
                <p class="text-xs text-emerald-100/70 mt-2 uppercase tracking-widest font-bold">Verifikasi Identitas Diperlukan</p>
            </div>

            <form action="{{ url('/pembayaran-login') }}" method="POST" class="p-10 space-y-6">
                @csrf
                @if(session('error'))
                    <div class="bg-rose-50 text-rose-600 p-4 rounded-2xl text-xs font-bold text-center border border-rose-100">
                        {{ session('error') }}
                    </div>
                @endif

                <div class="space-y-2 text-center">
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Password Keuangan</label>
                    <input type="password" name="password" autofocus required
                           class="w-full text-center py-4 bg-slate-50 border-slate-100 rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 font-black text-slate-800 placeholder:font-normal placeholder:text-slate-300"
                           placeholder="••••••••">
                </div>

                <button type="submit" class="w-full bg-emerald-800 hover:bg-emerald-900 text-white py-4 rounded-2xl font-black shadow-lg shadow-emerald-900/30 transition-all transform active:scale-95 flex items-center justify-center uppercase tracking-widest text-xs">
                    BUKA AKSES BRANKAS <i class="fa-solid fa-key ml-2"></i>
                </button>
                
                <a href="{{ route('admin.dashboard') }}" class="block text-center text-slate-400 text-[10px] font-bold uppercase hover:text-slate-800 transition">
                    Kembali ke Dashboard
                </a>
            </form>
        </div>
    </div>
</div>
</x-app-layout>