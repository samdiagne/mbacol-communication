@extends('layouts.admin')

@section('title', 'Modifier le produit')

@section('content')
<div class="mb-6">
    <div class="flex items-center mb-4">
        <a href="{{ route('admin.products.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Modifier le produit</h1>
            <p class="text-gray-600">{{ $product->name }}</p>
        </div>
    </div>
</div>

<form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    
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
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
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
                    <input type="text" name="short_description" value="{{ old('short_description', $product->short_description) }}"
                           maxlength="500"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('short_description') border-red-500 @enderror">
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
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description', $product->description) }}</textarea>
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
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
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
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0" step="1"
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
                        <input type="number" name="old_price" value="{{ old('old_price', $product->old_price) }}" min="0" step="1"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('old_price') border-red-500 @enderror">
                        @error('old_price')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Quantité en stock <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
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
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}"
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('sku') border-red-500 @enderror">
                        @error('sku')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Images</h2>
                
                <!-- Image principale actuelle -->
                @if($product->main_image)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Image principale actuelle</label>
                    <div class="relative inline-block">
                        <img src="{{ asset('storage/' . $product->main_image) }}" alt="{{ $product->name }}" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                </div>
                @endif
                
                <!-- Nouvelle image principale -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Remplacer l'image principale
                    </label>
                    <input type="file" name="main_image" accept="image/*"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           onchange="previewMainImage(event)">
                    <p class="text-sm text-gray-500 mt-1">JPG, PNG ou WEBP. Max 2 Mo.</p>
                    
                    <!-- Preview -->
                    <div id="main-image-preview" class="mt-4 hidden">
                        <img src="" alt="Preview" class="h-32 w-32 object-cover rounded-lg">
                    </div>
                </div>

                <!-- Images supplémentaires existantes -->
                @if($product->images->count() > 0)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Galerie d'images</label>
                    <div class="grid grid-cols-4 gap-4">
                        @foreach($product->images as $image)
                        <div class="relative group">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image {{ $loop->iteration }}" class="h-24 w-24 object-cover rounded-lg">
                            <form action="{{ route('admin.products.delete-image', $image) }}" method="POST" class="absolute top-0 right-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Supprimer cette image ?')" class="bg-red-600 hover:bg-red-700 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Ajouter de nouvelles images -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Ajouter des images à la galerie
                    </label>
                    <input type="file" name="images[]" accept="image/*" multiple
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                           onchange="previewImages(event)">
                    
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
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">Produit actif</span>
                    </label>

                    <!-- En vedette -->
                    <label class="flex items-center">
                        <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}
                               class="rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-700">En vedette (page d'accueil)</span>
                    </label>
                </div>

                <div class="mt-6 space-y-3">
                    <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 rounded-lg transition duration-200">
                        Enregistrer les modifications
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-lg transition duration-200">
                        Annuler
                    </a>
                </div>
            </div>

            <!-- Statistiques -->
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-3">📊 Statistiques</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <p><strong>Vues :</strong> {{ $product->views }}</p>
                    <p><strong>Créé le :</strong> {{ $product->created_at->format('d/m/Y') }}</p>
                    <p><strong>Modifié le :</strong> {{ $product->updated_at->format('d/m/Y') }}</p>
                </div>
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