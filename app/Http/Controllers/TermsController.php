<?php

namespace App\Http\Controllers;

use App\Traits\HasSEO;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class TermsController extends Controller
{
    use HasSEO;

    public function index()
    {
        SEOMeta::setTitle('Conditions Générales de Vente - Mbacol Communication')
            ->setDescription('Consultez les conditions générales de vente de Mbacol Communication : modalités de commande, livraison, paiement, retours et garanties pour vos achats électroniques au Sénégal.')
            ->setKeywords(['CGV', 'conditions générales de vente', 'Mbacol Communication', 'politique de retour', 'livraison Dakar'])
            ->setCanonical(route('terms'))
            ->addMeta('robots', 'index, follow');

        $this->setDefaultSocialTags(
            'CGV - Mbacol Communication',
            'Conditions générales de vente : commande, paiement, livraison et garanties.',
            route('terms')
        );

        return view('terms');
    }
}
