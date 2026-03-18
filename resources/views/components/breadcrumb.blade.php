@props(['items'])

<nav class="scroll-reveal flex mb-8 text-sm" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-2">
        @foreach($items as $index => $item)
            @if($index > 0)
                <li>
                    <span class="text-gray-400">/</span>
                </li>
            @endif
            
            <li>
                @if(isset($item['url']) && !$loop->last)
                    <a href="{{ $item['url'] }}" class="text-gray-500 hover:text-primary-600 transition">
                        {{ $item['label'] }}
                    </a>
                @else
                    <span class="text-gray-900 font-semibold">{{ $item['label'] }}</span>
                @endif
            </li>
        @endforeach
    </ol>
</nav>
