@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-xs font-bold text-slate-500 uppercase tracking-widest mb-1']) }}>
    {{ $value ?? $slot }}
</label>