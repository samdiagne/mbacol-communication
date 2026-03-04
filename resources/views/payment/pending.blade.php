@extends('layouts.app')

@section('title', 'Paiement en cours de vérification')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        
        <!-- Card Principale -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            
            <!-- Header avec animation -->
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-10 rounded-full -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-white opacity-10 rounded-full -ml-12 -mb-12"></div>
                
                <div class="relative z-10">
                    <!-- Icône animée -->
                    <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-sm">
                        <svg class="w-10 h-10 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    
                    <h1 class="text-2xl font-bold text-white mb-2">
                        Vérification en cours...
                    </h1>
                    <p class="text-blue-100 text-sm">
                        Nous vérifions votre paiement auprès de PayDunya
                    </p>
                </div>
            </div>

            <!-- Contenu -->
            <div class="p-8">
                <!-- Informations commande -->
                <div class="bg-gradient-to-br from-gray-50 to-blue-50 rounded-xl p-6 mb-6">
                    <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wide mb-4">
                        Détails de votre commande
                    </h3>
                    
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">N° Commande</span>
                            <span class="font-mono text-sm font-bold text-gray-900 bg-white px-3 py-1 rounded-lg">
                                {{ $order->order_number }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                            <span class="text-base font-semibold text-gray-900">Montant</span>
                            <span class="text-2xl font-bold text-blue-600">
                                {{ number_format($order->total, 0, ',', ' ') }} <span class="text-sm">FCFA</span>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Timeline du processus -->
                <div class="mb-6">
                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Paiement initié</p>
                            <p class="text-sm text-gray-500">Vous avez validé le paiement</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3 mb-4">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                            <svg class="w-5 h-5 text-white animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Vérification en cours</p>
                            <p class="text-sm text-gray-500">Confirmation du paiement...</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-400">Confirmation</p>
                            <p class="text-sm text-gray-400">En attente...</p>
                        </div>
                    </div>
                </div>

                <!-- Message informatif -->
                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm text-blue-900 font-semibold mb-1">
                                Veuillez patienter
                            </p>
                            <p class="text-xs text-blue-800">
                                La vérification prend généralement quelques secondes. 
                                Vous serez redirigé automatiquement.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Bouton manuel -->
                <a href="{{ route('customer.orders.show', $order) }}" 
                   class="block w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl text-center transition-all duration-200 shadow-lg hover:shadow-xl">
                    Voir ma commande
                </a>

                <p class="text-xs text-center text-gray-500 mt-4">
                    Référence transaction : <span class="font-mono">{{ $payment->transaction_id }}</span>
                </p>
            </div>

            <!-- Footer -->
            <div class="bg-gray-50 px-8 py-4 border-t border-gray-100">
                <div class="flex items-center justify-center gap-2 text-xs text-gray-500">
                    <svg class="w-4 h-4 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                    <span class="font-semibold">Paiement sécurisé</span>
                    <span>•</span>
                    <span>PayDunya</span>
                </div>
            </div>
        </div>

        <!-- Message supplémentaire -->
        <div class="mt-6 text-center text-sm text-gray-600 bg-white bg-opacity-70 backdrop-blur-sm rounded-xl p-4">
            <p>
                Si la page ne se rafraîchit pas automatiquement, 
                <a href="{{ route('customer.orders.show', $order) }}" class="text-blue-600 font-semibold underline hover:text-blue-800">
                    cliquez ici
                </a>
            </p>
        </div>
    </div>
</div>

<!-- Auto-refresh et check status -->
<script>
    let checkCount = 0;
    const maxChecks = 20; // 20 checks × 3s = 60s max
    
    function checkPaymentStatus() {
        checkCount++;
        
        // Arrêter après 60 secondes
        if (checkCount >= maxChecks) {
            console.log('Max checks reached, stopping auto-refresh');
            return;
        }
        
        // Recharger la page pour vérifier le statut
        fetch('{{ route("customer.orders.show", $order) }}')
            .then(response => {
                if (response.ok) {
                    // Si la commande est confirmée, rediriger
                    window.location.href = '{{ route("customer.orders.show", $order) }}';
                }
            })
            .catch(error => {
                console.error('Error checking status:', error);
            });
    }
    
    // Vérifier toutes les 3 secondes
    const checkInterval = setInterval(() => {
        checkPaymentStatus();
    }, 3000);
    
    // Redirection automatique après 10 secondes minimum
    setTimeout(() => {
        window.location.href = '{{ route("customer.orders.show", $order) }}';
    }, 10000);
</script>
@endsection
