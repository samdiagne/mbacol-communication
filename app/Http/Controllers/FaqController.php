<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class FaqController extends Controller
{
    public function index()
    {
        // SEO Meta Tags
        SEOMeta::setTitle('Questions Fréquentes (FAQ) - Mbacol Communication')
            ->setDescription('Trouvez les réponses à toutes vos questions sur nos produits, la livraison, le paiement et les garanties. Support client Mbacol Communication Sénégal.')
            ->setKeywords([
                'FAQ Mbacol Communication',
                'questions fréquentes électronique Sénégal',
                'aide livraison Dakar',
                'paiement Wave Orange Money',
                'garantie produits électroniques',
                'support client Sénégal'
            ])
            ->setCanonical(route('faq'))
            ->addMeta('robots', 'index, follow');

        // Open Graph
        OpenGraph::setTitle('FAQ - Mbacol Communication')
            ->setDescription('Réponses à vos questions sur la livraison, le paiement, les garanties.')
            ->setUrl(route('faq'))
            ->setType('website');

        // Twitter Card
        TwitterCard::setTitle('FAQ - Mbacol Communication')
            ->setDescription('Questions fréquentes - Support client');

        // JSON-LD FAQPage Schema
        $faqSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => []
        ];

        // Questions FAQ
        $faqs = $this->getFaqs();

        foreach ($faqs as $category) {
            foreach ($category['questions'] as $faq) {
                $faqSchema['mainEntity'][] = [
                    '@type' => 'Question',
                    'name' => $faq['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $faq['answer']
                    ]
                ];
            }
        }

        JsonLd::addValues($faqSchema);

        return view('faq', compact('faqs'));
    }

    private function getFaqs()
    {
        return [
            [
                'category' => '🛍️ Commande & Paiement',
                'icon' => 'shopping-cart',
                'questions' => [
                    [
                        'question' => 'Quels modes de paiement acceptez-vous ?',
                        'answer' => 'Nous acceptons Wave, Orange Money, Free Money et le paiement à la livraison (espèces). Tous les paiements sont sécurisés.'
                    ],
                    [
                        'question' => 'Comment passer une commande ?',
                        'answer' => 'Ajoutez vos produits au panier, cliquez sur "Passer commande", remplissez vos informations de livraison et choisissez votre mode de paiement. Vous recevrez une confirmation par email.'
                    ],
                    [
                        'question' => 'Puis-je modifier ma commande après validation ?',
                        'answer' => 'Oui, contactez-nous rapidement par WhatsApp au +221 78 446 51 92 ou par email. Si la commande n\'est pas encore expédiée, nous pourrons la modifier.'
                    ],
                    [
                        'question' => 'Puis-je annuler ma commande ?',
                        'answer' => 'Oui, vous pouvez annuler avant expédition en nous contactant. Le remboursement sera effectué sous 3-5 jours ouvrés.'
                    ],
                ]
            ],
            [
                'category' => '🚚 Livraison',
                'icon' => 'truck',
                'questions' => [
                    [
                        'question' => 'Quels sont les délais de livraison ?',
                        'answer' => 'Livraison à Dakar : 24-48h. Régions : 3-5 jours ouvrés. Livraison express disponible (supplément).'
                    ],
                    [
                        'question' => 'Quels sont les frais de livraison ?',
                        'answer' => 'Dakar : 2 000 FCFA. Régions : 3 500 FCFA. Livraison GRATUITE pour commandes > 100 000 FCFA.'
                    ],
                    [
                        'question' => 'Comment suivre ma commande ?',
                        'answer' => 'Connectez-vous à votre compte, section "Mes commandes". Vous recevrez aussi des notifications SMS/Email à chaque étape.'
                    ],
                    [
                        'question' => 'Livrez-vous partout au Sénégal ?',
                        'answer' => 'Oui, nous livrons dans toutes les régions du Sénégal via nos partenaires logistiques de confiance.'
                    ],
                ]
            ],
            [
                'category' => '📦 Produits & Stock',
                'icon' => 'package',
                'questions' => [
                    [
                        'question' => 'Les produits sont-ils neufs et authentiques ?',
                        'answer' => 'Oui, 100% neufs, scellés et authentiques avec garantie constructeur. Nous travaillons uniquement avec des fournisseurs officiels.'
                    ],
                    [
                        'question' => 'Quelle est la durée de la garantie ?',
                        'answer' => 'Garantie constructeur : 12 mois minimum. Certains produits bénéficient de 24 mois. Conditions détaillées sur chaque fiche produit.'
                    ],
                    [
                        'question' => 'Que faire si le produit est défectueux ?',
                        'answer' => 'Contactez-nous sous 48h. Nous organisons le retour gratuit et le remplacement ou remboursement selon votre choix.'
                    ],
                    [
                        'question' => 'Puis-je retourner un produit ?',
                        'answer' => 'Oui, sous 7 jours si non ouvert/utilisé. Frais de retour à votre charge sauf défaut. Remboursement sous 5-7 jours.'
                    ],
                ]
            ],
            [
                'category' => '🔐 Sécurité & Compte',
                'icon' => 'shield',
                'questions' => [
                    [
                        'question' => 'Mes données sont-elles sécurisées ?',
                        'answer' => 'Oui, nous utilisons le protocole HTTPS et cryptons toutes vos données. Nous ne partageons jamais vos informations avec des tiers.'
                    ],
                    [
                        'question' => 'Ai-je besoin d\'un compte pour commander ?',
                        'answer' => 'Non, mais créer un compte vous permet de suivre vos commandes, gérer vos adresses et profiter d\'offres exclusives.'
                    ],
                    [
                        'question' => 'Comment réinitialiser mon mot de passe ?',
                        'answer' => 'Cliquez sur "Mot de passe oublié" sur la page de connexion, entrez votre email, et suivez les instructions.'
                    ],
                ]
            ],
            [
                'category' => '📞 Support Client',
                'icon' => 'headphones',
                'questions' => [
                    [
                        'question' => 'Comment vous contacter ?',
                        'answer' => 'WhatsApp : +221 78 446 51 92 | Email : contact@mbacolcommunication.sn | Téléphone : +221 33 123 45 67 | Lun-Sam : 8h-20h'
                    ],
                    [
                        'question' => 'Proposez-vous une assistance technique ?',
                        'answer' => 'Oui, notre équipe technique vous aide à configurer vos appareils et résoudre les problèmes courants. Service gratuit.'
                    ],
                    [
                        'question' => 'Avez-vous une boutique physique ?',
                        'answer' => 'Oui, visitez-nous : Colobane rue 42x45, Dakar. Horaires : Lun-Sam 8h-20h.'
                    ],
                ]
            ],
        ];
    }
}