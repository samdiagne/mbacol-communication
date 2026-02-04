@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
    <p class="text-gray-600">Bienvenue, {{ Auth::user()->name }}</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <!-- Total Produits -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Total Produits</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_products'] }}</p>
            </div>
            <div class="bg-primary-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
        </div>
        <p class="text-sm text-green-600 mt-2">{{ $stats['active_products'] }} actifs</p>
    </div>
    
    <!-- Rupture de stock -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Rupture de stock</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['out_of_stock'] }}</p>
            </div>
            <div class="bg-red-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
        </div>
    </div>
    
    <!-- Catégories -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-600 mb-1">Catégories</p>
                <p class="text-3xl font-bold text-gray-900">{{ $stats['total_categories'] }}</p>
            </div>
            <div class="bg-secondary-100 p-3 rounded-full">
                <svg class="w-8 h-8 text-secondary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Produits récents et stock faible -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Produits récents -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Produits récents</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($recent_products as $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded overflow-hidden mr-3">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ Str::limit($product->name, 30) }}</p>
                            <p class="text-sm text-gray-500">{{ $product->category->name }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-semibold text-gray-900">{{ $product->formatted_price }}</span>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucun produit</p>
                @endforelse
            </div>
        </div>
    </div>
    
    <!-- Stock faible -->
    <div class="bg-white rounded-lg shadow">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Stock faible</h2>
        </div>
        <div class="p-6">
            <div class="space-y-4">
                @forelse($low_stock as $product)
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-200 rounded overflow-hidden mr-3">
                            @if($product->main_image)
                                <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div>
                            <p class="font-semibold text-gray-900">{{ Str::limit($product->name, 30) }}</p>
                            <p class="text-sm text-red-600">{{ $product->stock }} restant(s)</p>
                        </div>
                    </div>
                    <a href="{{ route('admin.products.edit', $product) }}" class="text-primary-600 hover:text-primary-700 text-sm font-semibold">
                        Réapprovisionner
                    </a>
                </div>
                @empty
                <p class="text-gray-500 text-center py-4">Aucun stock faible</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection