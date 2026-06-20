@props(['active', 'icon'])

@php
// Logika untuk menentukan gaya jika menu sedang aktif atau tidak
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 text-sm font-semibold text-white bg-emerald-800 border-l-4 border-yellow-400 rounded-lg shadow-inner transition-all duration-200'
            : 'flex items-center px-4 py-3 text-sm font-medium text-emerald-100 hover:bg-emerald-800 hover:text-white rounded-lg transition-all duration-200 group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="fa-solid {{ $icon }} w-5 h-5 mr-3 transition-colors {{ $active ? 'text-yellow-400' : 'text-emerald-400 group-hover:text-white' }}"></i>
    @endif
    
    <span class="truncate">{{ $slot }}</span>
</a>