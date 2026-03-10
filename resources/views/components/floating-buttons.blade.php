{{-- Bouton WhatsApp : contextualisé selon la page --}}
@php
    // Détection panier avec articles (connectés ET invités)
    $cartItems = collect();
    
    if (auth()->check()) {
        // Utilisateur connecté : panier en DB
        $cartItems = auth()->user()->cartItems()->with('product')->get();
    } elseif (session()->has('cart')) {
        // Invité : panier en session
        $sessionCart = session('cart', []);
        foreach ($sessionCart as $productId => $details) {
            $product = \App\Models\Product::find($productId);
            if ($product) {
                // Créer un objet similaire à CartItem pour uniformiser
                $cartItems->push((object)[
                    'product' => $product,
                    'quantity' => $details['quantity'],
                ]);
            }
        }
    }
    
    $hasCart = $cartItems->isNotEmpty();
@endphp

@if(request()->routeIs('products.show'))
    {{-- PAGE PRODUIT : bouton avec infos produit --}}
    @isset($product)
        <div class="fixed bottom-6 left-6 z-50">
            <a href="https://wa.me/221784465192?text=Bonjour%2C%20j%27aimerais%20des%20infos%20sur%20le%20produit%20%22{{ urlencode($product->name) }}%22%20📱%0A%0APrix%3A%20{{ urlencode($product->formatted_price) }}%0ALien%3A%20{{ urlencode(route('products.show', $product)) }}" 
               target="_blank"
               class="relative group bg-green-500 hover:bg-green-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl hover:shadow-green-500/50 hover:scale-110 transition-all duration-300">
                
                <span class="absolute -top-14 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs font-medium px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap text-center">
                    Question sur<br>"{{ Str::limit($product->name, 20) }}" ?
                </span>
                
                <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
            </a>
        </div>
    @endisset

@elseif(request()->routeIs('cart') && $hasCart)
    {{-- PAGE PANIER : bouton avec contenu du panier (connectés + invités) --}}
    @php
        $cartMessage = "Bonjour, je souhaite commander ces articles 🛒\n\n";
        $totalCart = 0;
        
        foreach($cartItems as $item) {
            $productName = $item->product->name;
            $quantity = $item->quantity;
            $price = $item->product->price;
            $subtotal = $price * $quantity;
            $totalCart += $subtotal;
            
            $cartMessage .= "• " . $productName . " (x" . $quantity . ")\n";
            $cartMessage .= "  → " . number_format($price, 0, ',', ' ') . " FCFA × " . $quantity . " = " . number_format($subtotal, 0, ',', ' ') . " FCFA\n\n";
        }
        
        $cartMessage .= "━━━━━━━━━━━━━━━━━\n";
        $cartMessage .= "💰 TOTAL : " . number_format($totalCart, 0, ',', ' ') . " FCFA\n\n";
        $cartMessage .= "📍 Je souhaite passer commande.\n";
        $cartMessage .= "Pouvez-vous me confirmer la disponibilité et les modalités de livraison ?";
    @endphp
    
    <div class="fixed bottom-6 left-6 z-50">
        {{-- Container wrapper avec position relative --}}
        <div class="relative inline-block">
            <a href="https://wa.me/221784465192?text={{ urlencode($cartMessage) }}" 
               target="_blank"
               class="group bg-green-500 hover:bg-green-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl hover:shadow-green-500/50 hover:scale-110 transition-all duration-300 animate-bounce">
                
                <!-- Icône WhatsApp -->
                <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                </svg>
            </a>
            
            {{-- Badge ROUGE - EN DEHORS du lien --}}
            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold rounded-full w-7 h-7 flex items-center justify-center shadow-lg ring-2 ring-white z-10">
                {{ $cartItems->count() }}
            </span>
            
            {{-- Tooltip --}}
            <span class="absolute -top-16 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-xs font-medium px-4 py-2 rounded-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300 whitespace-nowrap text-center shadow-xl pointer-events-none">
                💬 Commander via WhatsApp<br>
                <span class="text-green-300">{{ $cartItems->count() }} article{{ $cartItems->count() > 1 ? 's' : '' }} • {{ number_format($totalCart, 0, ',', ' ') }} FCFA</span>
            </span>
        </div>
    </div>
@else
    {{-- Autres pages : modal avec options --}}
    <div x-data="{ whatsappOpen: false }" class="fixed bottom-6 left-6 z-50">
        <!-- Bouton WhatsApp -->
        <button @click="whatsappOpen = true"
                class="bg-green-500 hover:bg-green-600 text-white rounded-full w-16 h-16 flex items-center justify-center shadow-2xl hover:shadow-green-500/50 hover:scale-110 transition-all duration-300">
            <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
            </svg>
        </button>

        <!-- Modal -->
        <div x-show="whatsappOpen"
             x-cloak
             @click.away="whatsappOpen = false"
             @keydown.escape.window="whatsappOpen = false"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm z-50">
            
            <!-- Container modal avec scroll ✅ CORRECTION ICI -->
            <div @click.stop
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-90"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-90"
                 class="bg-white rounded-3xl shadow-2xl w-full max-w-md max-h-[85vh] flex flex-col relative">
                
                <!-- Header fixe (ne scroll pas) -->
                <div class="flex-shrink-0 p-6 border-b border-gray-100">
                    <!-- Bouton fermer -->
                    <button @click="whatsappOpen = false" 
                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>

                    <!-- Titre -->
                    <div class="text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-3">
                            <svg class="w-10 h-10 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">Comment vous aider ?</h3>
                        <p class="text-sm text-gray-500 mt-1">Choisissez une option pour démarrer</p>
                    </div>
                </div>

                <!-- Options scrollables ✅ CORRECTION ICI -->
                <div class="flex-1 overflow-y-auto p-6 space-y-3">
                    <!-- Option 1 -->
                    <a href="https://wa.me/221784465192?text=Bonjour%2C%20j%27aimerais%20avoir%20des%20informations%20sur%20un%20produit%20📱" 
                       target="_blank"
                       @click="whatsappOpen = false"
                       class="block p-4 rounded-xl border-2 border-gray-100 hover:border-green-500 hover:bg-green-50 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-500 transition-colors">
                                <span class="text-2xl group-hover:scale-110 transition-transform">📱</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Informations produit</h4>
                                <p class="text-sm text-gray-500">Prix, stock, caractéristiques</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-2 group-hover:text-green-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Option 2 -->
                    <a href="https://wa.me/221784465192?text=Bonjour%2C%20je%20souhaite%20suivre%20ma%20commande%20📦" 
                       target="_blank"
                       @click="whatsappOpen = false"
                       class="block p-4 rounded-xl border-2 border-gray-100 hover:border-green-500 hover:bg-green-50 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-500 transition-colors">
                                <span class="text-2xl group-hover:scale-110 transition-transform">📦</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Suivre ma commande</h4>
                                <p class="text-sm text-gray-500">Statut de livraison</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-2 group-hover:text-green-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Option 3 -->
                    <a href="https://wa.me/221784465192?text=Bonjour%2C%20j%27ai%20besoin%20d%27aide%20technique%20🔧" 
                       target="_blank"
                       @click="whatsappOpen = false"
                       class="block p-4 rounded-xl border-2 border-gray-100 hover:border-green-500 hover:bg-green-50 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-500 transition-colors">
                                <span class="text-2xl group-hover:scale-110 transition-transform">🔧</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Support technique</h4>
                                <p class="text-sm text-gray-500">Assistance et dépannage</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-2 group-hover:text-green-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Option 4 -->
                    <a href="https://wa.me/221784465192?text=Bonjour%2C%20je%20souhaite%20obtenir%20un%20devis%20💼" 
                       target="_blank"
                       @click="whatsappOpen = false"
                       class="block p-4 rounded-xl border-2 border-gray-100 hover:border-green-500 hover:bg-green-50 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-500 transition-colors">
                                <span class="text-2xl group-hover:scale-110 transition-transform">💼</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Devis personnalisé</h4>
                                <p class="text-sm text-gray-500">Commande en gros</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-2 group-hover:text-green-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>

                    <!-- Option 5 -->
                    <a href="https://wa.me/221784465192?text=Bonjour%20Mbacol%20Communication%20👋" 
                       target="_blank"
                       @click="whatsappOpen = false"
                       class="block p-4 rounded-xl border-2 border-gray-200 hover:border-green-500 hover:bg-green-50 transition-all duration-200 group">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center group-hover:bg-green-500 transition-colors">
                                <span class="text-2xl group-hover:scale-110 transition-transform">💬</span>
                            </div>
                            <div class="ml-4 flex-1">
                                <h4 class="font-semibold text-gray-900">Autre question</h4>
                                <p class="text-sm text-gray-500">Discutons librement</p>
                            </div>
                            <svg class="w-5 h-5 text-gray-400 ml-2 group-hover:text-green-500 transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endif

<style>
    [x-cloak] { display: none !important; }
</style>


<!-- Bouton Scroll to top -->
<button
    id="scrollToTopBtn"
    aria-label="Revenir en haut"
    class="fixed bottom-6 right-6 z-50 hidden items-center justify-center
        w-12 h-12 rounded-full bg-primary-600 text-white
        shadow-lg hover:bg-primary-700
        transition-all duration-300 ease-in-out
        focus:outline-none focus:ring-2 focus:ring-primary-400"
>
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
    </svg>
</button>
