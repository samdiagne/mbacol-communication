@props(['status'])

@php
$statusConfig = [
    'pending' => [
        'label' => 'En attente',
        'class' => 'bg-yellow-100 text-yellow-800',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    ],
    'confirmed' => [
        'label' => 'Confirmée',
        'class' => 'bg-blue-100 text-blue-800',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    ],
    'processing' => [
        'label' => 'En préparation',
        'class' => 'bg-purple-100 text-purple-800',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>'
    ],
    'shipped' => [
        'label' => 'Expédiée',
        'class' => 'bg-indigo-100 text-indigo-800',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>'
    ],
    'delivered' => [
        'label' => 'Livrée',
        'class' => 'bg-green-100 text-green-800',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    ],
    'cancelled' => [
        'label' => 'Annulée',
        'class' => 'bg-red-100 text-red-800',
        'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
    ],
];

$config = $statusConfig[$status] ?? [
    'label' => ucfirst($status),
    'class' => 'bg-gray-100 text-gray-800',
    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>'
];
@endphp

<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold {{ $config['class'] }} {{ $attributes->get('class') }}">
    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        {!! $config['icon'] !!}
    </svg>
    {{ $config['label'] }}
</span>
