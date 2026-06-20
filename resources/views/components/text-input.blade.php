@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'w-full rounded-2xl border-slate-200 focus:ring-emerald-500 focus:border-emerald-500 font-semibold text-slate-700 shadow-sm']) !!}>