<?php

namespace App\Http\Controllers;

use App\Traits\HasSEO;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;
use Artesaos\SEOTools\Facades\JsonLd;

class AboutController extends Controller
{
    use HasSEO;

    public function index()
    {
        SEOMeta::setTitle('À propos - Mbacol Communication | Khouma et Frères')
            ->setDescription('Mbacol Communication (Khouma et Frères) : spécialiste import/export de matériel électronique professionnel à Dakar, Sénégal. Chargeurs, stations de soudage, microscopes, outils de réparation.')
            ->setKeywords(['Mbacol Communication', 'Khouma et Frères', 'à propos', 'import export électronique Dakar', 'qui sommes-nous', 'boutique électronique Sénégal'])
            ->setCanonical(route('about'))
            ->addMeta('robots', 'index, follow');

        $this->setDefaultSocialTags(
            'À propos de Mbacol Communication - Khouma et Frères',
            'Spécialiste import/export de matériel électronique professionnel à Dakar, Sénégal.',
            route('about')
        );

        JsonLd::addValues([
            '@context' => 'https://schema.org',
            '@type' => 'AboutPage',
            'name' => 'À propos de Mbacol Communication',
            'url' => route('about'),
            'description' => 'Mbacol Communication (Khouma et Frères) : import/export matériel électronique professionnel au Sénégal.',
            'mainEntity' => [
                '@type' => 'Organization',
                'name' => 'Mbacol Communication',
                'alternateName' => 'Khouma et Frères',
                'url' => route('home'),
                'logo' => asset('images/logo.webp'),
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Colobane rue 43×45',
                    'addressLocality' => 'Dakar',
                    'addressCountry' => 'SN',
                ],
                'contactPoint' => [
                    '@type' => 'ContactPoint',
                    'telephone' => '+221-78-446-51-92',
                    'contactType' => 'Service client',
                ],
            ],
        ]);

        return view('about');
    }
}
