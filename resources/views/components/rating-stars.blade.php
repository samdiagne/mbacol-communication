@props(['rating', 'showValue' => true, 'size' => 'md'])

@php
$sizeClasses = [
    'sm' => 'w-3 h-3',
    'md' => 'w-5 h-5',
    'lg' => 'w-6 h-6'
];

$sizeClass = $sizeClasses[$size] ?? $sizeClasses['md'];
$fullStars = floor($rating);
$hasHalfStar = ($rating - $fullStars) >= 0.5;
@endphp

<div class="flex items-center {{ $attributes->get('class') }}">
    @for($i = 1; $i <= 5; $i++)
        @if($i <= $fullStars)
            <svg class="{{ $sizeClass }} text-yellow-400 fill-current" viewBox="0 0 20 20">
                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
            </svg>
        @elseif($i == $fullStars + 1 && $hasHalfStar)
            <svg class="{{ $sizeClass }} text-yellow-400" viewBox="0 0 20 20">
                <defs>
                    <linearGradient id="half-{{ uniqid() }}">
                        <stop offset="50%" stop-color="#FBBF24"/>
                        <stop offset="50%" stop-color="#E5E7EB"/>
                    </linearGradient>
                </defs>
                <path fill="url(#half-{{ uniqid() }})" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
            </svg>
        @else
            <svg class="{{ $sizeClass }} text-gray-300 fill-current" viewBox="0 0 20 20">
                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
            </svg>
        @endif
    @endfor
    
    @if($showValue)
        <span class="ml-2 text-sm font-semibold text-gray-700">{{ number_format($rating, 1) }} / 5</span>
    @endif
</div>
