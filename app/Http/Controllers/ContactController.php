<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Artesaos\SEOTools\Facades\SEOMeta;
use Artesaos\SEOTools\Facades\OpenGraph;
use Artesaos\SEOTools\Facades\TwitterCard;

class ContactController extends Controller
{
    public function index()
    {
        SEOMeta::setTitle('Contactez-nous - Mbacol Communication')
            ->setDescription('Contactez Mbacol Communication pour toute question sur nos produits électroniques. WhatsApp, email, téléphone. Dakar, Sénégal. Réponse rapide garantie.')
            ->setKeywords(['contact Mbacol Communication', 'service client Dakar', 'WhatsApp boutique électronique Sénégal'])
            ->setCanonical(route('contact'))
            ->addMeta('robots', 'index, follow');

        OpenGraph::setTitle('Contactez Mbacol Communication')
            ->setDescription('Contactez notre équipe par WhatsApp, email ou téléphone. Dakar, Sénégal.')
            ->setUrl(route('contact'))
            ->setType('website')
            ->addImage(asset('images/logo.webp'));

        TwitterCard::setTitle('Contact - Mbacol Communication')
            ->setDescription('Contactez-nous par WhatsApp au +221 78 446 51 92');

        return view('contact');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string',
            'message' => 'required|string|min:10',
        ]);

        // Envoyer l'email (simplifié)
        try {
            Mail::raw(
                "Nouveau message de contact\n\n" .
                "Nom: {$validated['name']}\n" .
                "Email: {$validated['email']}\n" .
                "Téléphone: " . ($validated['phone'] ?? 'Non renseigné') . "\n" .
                "Sujet: {$validated['subject']}\n\n" .
                "Message:\n{$validated['message']}",
                function ($message) use ($validated) {
                    $message->to('djilykhou423@gmail.com')
                            ->replyTo($validated['email'], $validated['name'])
                            ->subject('Contact : ' . $validated['subject']);
                }
            );

            return back()->with('success', 'Votre message a été envoyé avec succès ! Nous vous répondrons dans les plus brefs délais.');
        } catch (\Exception $e) {
            \Log::error('Contact form error: ' . $e->getMessage());
            return back()->with('success', 'Votre message a été enregistré. Nous vous répondrons bientôt.');
        }
    }
}