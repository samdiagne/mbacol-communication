@extends('layouts.app')

@section('title', 'Conditions Générales de Vente')

@section('content')
<div class="bg-gray-100 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="bg-white rounded-lg shadow-lg p-8 md:p-12">
            <h1 class="text-4xl font-bold text-gray-900 mb-8">Conditions Générales de Vente</h1>
            
            <p class="text-sm text-gray-600 mb-8">Dernière mise à jour : {{ date('d/m/Y') }}</p>

            <div class="prose prose-lg max-w-none">
                
                <h2 class="text-2xl font-bold mt-8 mb-4">1. Présentation</h2>
                <p>
                    Les présentes Conditions Générales de Vente (CGV) régissent les ventes de produits électroniques 
                    et informatiques proposés par Mbacol Communication sur le site mbacol.sn.
                </p>
                <p>
                    En passant commande sur notre site, vous acceptez sans réserve les présentes CGV.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">2. Produits</h2>
                <p>
                    Tous nos produits sont neufs, authentiques et bénéficient de la garantie constructeur officielle.
                    Les caractéristiques des produits sont décrites de manière précise sur chaque fiche produit.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">3. Prix</h2>
                <p>
                    Les prix sont indiqués en Francs CFA (FCFA) toutes taxes comprises. 
                    Mbacol Communication se réserve le droit de modifier ses prix à tout moment, 
                    mais les produits seront facturés sur la base des tarifs en vigueur au moment de la validation de la commande.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">4. Commande</h2>
                <p>
                    Pour passer commande, vous devez :
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Sélectionner les produits et les ajouter à votre panier</li>
                    <li>Valider votre panier</li>
                    <li>Renseigner vos coordonnées de livraison</li>
                    <li>Choisir votre mode de paiement</li>
                    <li>Confirmer votre commande</li>
                </ul>
                <p>
                    La confirmation de commande vaut acceptation des présentes CGV et constitue 
                    une preuve du contrat de vente.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">5. Paiement</h2>
                <p>
                    Nous acceptons les modes de paiement suivants :
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Wave</li>
                    <li>Orange Money</li>
                    <li>Free Money</li>
                    <li>Carte bancaire</li>
                    <li>Espèces à la livraison</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">6. Livraison</h2>
                <p>
                    Les livraisons sont effectuées dans un délai de 24 à 48 heures pour Dakar et ses environs.
                    Les frais de livraison s'élèvent entre 1 500 et 4000 FCFA selon la zone.
                </p>
                <p>
                    Le délai de livraison court à compter de la validation du paiement.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">7. Droit de rétractation</h2>
                <p>
                    Conformément à la réglementation en vigueur au Sénégal, vous disposez d'un délai de 7 jours 
                    à compter de la réception de votre commande pour exercer votre droit de rétractation.
                </p>
                <p>
                    Les produits doivent être retournés dans leur emballage d'origine, complets et en parfait état.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">8. Garantie</h2>
                <p>
                    Tous nos produits bénéficient de la garantie constructeur dont la durée varie selon les produits 
                    (généralement 1 an). Les modalités de la garantie sont précisées sur la fiche produit.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">9. Service après-vente</h2>
                <p>
                    Notre service client est à votre disposition pour toute question ou réclamation :
                </p>
                <ul class="list-disc pl-6 mb-4">
                    <li>Email : djilykhou423@gmail.com</li>
                    <li>Téléphone : +221 78 446 51 92</li>
                </ul>

                <h2 class="text-2xl font-bold mt-8 mb-4">10. Protection des données</h2>
                <p>
                    Vos données personnelles sont collectées et traitées dans le respect de la réglementation 
                    en vigueur. Elles sont utilisées uniquement pour le traitement de votre commande et ne 
                    sont jamais transmises à des tiers sans votre consentement.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">11. Litiges</h2>
                <p>
                    En cas de litige, une solution amiable sera recherchée avant toute action judiciaire. 
                    À défaut, les tribunaux sénégalais seront seuls compétents.
                </p>

                <h2 class="text-2xl font-bold mt-8 mb-4">12. Contact</h2>
                <p class="font-semibold">
                    Mbacol Communication<br>
                    Email : djilykhou423@gmail.com<br>
                    Téléphone : +221 78 446 51 92<br>
                    Adresse : Colobane - Dakar, Sénégal
                </p>
            </div>
        </div>
    </div>
</div>
@endsection