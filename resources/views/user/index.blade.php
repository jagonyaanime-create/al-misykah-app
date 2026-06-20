<x-app-layout>

<div class="max-w-6xl mx-auto py-8 px-4">
    
    <!-- Header Area -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-800 tracking-tight">Manajemen Akun</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola akses untuk Wali Santri dan Admin/Pengurus.</p>
        </div>
        <a href="{{ route('users.create') }}" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-emerald-600/20 transition-all flex items-center justify-center">
            <i class="fa-solid fa-user-plus mr-2"></i> Tambah Akun Baru
        </a>
    </div>

    <!-- Statistik Singkat -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Total User</p>
            <p class="text-2xl font-bold text-slate-800">{{ $users->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm border-l-4 border-l-emerald-500">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Wali Santri</p>
            <p class="text-2xl font-bold text-emerald-600">{{ $users->where('role', 'wali')->count() }}</p>
        </div>
        <div class="bg-white p-4 rounded-3xl border border-slate-100 shadow-sm border-l-4 border-l-blue-500">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Administrator</p>
            <p class="text-2xl font-bold text-blue-600">{{ $users->where('role', 'admin')->count() }}</p>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="bg-white rounded-[32px] shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-slate-50/50 border-b border-slate-100 text-slate-500 text-xs font-bold uppercase tracking-wider">
                    <tr>
                        <th class="px-8 py-5">Nama & Info Login</th>
                        <th class="px-6 py-5">Role</th>
                        <th class="px-6 py-5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-8 py-5">
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full bg-slate-100 text-slate-500 flex items-center justify-center font-bold mr-4 group-hover:bg-emerald-100 group-hover:text-emerald-700 transition-colors">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="font-bold text-slate-800 leading-tight">{{ $user->name }}</p>
                                    <p class="text-xs text-slate-400 font-medium mt-1">{{ $user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @if($user->role === 'admin')
                                <span class="bg-blue-50 text-blue-600 px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-blue-100 italic">Administrator</span>
                            @else
                                <span class="bg-emerald-50 text-emerald-600 px-3 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-widest border border-emerald-100 italic">Wali Santri</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex justify-end gap-2">
                                <a href="{{ route('users.edit', $user->id) }}" class="p-2.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-xl transition">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus akun ini?')">
                                    @csrf @method('DELETE')
                                    <button class="p-2.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition">
                                        <i class="fa-solid fa-trash-can">Hapus</i>
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
</div>

</x-app-layout>