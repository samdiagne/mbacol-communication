@extends('layouts.app')

@section('title', 'À propos')

@section('content')
<div class="relative overflow-hidden bg-gradient-to-br from-primary-700 via-primary-600 to-secondary-600 text-white py-24">
    
    <!-- Background pattern léger -->
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-72 h-72 bg-white rounded-full blur-3xl"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl md:text-6xl font-extrabold mb-6 leading-tight">
            À propos de 
            <span class="bg-white/20 px-3 py-1 rounded-lg">
                Mbacol Communication
            </span>
        </h1>

        <p class="text-lg md:text-xl text-primary-100 max-w-3xl mx-auto leading-relaxed">
            Votre partenaire de confiance en électronique et matériel informatique au Sénégal,
            avec un service professionnel et des produits 100% authentiques.
        </p>
    </div>
</div>


<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <!-- Notre histoire -->
    <div class="mb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-3xl font-bold text-gray-900 mb-6">Notre Histoire</h2>
                <div class="space-y-4 text-gray-700 text-lg leading-relaxed">
                    <p>
                        Fondée au cœur de Dakar, <strong class="text-primary-600">Mbacol Communication</strong> 
                        est née de la passion pour la technologie et du désir de rendre l'électronique 
                        de qualité accessible à tous les Sénégalais.
                    </p>
                    <p>
                        Depuis notre création, nous nous engageons à offrir une sélection rigoureuse 
                        de produits électroniques, des derniers smartphones aux ordinateurs performants, 
                        en passant par tous les accessoires dont vous avez besoin.
                    </p>
                    <p>
                        Notre mission est simple : <strong>vous offrir le meilleur de la technologie 
                        avec un service client exceptionnel</strong>.
                    </p>
                </div>
            </div>
            <div class="relative bg-white shadow-xl rounded-3xl p-10 h-96 flex items-center justify-center border border-gray-100">
                <div class="text-center">
                    <div class="text-7xl mb-4">🏪</div>
                    <p class="text-3xl font-extrabold text-primary-600">Depuis 2020</p>
                    <p class="space-y-5 text-gray-600 text-lg leading-relaxed">À votre service au Sénégal</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Nos valeurs -->
    <div class="mb-20">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Nos Valeurs</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="group bg-white rounded-2xl border border-gray-100 p-10 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">        
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                    <span class="text-3xl">✓</span>
                </div>

                <h3 class="text-xl font-bold mb-3 text-gray-900">
                    Qualité Garantie
                </h3>

                <p class="text-gray-600 leading-relaxed">
                    Tous nos produits sont authentiques et bénéficient d'une garantie constructeur.
                </p>
            </div>
            <div class="group bg-white rounded-2xl border border-gray-100 p-10 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">        
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                    <span class="text-3xl">🚚</span>
                </div>

                <h3 class="text-xl font-bold mb-3">Livraison Rapide</h3>
                <p class="text-gray-600 leading-relaxed">
                    Livraison à domicile dans tout Dakar et ses environs en 24-48h.
                </p>
            </div>

            <div class="group bg-white rounded-2xl border border-gray-100 p-10 text-center hover:shadow-2xl hover:-translate-y-2 transition-all duration-300">
                <div class="w-16 h-16 bg-gradient-to-br from-primary-100 to-secondary-100 rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition">
                    <span class="text-3xl">💳</span>
                </div>
                <h3 class="text-xl font-bold mb-3">Paiement Flexible</h3>
                <p class="text-gray-600 leading-relaxed">
                    Wave, Orange Money, Free Money, Paiement bancaire ou paiement à la livraison.
                </p>
            </div>
        </div>
    </div>

    <!-- Chiffres clés -->
    <div class="bg-gradient-to-br from-primary-600 to-secondary-600 rounded-2xl p-12 mb-20">
        <h2 class="text-3xl font-bold text-white mb-12 text-center">Mbacol en Chiffres</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center text-white">
            <div>
                <p class="text-5xl md:text-6xl font-extrabold mb-2">500+</p>
                <p class="text-primary-100 uppercase tracking-wider text-sm">Produits</p>
            </div>
            <div>
                <p class="text-5xl md:text-6xl font-extrabold mb-2">2K+</p>
                <p class="text-primary-100 uppercase tracking-wider text-sm">Clients satisfaits</p>
            </div>
            <div>
                <p class="text-5xl md:text-6xl font-extrabold mb-2">24/7</p>
                <p class="text-primary-100 uppercase tracking-wider text-sm">Support client</p>
            </div>
            <div>
                <p class="text-5xl md:text-6xl font-extrabold mb-2">100%</p>
                <p class="text-primary-100 uppercase tracking-wider text-sm">Satisfaction</p>
            </div>
        </div>
    </div>

    <!-- Pourquoi nous choisir -->
    <div class="mb-20">
        <h2 class="text-3xl font-bold text-gray-900 mb-12 text-center">Pourquoi Choisir Mbacol ?</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex gap-5 p-6 bg-white border border-gray-100 rounded-2xl hover:shadow-lg transition">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold mb-2">Prix Compétitifs</h3>
                    <p class="text-gray-600">Les meilleurs prix du marché avec des promotions régulières</p>
                </div>
            </div>

            <div class="flex gap-5 p-6 bg-white border border-gray-100 rounded-2xl hover:shadow-lg transition">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold mb-2">Produits Authentiques</h3>
                    <p class="text-gray-600">100% originaux avec garantie constructeur officielle</p>
                </div>
            </div>

            <div class="flex gap-5 p-6 bg-white border border-gray-100 rounded-2xl hover:shadow-lg transition">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold mb-2">Service Après-Vente</h3>
                    <p class="text-gray-600">Équipe dédiée pour vous accompagner après votre achat</p>
                </div>
            </div>

            <div class="flex gap-5 p-6 bg-white border border-gray-100 rounded-2xl hover:shadow-lg transition">
                <div class="flex-shrink-0 w-12 h-12 bg-gradient-to-br from-green-100 to-green-200 rounded-xl flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-bold mb-2">Conseils Experts</h3>
                    <p class="text-gray-600">Notre équipe vous guide dans le choix du produit idéal</p>
                </div>
            </div>
        </div>
    </div>

    <!-- CTA -->
    <div class="relative overflow-hidden bg-gradient-to-br from-primary-600 to-secondary-600 rounded-3xl p-16 text-center text-white shadow-2xl">
    
    <h2 class="text-3xl md:text-4xl font-extrabold mb-6">
        Prêt à découvrir nos produits ?
    </h2>

    <p class="text-lg md:text-xl text-primary-100 mb-10">
        Explorez notre catalogue et trouvez le produit parfait pour vous.
    </p>

    <a href="{{ route('shop') }}"
       class="inline-block bg-white text-primary-600 font-bold py-4 px-14 rounded-xl text-lg hover:scale-105 hover:shadow-xl transition-all duration-300">
        Voir la boutique
    </a>
    </div>

</div>
@endsection