@extends('layouts.app')

@section('title', $product->name)

@section('content')

<div class="bg-gradient-to-b from-gray-50 to-white">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <!-- FIL D’ARIANE -->
    <nav class="flex mb-10 text-sm text-gray-500">
        <ol class="inline-flex items-center space-x-2">
            <li><a href="{{ route('home') }}" class="hover:text-primary-600">Accueil</a></li>
            <li>/</li>
            <li><a href="{{ route('shop') }}" class="hover:text-primary-600">Boutique</a></li>
            <li>/</li>
            <li><a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="hover:text-primary-600">{{ $product->category->name }}</a></li>
            <li>/</li>
            <li class="text-gray-900 font-semibold line-clamp-1">{{ $product->name }}</li>
        </ol>
    </nav>

    <!-- CONTENU PRINCIPAL -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 mb-20">

        <!-- GALERIE -->
        <div x-data="{ activeImage: '{{ $product->main_image ? asset('storage/'.$product->main_image) : '' }}' }">

            <div class="relative bg-white rounded-2xl shadow-xl overflow-hidden mb-5">
                <div class="h-[420px] bg-gray-100 flex items-center justify-center">
                    <template x-if="activeImage">
                        <img :src="activeImage" class="w-full h-full object-contain transition duration-300">
                    </template>
                </div>

                @if($product->discount_percentage > 0)
                <div class="absolute top-4 left-4 bg-secondary-600 text-white px-4 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                    -{{ $product->discount_percentage }}%
                </div>
                @endif
            </div>

            @if($product->images->count() > 0)
            <div class="grid grid-cols-4 gap-3">
                @if($product->main_image)
                <button @click="activeImage='{{ asset('storage/'.$product->main_image) }}'"
                        class="h-20 rounded-xl overflow-hidden border-2 border-primary-600 shadow">
                    <img src="{{ asset('storage/'.$product->main_image) }}" class="w-full h-full object-cover">
                </button>
                @endif

                @foreach($product->images as $image)
                <button @click="activeImage='{{ asset('storage/'.$image->image_path) }}'"
                        class="h-20 rounded-xl overflow-hidden border-2 border-transparent hover:border-primary-600 transition">
                    <img src="{{ asset('storage/'.$image->image_path) }}" class="w-full h-full object-cover">
                </button>
                @endforeach
            </div>
            @endif
        </div>

        <!-- INFOS PRODUIT -->
        <div>

            <span class="inline-block bg-primary-100 text-primary-700 text-xs font-bold px-4 py-1 rounded-full mb-3 uppercase">
                {{ $product->category->name }}
            </span>

            <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-4">
                {{ $product->name }}
            </h1>

            <p class="text-lg text-gray-600 mb-6">
                {{ $product->short_description }}
            </p>

            <!-- PRIX -->
            <div class="bg-white rounded-2xl shadow p-6 mb-6">
                <div class="flex flex-wrap items-center gap-4">
                    <span class="text-4xl font-extrabold text-gray-900">
                        {{ $product->formatted_price }}
                    </span>

                    @if($product->old_price)
                        <span class="text-lg line-through text-gray-400">
                            {{ $product->formatted_old_price }}
                        </span>
                        <span class="bg-secondary-600 text-white px-3 py-1 rounded-full text-sm font-bold">
                            -{{ number_format($product->old_price - $product->price, 0, ',', ' ') }} FCFA
                        </span>
                    @endif
                </div>
            </div>

            <!-- STOCK -->
            <div class="flex flex-wrap gap-6 text-sm mb-8">
                @if($product->stock > 10)
                    <span class="text-green-600 font-semibold">✔ En stock ({{ $product->stock }})</span>
                @elseif($product->stock > 0)
                    <span class="text-yellow-600 font-semibold">⚠ Plus que {{ $product->stock }} restant(s)</span>
                @else
                    <span class="text-red-600 font-semibold">✖ Rupture de stock</span>
                @endif

                @if($product->sku)
                    <span class="text-gray-500">SKU : <span class="font-mono font-semibold">{{ $product->sku }}</span></span>
                @endif
            </div>

            <!-- AJOUT PANIER -->
            @livewire('add-to-cart', ['product' => $product])

            <!-- CONFIANCE -->
            <div class="grid grid-cols-2 gap-4 mt-8 text-sm">
                <div class="flex items-center gap-2 text-gray-600">✅ Paiement sécurisé</div>
                <div class="flex items-center gap-2 text-gray-600">🚚 Livraison rapide</div>
                <div class="flex items-center gap-2 text-gray-600">🛡 Garantie</div>
                <div class="flex items-center gap-2 text-gray-600">📞 Support client</div>
            </div>
        </div>
    </div>

    <!-- DESCRIPTION -->
    <div class="bg-white rounded-2xl shadow-lg p-10 mb-20">
        <h2 class="text-3xl font-bold mb-6">Description du produit</h2>
        <div class="prose max-w-none text-gray-700">
            {!! nl2br(e($product->description)) !!}
        </div>
    </div>

    <!-- PRODUITS SIMILAIRES -->
    @if($relatedProducts->count() > 0)
    <div>
        <h2 class="text-3xl font-bold mb-8">Produits similaires</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $relatedProduct)
            <div class="bg-white rounded-2xl shadow hover:shadow-2xl transition overflow-hidden group">
                <a href="{{ route('product.show', $relatedProduct) }}" class="block aspect-[4/3] bg-gray-100 overflow-hidden">
                    <img src="{{ asset('storage/'.$relatedProduct->main_image) }}"
                         class="w-full h-full object-cover group-hover:scale-110 transition duration-300">
                </a>
                <div class="p-4">
                    <h3 class="font-bold line-clamp-2 group-hover:text-primary-600">
                        {{ $relatedProduct->name }}
                    </h3>
                    <p class="text-lg font-extrabold mt-2">
                        {{ $relatedProduct->formatted_price }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
</div>

@endsection
