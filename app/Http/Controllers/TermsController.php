<?php

namespace App\Http\Controllers;

use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class TermsController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Conditions Générales de Vente - Mbacol Communication')
            ->setDescription('Consultez les conditions générales de vente de Mbacol Communication : modalités de commande, livraison, paiement, retours et garanties pour vos achats électroniques au Sénégal.')
            ->setKeywords(['CGV', 'conditions générales de vente', 'Mbacol Communication', 'politique de retour', 'livraison Dakar'])
            ->setCanonical(route('terms'))
            ->addMeta('robots', 'index, follow');

        OpenGraph::setTitle('CGV - Mbacol Communication')
            ->setDescription('Conditions générales de vente Mbacol Communication : commande, paiement, livraison et garanties.')
            ->setUrl(route('terms'))
            ->setType('website')
            ->addImage(asset('images/logo.webp'));

        TwitterCard::setTitle('CGV - Mbacol Communication')
            ->setDescription('Conditions générales de vente Mbacol Communication.');

        return view('terms');
    }
}
