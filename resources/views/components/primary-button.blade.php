<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-emerald-600 hover:bg-emerald-700 text-white px-8 py-3 rounded-2xl font-black text-xs uppercase tracking-widest shadow-lg shadow-emerald-500/20 active:scale-95 transition-all']) }}>
    {{ $slot }}
</button>