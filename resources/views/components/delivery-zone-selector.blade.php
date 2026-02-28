@props(['selectedZone' => null])

<div class="space-y-4">
    <h3 class="text-lg font-semibold flex items-center gap-2">
        <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
        Zone de livraison
    </h3>
    
    @php
    $zones = [
        [
            'id' => 'dakar_centre',
            'name' => 'Dakar Centre',
            'price' => 2000,
            'icon' => '🏙️',
            'areas' => ['Dakar Plateau', 'HLM', 'Coloban', 'Castor', 'Médina', 'Gueule Tapée']
        ],
        [
            'id' => 'dakar_peripherie',
            'name' => 'Dakar Périphérie',
            'price' => 3000,
            'icon' => '🏘️',
            'areas' => ['Parcelle Assainies', 'Yoff', 'Grand Yoff', 'Almadies', 'Ngor', 'Nord Foire', 'Yarakh', 'Hann Mariste', 'Dalifort']
        ],
        [
            'id' => 'banlieue_proche',
            'name' => 'Banlieue Proche',
            'price' => 4000,
            'icon' => '🏡',
            'areas' => ['Guediawaye', 'Pikine', 'Thiaroye', 'Mbao', 'Keur Mbaye Fall', 'Yeumbeul', 'Keur Massar']
        ],
        [
            'id' => 'rufisque',
            'name' => 'Rufisque',
            'price' => 5000,
            'icon' => '🏞️',
            'areas' => ['Rufisque', 'Environs de Rufisque']
        ]
    ];
    @endphp
    
    <div class="space-y-3">
        @foreach($zones as $zone)
        <label class="relative flex items-start p-4 border-2 rounded-xl cursor-pointer transition-all duration-200 hover:border-primary-500 hover:shadow-md group"
               :class="$wire.delivery_zone === '{{ $zone['id'] }}' ? 'border-primary-600 bg-primary-50 ring-2 ring-primary-200' : 'border-gray-200 bg-white'">
            
            <!-- Radio Button -->
            <input type="radio" 
                   wire:model.live="delivery_zone" 
                   value="{{ $zone['id'] }}"
                   data-price="{{ $zone['price'] }}"
                   class="mt-1 h-5 w-5 text-primary-600 focus:ring-primary-500 cursor-pointer"
                   required>
            
            <!-- Contenu -->
            <div class="ml-4 flex-1">
                <!-- En-tête : Nom + Prix -->
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <span class="text-2xl">{{ $zone['icon'] }}</span>
                        <span class="font-bold text-gray-900 text-lg">{{ $zone['name'] }}</span>
                    </div>
                    <span class="text-xl font-bold text-primary-600">
                        {{ number_format($zone['price'], 0, ',', ' ') }} FCFA
                    </span>
                </div>
                
                <!-- Quartiers inclus -->
                <div class="flex flex-wrap gap-1.5">
                    @foreach($zone['areas'] as $area)
                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-700 group-hover:bg-primary-100 group-hover:text-primary-800 transition-colors">
                        {{ $area }}
                    </span>
                    @endforeach
                </div>
            </div>
        </label>
        @endforeach
        
        <!-- Zone personnalisée -->
        <div class="p-4 bg-blue-50 border border-blue-200 rounded-xl">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div class="text-sm text-blue-800">
                    <p class="font-semibold mb-1">Votre zone n'est pas listée ?</p>
                    <p>Contactez-nous au <a href="tel:+221784465192" class="font-bold underline hover:text-blue-900">+221 78 446 51 92</a> pour un devis personnalisé.</p>
                </div>
            </div>
        </div>
    </div>
    
    @error('delivery_zone')
        <p class="text-red-500 text-sm mt-2 flex items-center gap-1">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>