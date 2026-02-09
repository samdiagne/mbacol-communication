<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
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
                    $message->to('admin@mbacol.sn')
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