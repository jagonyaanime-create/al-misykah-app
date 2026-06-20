<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- FontAwesome & Alpine.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 antialiased" x-data="{ sidebarOpen: false }">

    <!-- WRAPPER UTAMA -->
    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR PREMIUM (Emerald 900) -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-emerald-900 text-slate-100 transition-all duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl shrink-0 flex flex-col">
            
            <!-- Logo Area -->
            <div class="px-8 py-8 flex items-center justify-between shrink-0">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <span class="text-xl font-bold text-white italic">M</span>
                    </div>
                    <h2 class="text-xl font-black tracking-tight text-white uppercase italic">Al-Misykah</h2>
                </div>
                <button @click="sidebarOpen = false" class="lg:hidden text-white/50 hover:text-white">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </div>

            <!-- Scrollable Navigation -->
            <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
                
                <!-- Section 1: User Management -->
                <p class="px-4 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-3 mt-2 opacity-60">Manajemen User</p>
                <a href="{{ route('users.index') }}" 
                   class="flex items-center p-4 rounded-2xl font-bold transition-all {{ request()->routeIs('users.*') ? 'bg-emerald-800 border-l-4 border-yellow-400 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <i class="fa-solid fa-user-plus mr-4 opacity-70"></i> Data User / Akun
                </a>

                <!-- Section 2: Main Menu -->
                <p class="px-4 text-[10px] font-black text-emerald-400 uppercase tracking-[0.2em] mb-3 mt-6 opacity-60">Main Menu</p>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center p-4 rounded-2xl font-bold transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-emerald-800 border-l-4 border-yellow-400 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <i class="fa-solid fa-house mr-4 opacity-70"></i> Dashboard
                </a>

                <a href="/santri" 
                   class="flex items-center p-4 rounded-2xl font-bold transition-all {{ request()->is('santri*') ? 'bg-emerald-800 border-l-4 border-yellow-400 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <i class="fa-solid fa-user-group mr-4 opacity-70"></i> Data Santri
                </a>

                <a href="{{ route('absensi.index') }}" 
                   class="flex items-center p-4 rounded-2xl font-bold transition-all {{ request()->routeIs('absensi.*') ? 'bg-emerald-800 border-l-4 border-yellow-400 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <i class="fa-solid fa-calendar-check mr-4 opacity-70"></i> Presensi Harian
                </a>

                <a href="/pembayaran" 
                   class="flex items-center p-4 rounded-2xl font-bold transition-all {{ request()->is('pembayaran*') ? 'bg-emerald-800 border-l-4 border-yellow-400 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <i class="fa-solid fa-wallet mr-4 opacity-70"></i> Pembayaran
                </a>

                <a href="/pelanggaran" 
                   class="flex items-center p-4 rounded-2xl font-bold transition-all {{ request()->is('pelanggaran*') ? 'bg-emerald-800 border-l-4 border-yellow-400 text-white shadow-inner' : 'text-emerald-100 hover:bg-emerald-800' }}">
                    <i class="fa-solid fa-triangle-exclamation mr-4 opacity-70"></i> Pelanggaran
                </a>
            </nav>

            <!-- Bottom Profile & Logout -->
            <div class="p-4 border-t border-emerald-800/50 shrink-0">
                <div class="flex items-center p-3 rounded-2xl bg-emerald-800/30 mb-4">
                    <div class="w-10 h-10 rounded-full bg-emerald-600 border-2 border-emerald-400 flex items-center justify-center font-black text-white shadow-lg shadow-emerald-500/20">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="ml-3 overflow-hidden">
                        <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest">{{ auth()->user()->role }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center p-4 bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white rounded-2xl font-black text-[10px] tracking-widest transition-all uppercase active:scale-95 group">
                        <i class="fa-solid fa-power-off mr-2 transition-transform group-hover:rotate-90"></i> KELUAR APLIKASI
                    </button>
                </form>
            </div>
        </aside>

        <!-- AREA KONTEN -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden relative">
            
            <!-- HEADER MOBILE & TABLET -->
            <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30 shrink-0">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100 transition-colors">
                    <i class="fa-solid fa-bars-staggered text-xl"></i>
                </button>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex flex-col">
                        <span class="text-[10px] text-slate-400 font-black uppercase tracking-widest">{{ now()->translatedFormat('l, d F Y') }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-3">
                    <div class="w-2 h-2 bg-emerald-500 rounded-full animate-ping"></div>
                    <span class="text-[10px] font-black text-slate-800 uppercase tracking-tighter">System Online</span>
                </div>
            </header>

            <!-- ISI KONTEN (Slot) -->
            <main class="flex-1 overflow-y-auto bg-slate-50 p-4 sm:p-6 lg:p-10">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <!-- NOTIFIKASI TOAST -->
    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition class="fixed bottom-5 right-5 z-[100]">
        <div class="bg-emerald-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3 border-b-4 border-emerald-800">
            <i class="fa-solid fa-circle-check text-2xl"></i>
            <div>
                <p class="font-bold">Berhasil!</p>
                <p class="text-xs opacity-90">{{ session('success') }}</p>
            </div>
        </div>
    </div>
    @endif

</body>
</html>