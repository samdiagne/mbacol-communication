@extends('layouts.admin')

@section('title', 'Nouveau produit')

@section('content')
<div class="mb-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Nouveau produit</h1>
            <p class="text-gray-600">Ajoutez un nouveau produit à votre catalogue</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Colonne principale -->
        <div class="lg:col-span-2 space-y-6">
            
            <!-- Informations générales -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Informations générales</h2>
                
                <!-- Nom -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nom du produit <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description courte -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Description courte
                    </label>
                    <input type="text" name="short_description" value="{{ old('short_description') }}"
                           maxlength="500"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('short_description') border-red-500 @enderror">
                    <p class="text-sm text-gray-500 mt-1">Apparaît sur les cartes produits</p>
                    @error('short_description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description complète -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Description complète <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" rows="6" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Catégorie -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Catégorie <span class="text-red-500">*</span>
                    </label>
                    <select name="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">Sélectionner une catégorie</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Prix et stock -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Prix et inventaire</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Prix -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Prix (FCFA) <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0" step="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('price') border-red-500 @enderror">
                        @error('price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Ancien prix -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Ancien prix (FCFA)
                        </label>
                        <input type="number" name="old_price" value="{{ old('old_price') }}" min="0" step="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('old_price') border-red-500 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Pour afficher une réduction</p>
                        @error('old_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Quantité en stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('stock') border-red-500 @enderror">
                        @error('stock')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            SKU (Référence)
                        </label>
                        <input type="text" name="sku" value="{{ old('sku') }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('sku') border-red-500 @enderror">
                        <p class="text-sm text-gray-500 mt-1">Code unique du produit</p>
                        @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Images</h2>
                
                <!-- Image principale -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Image principale
                    </label>
                    <input type="file" name="main_image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('main_image') border-red-500 @enderror"
                           onchange="previewMainImage(event)">
                    <p class="text-sm text-gray-500 mt-1">JPG, PNG ou WEBP. Max 2 Mo.</p>
                    @error('main_image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Preview -->
                    <div id="main-image-preview" class="mt-4 hidden">
                        <img src="" alt="Preview" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                </div>

                <!-- Images supplémentaires -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Images supplémentaires (galerie)
                    </label>
                    <input type="file" name="images[]" accept="image/*" multiple
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           onchange="previewImages(event)">
                    <p class="text-sm text-gray-500 mt-1">Vous pouvez sélectionner plusieurs images</p>
                    
                    <!-- Preview -->
                    <div id="images-preview" class="mt-4 grid grid-cols-4 gap-4"></div>
                </div>
            </div>
        </div>

        <!-- Colonne latérale -->
        <div class="space-y-6">
            
            <!-- Actions -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Publication</h2>
                
                <div class="space-y-4">
                    <!-- Actif -->
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Produit actif</span>
                    </label>

                    <!-- En vedette -->
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">En vedette (page d'accueil)</span>
                    </label>
                </div>

                <div class="mt-6 space-y-3">
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                        Créer le produit
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg transition duration-200">
                        Annuler
                    </a>
                </div>
            </div>

            <!-- Aide -->
            <div class="bg-blue-50 rounded-lg p-6">
                <h3 class="text-sm font-semibold text-blue-900 mb-2">💡 Conseils</h3>
                <ul class="text-sm text-blue-800 space-y-2">
                    <li>• Utilisez des images de haute qualité</li>
                    <li>• Remplissez la description courte pour le référencement</li>
                    <li>• Ajoutez un ancien prix pour afficher une réduction</li>
                    <li>• Le SKU aide à suivre l'inventaire</li>
                </ul>
            </div>
        </div>
    </div>
</form>

<script>
function previewMainImage(event) {
    const preview = document.getElementById('main-image-preview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.querySelector('img').src = e.target.result;
            preview.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function previewImages(event) {
    const container = document.getElementById('images-preview');
    container.innerHTML = '';
    
    Array.from(event.target.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'relative';
            div.innerHTML = `<img src="${e.target.result}" class="h-24 w-24 object-cover rounded-lg">`;
            container.appendChild(div);
        }
        reader.readAsDataURL(file);
    });
}
</script>
@endsection