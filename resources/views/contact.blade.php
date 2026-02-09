@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="bg-gradient-to-br from-primary-600 to-secondary-600 text-white py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-5xl font-bold mb-6">Contactez-nous</h1>
        <p class="text-xl text-primary-100">
            Notre équipe est à votre écoute pour répondre à toutes vos questions
        </p>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        
        <!-- Formulaire -->
        <div>
            <div class="bg-white rounded-xl shadow-lg p-8">
                <h2 class="text-2xl font-bold mb-6">Envoyez-nous un message</h2>
                
                @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 mb-6">
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
                @endif

                <form action="{{ route('contact.send') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <!-- Nom -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name', Auth::user()->name ?? '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" 
                                   name="email" 
                                   value="{{ old('email', Auth::user()->email ?? '') }}"
                                   required
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Téléphone -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input type="tel" 
                                   name="phone" 
                                   value="{{ old('phone') }}"
                                   placeholder="+221 XX XXX XX XX"
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                        </div>

                        <!-- Sujet -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Sujet <span class="text-red-500">*</span>
                            </label>
                            <select name="subject" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent">
                                <option value="">Sélectionnez un sujet</option>
                                <option value="Commande">Question sur une commande</option>
                                <option value="Produit">Information produit</option>
                                <option value="SAV">Service après-vente</option>
                                <option value="Autre">Autre demande</option>
                            </select>
                        </div>

                        <!-- Message -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Message <span class="text-red-500">*</span>
                            </label>
                            <textarea name="message" 
                                      rows="6" 
                                      required
                                      placeholder="Décrivez votre demande..."
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-transparent @error('message') border-red-500 @enderror">{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Bouton -->
                        <button type="submit" 
                                class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 rounded-lg transition duration-200">
                            Envoyer le message
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Informations de contact -->
        <div class="space-y-6">
            
            <!-- Adresse -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Notre Adresse</h3>
                        <p class="text-gray-600">
                            Avenue Cheikh Anta Diop<br>
                            Dakar, Sénégal<br>
                            BP 12345
                        </p>
                    </div>
                </div>
            </div>

            <!-- Téléphone -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Téléphone</h3>
                        <p class="text-gray-600">
                            <a href="tel:+221XXXXXXXXX" class="hover:text-primary-600">+221 XX XXX XX XX</a><br>
                            <a href="tel:+221YYYYYYYYY" class="hover:text-primary-600">+221 YY YYY YY YY</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Email -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Email</h3>
                        <p class="text-gray-600">
                            <a href="mailto:contact@mbacol.sn" class="hover:text-primary-600">contact@mbacol.sn</a><br>
                            <a href="mailto:support@mbacol.sn" class="hover:text-primary-600">support@mbacol.sn</a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Horaires -->
            <div class="bg-white rounded-xl shadow-lg p-8">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center flex-shrink-0">
                        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold mb-2">Horaires d'ouverture</h3>
                        <p class="text-gray-600">
                            <strong>Lun - Ven :</strong> 9h00 - 18h00<br>
                            <strong>Samedi :</strong> 9h00 - 13h00<br>
                            <strong>Dimanche :</strong> Fermé
                        </p>
                    </div>
                </div>
            </div>

            <!-- Réseaux sociaux -->
            <div class="bg-gradient-to-br from-primary-600 to-secondary-600 rounded-xl shadow-lg p-8 text-white">
                <h3 class="text-xl font-bold mb-4">Suivez-nous</h3>
                <div class="flex gap-4">
                    <a href="#" class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center transition">
                        <span class="text-2xl">📘</span>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center transition">
                        <span class="text-2xl">📸</span>
                    </a>
                    <a href="#" class="w-12 h-12 bg-white bg-opacity-20 hover:bg-opacity-30 rounded-full flex items-center justify-center transition">
                        <span class="text-2xl">🐦</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection