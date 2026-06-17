@extends('layouts.admin')

@section('title', 'Corbeille')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Corbeille</h1>
    <p class="text-gray-600 mt-1">
        <span class="font-semibold">{{ $totalTrashed }}</span> élément(s) dans la corbeille
    </p>
</div>

{{-- Onglets --}}
<div x-data="{ tab: '{{ $products->count() ? 'products' : ($categories->count() ? 'categories' : 'reviews') }}' }" class="space-y-6">
    <div class="flex gap-2 border-b border-gray-200">
        <button @click="tab = 'products'"
                :class="tab === 'products' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="px-4 py-3 text-sm font-semibold border-b-2 transition-colors">
            Produits
            @if($products->count())
                <span class="ml-1 bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $products->count() }}</span>
            @endif
        </button>
        <button @click="tab = 'categories'"
                :class="tab === 'categories' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="px-4 py-3 text-sm font-semibold border-b-2 transition-colors">
            Catégories
            @if($categories->count())
                <span class="ml-1 bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $categories->count() }}</span>
            @endif
        </button>
        <button @click="tab = 'reviews'"
                :class="tab === 'reviews' ? 'border-primary-600 text-primary-600' : 'border-transparent text-gray-500 hover:text-gray-700'"
                class="px-4 py-3 text-sm font-semibold border-b-2 transition-colors">
            Avis
            @if($reviews->count())
                <span class="ml-1 bg-red-100 text-red-700 text-xs font-bold px-2 py-0.5 rounded-full">{{ $reviews->count() }}</span>
            @endif
        </button>
    </div>

    {{-- Produits --}}
    <div x-show="tab === 'products'" x-cloak>
        @if($products->count())
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Prix</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Supprimé le</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $product->name }}</p>
                                    <p class="text-xs text-gray-500">{{ $product->sku }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $product->category?->name ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900">{{ $product->formatted_price }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $product->deleted_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.products.restore', $product->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 text-sm font-semibold text-green-600 hover:text-green-800 transition-colors" title="Restaurer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        Restaurer
                                    </button>
                                </form>
                                <button type="button"
                                        x-on:click="$dispatch('confirm-delete', { action: '{{ route('admin.products.force-delete', $product->id) }}', message: 'Supprimer définitivement le produit « {{ addslashes($product->name) }} » ? Les images seront aussi supprimées. Cette action est irréversible.' })"
                                        class="inline-flex items-center gap-1 text-sm font-semibold text-red-600 hover:text-red-800 transition-colors"
                                        title="Supprimer définitivement">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
            <p class="text-gray-500 font-medium">Aucun produit dans la corbeille</p>
        </div>
        @endif
    </div>

    {{-- Catégories --}}
    <div x-show="tab === 'categories'" x-cloak>
        @if($categories->count())
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Catégorie</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Supprimée le</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($categories as $category)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($category->image)
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                @else
                                    <div class="w-10 h-10 rounded-lg bg-gray-200 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                                        </svg>
                                    </div>
                                @endif
                                <p class="font-semibold text-gray-900">{{ $category->name }}</p>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $category->deleted_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.categories.restore', $category->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 text-sm font-semibold text-green-600 hover:text-green-800 transition-colors" title="Restaurer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        Restaurer
                                    </button>
                                </form>
                                <button type="button"
                                        x-on:click="$dispatch('confirm-delete', { action: '{{ route('admin.categories.force-delete', $category->id) }}', message: 'Supprimer définitivement la catégorie « {{ addslashes($category->name) }} » ? Cette action est irréversible.' })"
                                        class="inline-flex items-center gap-1 text-sm font-semibold text-red-600 hover:text-red-800 transition-colors"
                                        title="Supprimer définitivement">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
            <p class="text-gray-500 font-medium">Aucune catégorie dans la corbeille</p>
        </div>
        @endif
    </div>

    {{-- Avis --}}
    <div x-show="tab === 'reviews'" x-cloak>
        @if($reviews->count())
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Auteur</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Produit</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Note</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase">Supprimé le</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($reviews as $review)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $review->user?->name ?? 'Utilisateur supprimé' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $review->product?->name ?? 'Produit supprimé' }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $review->deleted_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.reviews.restore', $review->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1 text-sm font-semibold text-green-600 hover:text-green-800 transition-colors" title="Restaurer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"/>
                                        </svg>
                                        Restaurer
                                    </button>
                                </form>
                                <button type="button"
                                        x-on:click="$dispatch('confirm-delete', { action: '{{ route('admin.reviews.force-delete', $review->id) }}', message: 'Supprimer définitivement cet avis ? Cette action est irréversible.' })"
                                        class="inline-flex items-center gap-1 text-sm font-semibold text-red-600 hover:text-red-800 transition-colors"
                                        title="Supprimer définitivement">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                    Supprimer
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12 text-center">
            <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/>
            </svg>
            <p class="text-gray-500 font-medium">Aucun avis dans la corbeille</p>
        </div>
        @endif
    </div>
</div>
@endsection
