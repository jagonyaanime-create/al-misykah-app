<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Fonts - Inter atau Figtree (Sangat Modern) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome (Untuk Ikon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 antialiased" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">
        
        <!-- SIDEBAR PREMIUM -->
        <aside 
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="fixed inset-y-0 left-0 z-50 w-72 bg-emerald-900 text-slate-100 transition-all duration-300 transform lg:translate-x-0 lg:static lg:inset-0 shadow-2xl shrink-0">
            
            <div class="flex flex-col h-full">
                <!-- Logo Area -->
                <div class="px-8 py-8 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-emerald-500/20">
                            <span class="text-xl font-bold text-white">M</span>
                        </div>
                        <h2 class="text-xl font-bold tracking-tight text-white uppercase">Al-Misykah</h2>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden hover:bg-emerald-800 p-1 rounded-lg">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Navigasi Menu -->
                <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-widest mb-2 opacity-50">Manajemen User</p>

                <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.*')" icon="fa-user-plus">
                    Data User / Akun
                </x-nav-link>
                <!-- Navigation -->
                <nav class="flex-1 px-4 space-y-1 overflow-y-auto custom-scrollbar">
                    <p class="px-4 text-xs font-semibold text-emerald-400 uppercase tracking-widest mb-2 opacity-50">Main Menu</p>
                    
                    <x-nav-link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')" icon="fa-home">Dashboard</x-nav-link>
                    <x-nav-link href="/santri" :active="request()->is('santri*')" icon="fa-user-group">Data Santri</x-nav-link>
                    <x-nav-link href="{{ route('absensi.index') }}" :active="request()->routeIs('absensi.*')" icon="fa-calendar-check">Presensi Harian</x-nav-link>
                    <x-nav-link href="/pembayaran" :active="request()->is('pembayaran*')" icon="fa-wallet">Pembayaran</x-nav-link>
                    <x-nav-link href="/pelanggaran" :active="request()->is('pelanggaran*')" icon="fa-triangle-exclamation">Pelanggaran</x-nav-link>
                </nav>

                <!-- PROFILE & LOGOUT SECTION -->
                <div class="p-4 border-t border-emerald-800/50 mt-auto">
                    <!-- Card Profil -->
                    <div class="flex items-center p-3 rounded-2xl bg-emerald-800/30 mb-3">
                        <div class="w-10 h-10 rounded-full bg-emerald-600 border-2 border-emerald-400 flex items-center justify-center font-bold text-white shadow-lg">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div class="ml-3 overflow-hidden text-left">
                            <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                            <p class="text-[10px] text-emerald-400 font-bold uppercase tracking-widest">{{ auth()->user()->role }}</p>
                        </div>
                    </div>

                    <!-- Tombol Logout -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-500/10 hover:bg-red-600 text-red-400 hover:text-white rounded-2xl font-bold text-xs transition-all duration-200 border border-red-500/20 active:scale-95 group">
                            <i class="fa-solid fa-right-from-bracket transition-transform group-hover:translate-x-1"></i>
                            LOGOUT / KELUAR
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- MAIN CONTENT AREA -->
        <div class="flex flex-col flex-1 min-w-0 overflow-hidden relative">
            
            <!-- MODERN HEADER -->
            <header class="h-16 bg-white/80 backdrop-blur-md border-b border-slate-200 flex items-center justify-between px-6 sticky top-0 z-30">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                
                <div class="flex items-center space-x-4">
                    <div class="hidden sm:flex flex-col">
                        <span class="text-xs text-slate-500 font-medium">{{ now()->format('l, d F Y') }}</span>
                    </div>
                </div>

                <div class="flex items-center space-x-3 text-slate-600">
                    <button class="p-2 hover:bg-slate-100 rounded-full relative">
                        <div class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full ring-2 ring-white"></div>
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v1m6 0H9"></path></svg>
                    </button>
                </div>
            </header>

            <!-- KONTEN -->
            <main class="flex-1 overflow-y-auto bg-slate-50 p-4 sm:p-6 lg:p-10">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>

        </div>
    </div>

        <!-- Notifikasi Toast -->
    <div x-data="{ show: true }" 
        x-show="show && '{{ session('success') }}'" 
        x-init="setTimeout(() => show = false, 5000)"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 transform translate-y-2"
        x-transition:enter-end="opacity-100 transform translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-[100]">
        
        <div class="bg-emerald-600 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center space-x-3 border-b-4 border-emerald-800">
            <i class="fa-solid fa-circle-check text-2xl"></i>
            <div>
                <p class="font-bold">Berhasil!</p>
                <p class="text-xs opacity-90">{{ session('success') }}</p>
            </div>
            <button @click="show = false" class="ml-4 opacity-50 hover:opacity-100">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </div>

</body>
</html>