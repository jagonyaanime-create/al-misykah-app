<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Wali Santri - Al-Misykah</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
        <!-- Tambahkan baris ini di bawahnya -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">

    <!-- Header Responsif -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="bg-emerald-600 p-1.5 rounded-lg mr-2 sm:mr-3">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5s3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-emerald-800 font-bold text-base sm:text-xl leading-none">Al-Misykah</h1>
                        <p class="text-[9px] sm:text-[10px] text-gray-400 font-medium tracking-widest uppercase">Panel Wali</p>
                    </div>
                </div>

                <!-- User & Logout -->
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <div class="hidden sm:block text-right">
                        <p class="text-xs text-gray-400">Selamat datang,</p>
                        <p class="text-sm font-bold text-gray-800">{{ auth()->user()->name }}</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2 sm:px-4 sm:py-2 bg-red-50 text-red-600 rounded-full hover:bg-red-100 transition flex items-center">
                            <svg class="w-5 h-5 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            <span class="hidden sm:block font-bold text-sm">Keluar</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Konten Responsif -->
    <main class="max-w-7xl mx-auto py-6 px-4 sm:py-10 sm:px-6 lg:px-8">
        @yield('content')
    </main>

</body>
</html>