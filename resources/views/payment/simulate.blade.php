@extends('layouts.app')

@section('title', 'Paiement Wave')

@section('content')
<style>
    .wave-gradient {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
    }
    @keyframes pulse-slow {
        0%, 100% { opacity: 1; }
        50% { opacity: .7; }
    }
    .pulse-animation {
        animation: pulse-slow 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
    }
</style>

<div class="min-h-screen bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 flex items-center justify-center px-4 py-12">
    
    <!-- Container Principal -->
    <div class="w-full max-w-md">
        
        <!-- Badge Mode Sandbox -->
        <div class="bg-yellow-400 text-yellow-900 text-center py-3 px-4 rounded-t-2xl font-bold text-sm shadow-lg flex items-center justify-center gap-2 animate-pulse">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>MODE SANDBOX - SIMULATION DE PAIEMENT</span>
        </div>

        <!-- Card Principale -->
        <div class="bg-white rounded-b-2xl shadow-2xl overflow-hidden">
            
            <!-- Header Wave -->
            <div class="wave-gradient p-8 text-center relative overflow-hidden">
                <!-- Cercles décoratifs -->
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16 pulse-animation"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full -ml-12 -mb-12 pulse-animation" style="animation-delay: 1s;"></div>
                
                <div class="relative z-10">
                    <!-- Logo Wave -->
                    <div class="mb-4 flex justify-center">
                        <img src="{{ asset('images/payment/wave.png') }}" 
                             alt="Wave" 
                             class="w-20 h-20 drop-shadow-lg">
                    </div>
                    
                    <h1 class="text-3xl font-bold text-white mb-2">Wave</h1>
                    <p class="text-indigo-100 text-sm font-medium">Paiement Mobile Money</p>
                </div>
            </div>

            <!-- Détails Commande -->
            <div class="p-6 border-b border-gray-100 bg-gradient-to-br from-gray-50 to-white">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-primary-500 to-secondary-500 rounded-xl flex items-center justify-center shadow-md">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide font-semibold">Marchand</p>
                        <p class="font-bold text-gray-900 text-lg">Mbacol Communication</p>
                    </div>
                </div>

                <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
                    <div class="flex justify-between items-center mb-3">
                        <span class="text-sm text-gray-600">N° Commande</span>
                        <span class="font-mono text-sm font-bold text-gray-900 bg-gray-100 px-3 py-1 rounded-lg">{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <span class="text-lg font-semibold text-gray-900">Montant à payer</span>
                        <div class="text-right">
                            <span class="text-3xl font-bold text-indigo-600 block">{{ number_format($order->total, 0, ',', ' ') }}</span>
                            <span class="text-sm text-gray-500">FCFA</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informations Client -->
            <div class="p-6 border-b border-gray-100">
                <h3 class="text-xs font-bold text-gray-500 mb-4 uppercase tracking-wider flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informations du client
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between py-2">
                        <span class="text-sm text-gray-600">Nom</span>
                        <span class="text-sm font-semibold text-gray-900">{{ $order->customer_name }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-t border-gray-100">
                        <span class="text-sm text-gray-600">Téléphone</span>
                        <span class="text-sm font-bold text-gray-900 font-mono bg-indigo-50 px-3 py-1 rounded-lg">{{ $order->customer_phone }}</span>
                    </div>
                    <div class="flex items-center justify-between py-2 border-t border-gray-100">
                        <span class="text-sm text-gray-600">Email</span>
                        <span class="text-xs font-medium text-gray-700 break-words max-w-[200px] text-right">{{ $order->customer_email }}</span>
                    </div>
                </div>
            </div>

            <!-- Instructions -->
            <div class="p-6 bg-blue-50 border-b border-blue-100">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-blue-900 mb-2 flex items-center gap-2">
                            <span class="text-lg">📱</span>
                            Comment effectuer le paiement ?
                        </p>
                        <ol class="text-sm text-blue-800 space-y-1.5">
                            <li class="flex items-start gap-2">
                                <span class="font-bold text-blue-600 flex-shrink-0">1.</span>
                                <span>Cliquez sur "Confirmer le paiement"</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="font-bold text-blue-600 flex-shrink-0">2.</span>
                                <span>Vous recevrez une notification sur votre app Wave</span>
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="font-bold text-blue-600 flex-shrink-0">3.</span>
                                <span>Validez le paiement avec votre code PIN</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>

            <!-- Actions (Form) -->
            <form method="POST" action="{{ route('payment.simulate.confirm', $order) }}" class="p-6" id="paymentForm">
                @csrf
                
                <!-- Bouton Payer -->
                <button type="submit" 
                        name="action" 
                        value="success"
                        class="w-full wave-gradient text-white font-bold py-4 px-6 rounded-xl text-lg shadow-lg hover:shadow-2xl transform hover:scale-[1.02] active:scale-[0.98] transition-all duration-200 mb-3 flex items-center justify-center gap-3 group">
                    <svg class="w-6 h-6 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>Confirmer le paiement</span>
                </button>

                <!-- Bouton Annuler -->
                <button type="submit" 
                        name="action" 
                        value="cancel"
                        class="w-full bg-white border-2 border-gray-200 hover:border-gray-300 hover:bg-gray-50 text-gray-700 font-semibold py-3 px-6 rounded-xl transition-all duration-200 flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    <span>Annuler le paiement</span>
                </button>
            </form>

            <!-- Footer Sécurité -->
            <div class="px-6 pb-6 pt-2">
                <div class="flex flex-wrap items-center justify-center gap-2 text-xs text-gray-500">
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                        </svg>
                        <span class="font-semibold">Paiement 100% sécurisé</span>
                    </div>
                    <span>•</span>
                    <span>Wave Sénégal</span>
                    <span>•</span>
                    <span class="text-yellow-600 font-semibold">Mode Test</span>
                </div>
            </div>
        </div>

        <!-- Footer Info -->
        <div class="mt-6 text-center text-sm text-white bg-white bg-opacity-20 backdrop-blur-sm rounded-xl p-4 shadow-lg">
            <p class="font-medium leading-relaxed">
                En confirmant, vous acceptez de payer 
                <span class="font-bold text-yellow-300">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span> 
                à <span class="font-bold">Mbacol Communication</span>
            </p>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div id="loadingOverlay" class="hidden fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm items-center justify-center z-50">
    <div class="bg-white rounded-2xl p-8 text-center shadow-2xl max-w-sm mx-4">
        <div class="w-20 h-20 border-4 border-indigo-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-xl font-bold text-gray-900 mb-2">Traitement en cours...</p>
        <p class="text-sm text-gray-600">Veuillez patienter pendant la validation</p>
    </div>
</div>

<script>
    // Afficher loading lors de la soumission (seulement pour success)
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        const action = e.submitter.value;
        if (action === 'success') {
            setTimeout(() => {
                document.getElementById('loadingOverlay').classList.remove('hidden');
            }, 100);
        }
    });
</script>
@endsection
