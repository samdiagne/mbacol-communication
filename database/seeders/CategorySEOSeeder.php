<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySEOSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Accessoires & Consommables',
                'slug' => 'accessoires-consommables',
                'description' => 'Câbles, buses, boîtes de rangement, tables de réparation et accessoires professionnels',
                'meta_title' => 'Accessoires & Consommables Électronique | Mbacol - Khouma et Frères',
                'meta_description' => 'Câbles USB-C, buses de pistolets, boîtes de rangement, tables de réparation. Import/Export professionnel. Livraison Dakar, Sénégal.',
                'meta_keywords' => 'câble USB-C Lightning Dakar, buses pistolet air chaud, boîte rangement composants électroniques, table réparation téléphone, programmateur iPhone Sénégal, accessoires réparation Dakar',
                'long_tail_keywords' => 'où acheter câble lightning certifié MFi Dakar, boîte rangement 60 tiroirs Sénégal, table réparation RF4 Dakar, programmateur puces iPhone 11-13',
            ],
            [
                'name' => 'Électronique Grand Public',
                'slug' => 'electronique-grand-public',
                'description' => 'Chargeurs rapides, climatiseurs portables, écrans tactiles professionnels',
                'meta_title' => 'Chargeurs Rapides, Climatiseurs & Écrans Tactiles | Mbacol Dakar',
                'meta_description' => 'Chargeurs GaN 800W, climatiseurs portables USB, écrans tactiles HD. Technologie de pointe. Khouma et Frères - Import direct.',
                'meta_keywords' => 'chargeur GaN 800W USB-C PD3.1, chargeur bureau multi-ports Dakar, climatiseur portable USB Sénégal, écran tactile RF4 HD grand format, chargeur sans fil QC3.0 Dakar',
                'long_tail_keywords' => 'chargeur GaN 10 ports USB-C Dakar, mini climatiseur USB avec glace, écran tactile RF-H6 HD Smart Dakar, chargeur rapide 140W Multi-Ports Sénégal',
            ],
            [
                'name' => 'Équipement de Test',
                'slug' => 'equipement-test',
                'description' => 'Testeurs SIM, testeurs batterie, multimètres numériques professionnels',
                'meta_title' => 'Équipement de Test Électronique Professionnel | Mbacol Sénégal',
                'meta_description' => 'Testeurs SIM, testeurs batterie JCID, multimètres numériques RF4. Outils de diagnostic professionnels. Livraison Dakar.',
                'meta_keywords' => 'testeur SIM universel iPhone Android, testeur batterie JCID BC02-T, multimètre numérique RF4 LCD NCV, équipement test réparation téléphone, diagnostic batterie iPhone Dakar',
                'long_tail_keywords' => 'testeur SIM WYLIE universel Dakar, testeur batterie JCID iPhone 20h-16h, multimètre RF4 17N LCD avec NCV, outils test réparation smartphone Sénégal',
            ],
            [
                'name' => 'Microscopes & Caméras',
                'slug' => 'microscopes-cameras',
                'description' => 'Microscopes trinoculaires 2K/4K, microscopes stéréo, caméras professionnelles',
                'meta_title' => 'Microscopes Professionnels & Caméras HD | Mbacol - Import Sénégal',
                'meta_description' => 'Microscopes trinoculaires 2K/4K HDMI, microscopes stéréo zoom 6.5-58X, caméras SZMCTV, lampes LED annulaires. Réparation professionnelle.',
                'meta_keywords' => 'microscope trinoculaire 2K HDMI, microscope stéréo trinoculaire 6S65PRO, microscope universel bras pivotant, microscope Qianli Gorilla 6558 Zoom, caméra SZMCTV monture C, lampe annulaire LED RF4 144 LED',
                'long_tail_keywords' => 'microscope RF7050TV 4K C1 4K Dakar, microscope YCS 6558X 7050 Ultra HD 4K, adaptateur caméra SZMCTV 1/2 1/3, couvercle oculaire RF-EM6 anti-poussière, lampe LED RF4 OK-9 144 LED USB Sénégal',
            ],
            [
                'name' => 'Outils de Réparation',
                'slug' => 'outils-reparation',
                'description' => 'Kits extracteur, supports PCB, outils démontage, pinces professionnelles',
                'meta_title' => 'Outils de Réparation Smartphone Professionnels | Mbacol Dakar',
                'meta_description' => 'Kits extracteur vis endommagées, supports PCB, outils démontage écran, pinces fixation. Professionnels réparation téléphone Sénégal.',
                'meta_keywords' => 'kit extracteur vis endommagées professionnel, support PCB réglable RF4 RF-FT05, support universel RF4 carte mère, outil réparation XZZ S2 PCB réglable, dispositif réparation BGA CPU, plateforme soudage carte mère, pince fixation haute température',
                'long_tail_keywords' => 'kit extracteur vis professionnel Dakar, support PCB réglable RF-FT05 Sénégal, dispositif réparation RF4 RF-FT09 BGA CPU, plateforme soudage RF4 FT067 carte mère, pince fixation RF4 FT067 haute temp, outil démontage RF4 RF-S03 LCD',
            ],
            [
                'name' => 'Stations de Soudage',
                'slug' => 'stations-soudage',
                'description' => 'Stations de soudage BGA, stations air chaud, retouche professionnelle',
                'meta_title' => 'Stations de Soudage Professionnelles RF4 | Mbacol - Khouma et Frères',
                'meta_description' => 'Stations soudage BGA H2, stations air chaud S210, affichage digital, retouche mémoire. Équipement professionnel réparation électronique Dakar.',
                'meta_keywords' => 'station soudage RF4 New1000W BGA H2, station soudage RF4 RF-S210 air chaud, station soudage RF4 RF-H9 affichage digital, station retouche RF4 RF-H8 mémoire 4 canaux, station 2-en-1 fer air chaud T12 210V, station préchauffage MJ Mijing MS1 iPhone',
                'long_tail_keywords' => 'station soudage RF4 New1000W BGA H2 Dakar, station air chaud RF-S210 BGA Sénégal, station RF4 RF-H9 affichage digital, station retouche mémoire RF-H8 4 canaux, station 2-en-1 T12 air chaud 210V Dakar',
            ],
            [
                'name' => 'Pièces Détachées Téléphones',
                'slug' => 'pieces-detachees-telephones',
                'description' => 'Écrans LCD, nappes FLEX, vitres tactiles TOUCH, batteries originales pour smartphones',
                'meta_title' => 'Pièces Détachées Téléphones iPhone & Samsung | Mbacol Dakar',
                'meta_description' => 'Écrans LCD, nappes FLEX, vitres tactiles TOUCH, batteries originales. Pièces de remplacement iPhone, Samsung, Xiaomi. Qualité garantie.',
                'meta_keywords' => 'écran LCD iPhone Dakar, vitre tactile Samsung Sénégal, nappe FLEX iPhone original, batterie iPhone remplacement, LCD Samsung A54 Dakar, écran OLED iPhone 13 Pro, vitre TOUCH Xiaomi, pièces détachées smartphone Sénégal',
                'long_tail_keywords' => 'écran LCD iPhone 12 Pro Max Dakar, batterie iPhone 11 original Sénégal, nappe FLEX home button iPhone 8, vitre tactile Samsung S23 Ultra Dakar, écran OLED iPhone 13 remplacement, LCD Xiaomi Redmi Note 12 Sénégal',
            ],
        ];

        foreach ($categories as $categoryData) {
            Category::updateOrCreate(
                ['slug' => $categoryData['slug']],
                $categoryData
            );
        }

        $this->command->info('✅ Catégories SEO créées/mises à jour avec succès !');
    }
}