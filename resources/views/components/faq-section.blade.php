@props(['limit' => null, 'compact' => false])

@php
    $faqs = [
        [
            'category' => '🛍️ Commande & Paiement',
            'questions' => [
                ['question' => 'Quels modes de paiement acceptez-vous ?', 'answer' => 'Nous acceptons Wave, Orange Money, Free Money, Carte bancaire et le paiement à la livraison (espèces). Tous les paiements sont sécurisés.'],
                ['question' => 'Comment passer une commande ?', 'answer' => 'Ajoutez vos produits au panier, cliquez sur "Passer commande", remplissez vos informations de livraison et choisissez votre mode de paiement. Vous recevrez une confirmation par email.'],
            ]
        ],
        [
            'category' => '🚚 Livraison',
            'questions' => [
                ['question' => 'Quels sont les délais de livraison ?', 'answer' => 'Livraison à Dakar : 24-48h. Régions : 3-5 jours ouvrés. Livraison express disponible (supplément).'],
                ['question' => 'Quels sont les frais de livraison ?', 'answer' => 'Dakar : Entre 1 500 et 5 000 FCFA selon la zone. Régions : Demandez un devis personnalisé. Livraison GRATUITE pour commandes > 100 000 FCFA.'],
            ]
        ],
        [
            'category' => '📦 Produits & Stock',
            'questions' => [
                ['question' => 'Les produits sont-ils neufs et authentiques ?', 'answer' => 'Oui, 100% neufs, scellés et authentiques avec garantie constructeur. Nous travaillons uniquement avec des fournisseurs officiels.'],
                ['question' => 'Quelle est la durée de la garantie ?', 'answer' => 'Garantie constructeur : 12 mois minimum. Certains produits bénéficient de 24 mois. Conditions détaillées sur chaque fiche produit.'],
            ]
        ],
        [
            'category' => '📞 Support Client',
            'questions' => [
                ['question' => 'Comment vous contacter ?', 'answer' => 'WhatsApp : +221 78 446 51 92 | Email : contact@mbacolcommunication.sn | Lun-Sam : 8h-20h'],
                ['question' => 'Avez-vous une boutique physique ?', 'answer' => 'Oui, visitez-nous : Colobane rue 42x45, Dakar. Horaires : Lun-Sam 8h-20h.'],
            ]
        ],
    ];

    // Limiter le nombre de catégories si demandé
    if ($limit) {
        $faqs = array_slice($faqs, 0, $limit);
    }
@endphp

<div {{ $attributes->merge(['class' => 'py-16 bg-gradient-to-br from-gray-50 to-primary-50/20']) }}>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="text-center mb-12 scroll-reveal">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-2xl mb-4 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-3">
                Questions Fréquentes
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Trouvez rapidement les réponses à vos questions
            </p>
        </div>

        <!-- FAQ Grid -->
        <div class="grid grid-cols-1 {{ $compact ? 'lg:grid-cols-2' : 'lg:grid-cols-1 max-w-4xl mx-auto' }} gap-8">
            @foreach($faqs as $categoryIndex => $category)
            <div class="scroll-reveal delay-{{ $categoryIndex * 100 }}">
                <!-- Category Header -->
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-xl flex items-center justify-center flex-shrink-0">
                        <span class="text-2xl">{{ explode(' ', $category['category'])[0] }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">
                        {{ substr($category['category'], strpos($category['category'], ' ') + 1) }}
                    </h3>
                </div>

                <!-- Questions -->
                <div class="space-y-3" x-data="{ openIndex: null }">
                    @foreach($category['questions'] as $index => $faq)
                    @php
                        $globalIndex = $categoryIndex . '-' . $index;
                    @endphp
                    <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow duration-200 overflow-hidden border border-gray-100">
                        <button @click="openIndex === '{{ $globalIndex }}' ? openIndex = null : openIndex = '{{ $globalIndex }}'"
                                class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors">
                            <span class="font-semibold text-gray-900 pr-4 flex-1 text-sm">
                                {{ $faq['question'] }}
                            </span>
                            <svg class="w-5 h-5 text-primary-600 flex-shrink-0 transition-transform duration-200"
                                 :class="{ 'rotate-180': openIndex === '{{ $globalIndex }}' }"
                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div x-show="openIndex === '{{ $globalIndex }}'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             style="display: none;"
                             class="px-5 pb-5">
                            <div class="pt-4 border-t border-gray-200">
                                <p class="text-gray-700 leading-relaxed text-sm">
                                    {{ $faq['answer'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div>

        <!-- CTA Voir Plus -->
        @if($limit)
        <div class="text-center mt-12 scroll-reveal">
            <a href="{{ route('faq') }}" 
               class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-600 to-secondary-600 text-white font-bold px-8 py-4 rounded-xl hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
                Voir toutes les questions
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>
        @endif

        <!-- CTA Contact (si pas de limite) -->
        @if(!$limit)
        <div class="mt-12 scroll-reveal bg-gradient-to-br from-primary-600 to-secondary-600 rounded-2xl p-8 text-center text-white shadow-2xl">
            <h3 class="text-2xl font-bold mb-3">Vous ne trouvez pas votre réponse ?</h3>
            <p class="text-white/90 mb-6 max-w-xl mx-auto">
                Notre équipe est là pour vous aider ! Contactez-nous par WhatsApp, email ou téléphone.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="https://wa.me/221784465192" 
                   target="_blank"
                   class="inline-flex items-center justify-center bg-white text-green-600 font-bold px-6 py-3 rounded-xl hover:bg-gray-100 transition shadow-lg">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                    WhatsApp
                </a>
                <a href="{{ route('contact') }}" 
                   class="inline-flex items-center justify-center bg-white/10 backdrop-blur-sm border-2 border-white text-white font-bold px-6 py-3 rounded-xl hover:bg-white/20 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    Nous Contacter
                </a>
            </div>
        </div>
        @endif
    </div>
</div>