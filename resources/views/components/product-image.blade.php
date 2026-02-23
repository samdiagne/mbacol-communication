<img src="{{ $src }}" 
     alt="{{ $alt }}" 
     @if($title) title="{{ $title }}" @endif
     loading="{{ $loading }}"
     class="{{ $class }}"
     {{ $attributes->merge(['class' => '']) }}>