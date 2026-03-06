<img src="{{ $src }}" 
     alt="{{ $alt }}" 
     @if($title) title="{{ $title }}" @endif
     loading="lazy"
     class="{{ $class }}"
     {{ $attributes->merge(['class' => '']) }}>