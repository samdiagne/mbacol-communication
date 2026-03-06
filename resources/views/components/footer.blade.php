<!-- Footer -->
<footer class="bg-gray-900 text-white mt-0">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <div>
                <img src="{{ asset('images/logo.webp') }}" 
                            alt="Mbacol Logo"
                            class="h-16 w-auto transform scale-150">
                <p class="text-gray-400">Votre partenaire en électronique et matériel au Sénégal.</p>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Liens rapides</h4>
                <ul class="space-y-2 text-gray-400">
                    <li><a href="{{ route('shop') }}" class="hover:text-white transition">Boutique</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white transition">À propos</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white transition">Contact</a></li>
                    <li><a href="{{ route('faq') }}" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="{{ route('terms') }}" class="hover:text-white transition">CGV</a></li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Contact</h4>
                <ul class="space-y-2 text-gray-400">
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        +221 78 446 51 92
                    </li>
                    <li class="flex items-center">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        contact@mbacol.sn
                    </li>
                    <li class="flex items-start">
                        <svg class="w-4 h-4 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <a href="https://maps.app.goo.gl/VwS9Lv4CRGyysLKR9?g_st=ic">Colobane rue 42x45, Dakar - Sénégal</a>
                    </li>
                </ul>
            </div>
            
            <div>
                <h4 class="font-semibold mb-4">Paiements acceptés</h4>

                <div class="flex items-center gap-4 flex-wrap">
                    
                    <img src="{{ asset('images/wave.svg') }}" 
                        alt="Wave" 
                        class="h-8 w-auto">

                    <img src="{{ asset('images/om.svg') }}" 
                        alt="Orange Money" 
                        class="h-8 w-auto">

                    <img src="{{ asset('images/yass.svg') }}" 
                        alt="Free Money" 
                        class="h-8 w-auto">

                    <img src="{{ asset('images/visa.svg') }}" 
                        alt="Visa" 
                        class="h-8 w-auto">

                </div>
            </div>
        </div>
        
        <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
            <p>&copy; {{ date('Y') }} Mbacol Communication. Tous droits réservés.</p>
        </div>
    </div>
</footer>
