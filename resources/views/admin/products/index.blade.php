@extends('layouts.admin')

@section('title', 'Gestion des Produits')

@section('content')
<!-- En-tête avec bouton d'ajout -->
<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
    <div>
        <h1 class="text-3xl font-bold text-gray-900">Produits</h1>
        <p class="text-gray-600 mt-1">
            <span class="font-semibold">{{ $products->total() }}</span> produit(s) trouvé(s)
            @if(request('search'))
                pour "<span class="text-primary-600 font-semibold">{{ request('search') }}</span>"
            @endif
        </p>
    </div>
    <a href="{{ route('admin.products.create') }}" 
       class="inline-flex items-center bg-primary-600 hover:bg-primary-700 text-white font-bold px-6 py-3 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
        </svg>
        Ajouter un produit
    </a>
</div>

<!-- Filtres et Recherche -->
<div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-100">
    <form method="GET" action="{{ route('admin.products.index') }}" class="space-y-4">
        
        <!-- Ligne 1 : Recherche + Catégorie + Tri -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Recherche -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    🔍 Rechercher
                </label>
                <input type="search" 
                       name="search" 
                       value="{{ request('search') }}"
                       placeholder="Nom du produit ou SKU..." 
                       class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
            </div>

            <!-- Catégorie -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📂 Catégorie
                </label>
                <select name="category" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Tri -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    ⚡ Trier par
                </label>
                <select name="sort" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Plus récents</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                    <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nom A-Z</option>
                    <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nom Z-A</option>
                    <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                    <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                    <option value="stock_asc" {{ request('sort') == 'stock_asc' ? 'selected' : '' }}>Stock croissant</option>
                    <option value="stock_desc" {{ request('sort') == 'stock_desc' ? 'selected' : '' }}>Stock décroissant</option>
                </select>
            </div>
        </div>

        <!-- Ligne 2 : Filtres rapides -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <!-- Stock -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    📦 Stock
                </label>
                <select name="stock_status" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <option value="">Tous</option>
                    <option value="in_stock" {{ request('stock_status') == 'in_stock' ? 'selected' : '' }}>En stock</option>
                    <option value="low_stock" {{ request('stock_status') == 'low_stock' ? 'selected' : '' }}>Stock faible (≤5)</option>
                    <option value="out_of_stock" {{ request('stock_status') == 'out_of_stock' ? 'selected' : '' }}>Rupture</option>
                </select>
            </div>

            <!-- En vedette -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    ⭐ Vedette
                </label>
                <select name="featured" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <option value="">Tous</option>
                    <option value="1" {{ request('featured') === '1' ? 'selected' : '' }}>Oui</option>
                    <option value="0" {{ request('featured') === '0' ? 'selected' : '' }}>Non</option>
                </select>
            </div>

            <!-- Statut -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    🔄 Statut
                </label>
                <select name="status" 
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary-500 focus:border-transparent transition">
                    <option value="">Tous</option>
                    <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Actif</option>
                    <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Inactif</option>
                </select>
            </div>

            <!-- Boutons alignés verticalement avec le dernier select -->
            <div class="flex items-end gap-2">
                <button type="submit" 
                        class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold px-4 py-2.5 rounded-xl transition-all duration-200 shadow-md hover:shadow-lg">
                    Filtrer
                </button>
                <a href="{{ route('admin.products.index') }}" 
                   class="flex-shrink-0 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold px-4 py-2.5 rounded-xl transition-all duration-200">
                    ↻
                </a>
            </div>
        </div>

        <!-- Filtres actifs (badges) -->
        @if(request()->hasAny(['search', 'category', 'stock_status', 'featured', 'status', 'sort']))
        <div class="flex flex-wrap gap-2 pt-4 border-t border-gray-200">
            <span class="text-sm font-medium text-gray-600">Filtres actifs :</span>
            
            @if(request('search'))
            <span class="inline-flex items-center bg-primary-100 text-primary-700 px-3 py-1 rounded-full text-sm font-medium">
                🔍 {{ request('search') }}
                <a href="{{ route('admin.products.index', array_diff_key(request()->all(), ['search' => ''])) }}" class="ml-2 hover:text-primary-900">×</a>
            </span>
            @endif

            @if(request('category'))
            <span class="inline-flex items-center bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-sm font-medium">
                📂 {{ $categories->find(request('category'))->name ?? 'Catégorie' }}
                <a href="{{ route('admin.products.index', array_diff_key(request()->all(), ['category' => ''])) }}" class="ml-2 hover:text-purple-900">×</a>
            </span>
            @endif

            @if(request('stock_status'))
            <span class="inline-flex items-center bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                📦 {{ ['in_stock' => 'En stock', 'low_stock' => 'Stock faible', 'out_of_stock' => 'Rupture'][request('stock_status')] }}
                <a href="{{ route('admin.products.index', array_diff_key(request()->all(), ['stock_status' => ''])) }}" class="ml-2 hover:text-blue-900">×</a>
            </span>
            @endif

            @if(request('featured') !== null)
            <span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm font-medium">
                ⭐ {{ request('featured') == '1' ? 'En vedette' : 'Pas en vedette' }}
                <a href="{{ route('admin.products.index', array_diff_key(request()->all(), ['featured' => ''])) }}" class="ml-2 hover:text-yellow-900">×</a>
            </span>
            @endif
        </div>
        @endif
    </form>
</div>

<!-- Tableau des produits -->
<div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Produit
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Catégorie
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Prix
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Stock
                    </th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                        Statut
                    </th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-700 uppercase tracking-wider sticky right-0 bg-gray-100">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($products as $product)
                <tr class="hover:bg-gray-50 transition-colors">
                    <!-- Produit avec image -->
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-16 h-16 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
                                @if($product->main_image)
                                    <img src="{{ asset('storage/' . $product->main_image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 min-w-0 flex-1">
                                <p class="text-sm font-bold text-gray-900 line-clamp-2" title="{{ $product->name }}">
                                    {{ $product->name }}
                                </p>
                                <p class="text-xs text-gray-500 font-mono">
                                    SKU: {{ $product->sku }}
                                </p>
                                @if($product->is_featured)
                                    <span class="inline-block mt-1 text-xs bg-yellow-100 text-yellow-800 px-2 py-0.5 rounded-full font-semibold">
                                        ⭐ Vedette
                                    </span>
                                @endif
                            </div>
                        </div>
                    </td>

                    <!-- Catégorie -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                            {{ $product->category->name }}
                        </span>
                    </td>

                    <!-- Prix -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        <p class="text-sm font-bold text-gray-900">{{ $product->formatted_price }}</p>
                        @if($product->old_price)
                            <p class="text-xs text-gray-500 line-through">{{ $product->formatted_old_price }}</p>
                        @endif
                    </td>

                    <!-- Stock -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($product->stock > 5)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                ✓ {{ $product->stock }}
                            </span>
                        @elseif($product->stock > 0)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-800">
                                ⚠ {{ $product->stock }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                ✕ Rupture
                            </span>
                        @endif
                    </td>

                    <!-- Statut -->
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($product->is_active)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                                ● Actif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                ○ Inactif
                            </span>
                        @endif
                    </td>
                    <!-- Actions -->
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium sticky right-0 bg-white">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('product.show', $product) }}" 
                               target="_blank"
                               class="text-gray-600 hover:text-primary-600 transition-colors"
                               title="Voir">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                </svg>
                            </a>
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="text-blue-600 hover:text-blue-800 transition-colors"
                               title="Modifier">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>
                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  onsubmit="return confirm('Confirmer la suppression ?')"
                                  class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="text-red-600 hover:text-red-800 transition-colors"
                                        title="Supprimer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-16 text-center">
                        <div class="text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                            </svg>
                            <p class="text-lg font-semibold text-gray-600 mb-2">Aucun produit trouvé</p>
                            <p class="text-sm text-gray-500">Essayez de modifier vos filtres ou ajoutez un nouveau produit</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
    <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
        {{ $products->links() }}
    </div>
    @endif
</div>
@endsection