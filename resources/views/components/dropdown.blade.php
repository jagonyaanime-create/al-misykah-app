@props(['align' => 'right', 'width' => '48', 'contentClasses' => 'py-1 bg-white'])
<div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
    <div @click="open = ! open">{{ $trigger }}</div>
    <div x-show="open" x-transition class="absolute z-50 mt-2 w-{{ $width }} rounded-md shadow-lg" style="display: none;">
        <div class="rounded-md ring-1 ring-black ring-opacity-5 {{ $contentClasses }}">{{ $content }}</div>
    </div>
</div>