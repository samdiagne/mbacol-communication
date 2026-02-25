@extends('layouts.app')

@section('title', 'Paiement en cours')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center px-4 py-12">
    <div class="max-w-md w-full">
        
        <!-- Card Simulation -->
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header avec logo opérateur -->
            <div class="bg-gradient-to-r {{ $method === 'wave' ? 'from-blue-600 to-blue-700' : 'from-orange-500 to-orange-600' }} p-8 text-center">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                    @if($method === 'wave')
                        <span class="text-4xl">🌊</span>
                    @else
                        <span class="text-4xl">🍊</span>
                    @endif
                </div>
                <h2 class="text-2xl font-bold text-white mb-2">
                    {{ $method === 'wave' ? 'Wave' : 'Orange Money' }}
                </h2>
                <p class="text-blue-100">Mode Sandbox - Simulation</p>
            </div>

            <!-- Corps -->
            <div class="p-8">
                <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-6 rounded-r-lg">
                    <div class="flex">
                        <svg class="w-6 h-6 text-yellow-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-yellow-800 mb-1">Mode Test Activé</h3>
                            <p class="text-sm text-yellow-700">
                                Aucun paiement réel ne sera effectué. Cliquez sur "Confirmer" pour simuler un paiement réussi.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Détails commande -->
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4">Détails de la transaction</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Commande :</span>
                            <span class="font-semibold">{{ $order->order_number }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Montant :</span>
                            <span class="font-bold text-lg text-gray-900">{{ number_format($order->total, 0, ',', ' ') }} FCFA</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Bénéficiaire :</span>
                            <span class="font-semibold">Mbacol Communication</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <form action="{{ route('payment.simulate.confirm', $order) }}" method="POST" class="space-y-3">
                    @csrf
                    
                    <button type="submit" 
                            name="action" 
                            value="success"
                            class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-[1.02]">
                        ✅ Confirmer le paiement
                    </button>

                    <button type="submit" 
                            name="action" 
                            value="cancel"
                            class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-4 rounded-xl transition-all duration-200">
                        ❌ Annuler le paiement
                    </button>
                </form>

                <p class="text-xs text-center text-gray-500 mt-4">
                    🔒 Paiement sécurisé - Mode développement
                </p>
            </div>
        </div>

        <!-- Info supplémentaire -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                En production, vous serez redirigé vers l'interface {{ $method === 'wave' ? 'Wave' : 'Orange Money' }} réelle
            </p>
        </div>
    </div>
</div>
@endsection