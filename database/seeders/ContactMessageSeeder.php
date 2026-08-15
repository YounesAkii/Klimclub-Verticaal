<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('username', 'admin')->firstOrFail();

        $messages = [
            [
                'name' => 'Karen Vandenberghe',
                'email' => 'karen.vdb@example.com',
                'subject' => 'Verjaardagsfeestje voor mijn dochter',
                'message' => "Goedemiddag,\n\nMijn dochter wordt in november tien en is helemaal weg van klimmen. Organiseren jullie verjaardagsfeestjes voor kinderen? Het zou gaan om een groepje van ongeveer acht kinderen.\n\nAlvast bedankt voor de info.",
                'days_ago' => 1,
            ],
            [
                'name' => 'Tom Segers',
                'email' => 'tom.segers@example.com',
                'subject' => 'Zekerbrevet elders behaald',
                'message' => "Hallo,\n\nIk heb vorig jaar mijn zekerbrevet toprope gehaald in een zaal in Gent. Kan ik daarmee bij jullie zelfstandig klimmen of moet ik iets opnieuw doen?\n\nGroeten,\nTom",
                'days_ago' => 2,
            ],
            [
                'name' => 'Fatima El Amrani',
                'email' => 'f.elamrani@example.com',
                'subject' => 'Groepsuitstap met collega\'s',
                'message' => "Beste,\n\nWij zoeken een teambuildingactiviteit voor een groep van 22 collega's, ergens in de loop van oktober. Bieden jullie dat aan, en wat zou de prijs ongeveer zijn?\n\nMet vriendelijke groeten,\nFatima",
                'days_ago' => 6,
                'reply' => "Beste Fatima,\n\nDat kan zeker. Voor groepen vanaf 15 personen werken we met een formule van twee uur begeleide initiatie aan 22 euro per persoon, materiaal inbegrepen. We voorzien dan drie instructeurs.\n\nLaat gerust weten welke datum jullie voor ogen hebben, dan kijk ik de beschikbaarheid na.\n\nMet vriendelijke groeten,\nKlimclub Verticaal",
                'replied_days_ago' => 5,
            ],
            [
                'name' => 'Bram Coppens',
                'email' => 'bram.coppens@example.com',
                'subject' => 'Verloren waterfles',
                'message' => "Dag,\n\nIk denk dat ik zaterdag mijn blauwe drinkfles heb laten staan in de kleedkamer. Ligt die toevallig bij de gevonden voorwerpen?\n\nBedankt!",
                'days_ago' => 11,
                'reply' => "Dag Bram,\n\nGoed nieuws: er staat inderdaad een blauwe fles achter de balie. Je kan hem tijdens de openingsuren komen ophalen.\n\nGroeten,\nKlimclub Verticaal",
                'replied_days_ago' => 10,
            ],
            [
                'name' => 'Sofie Maes',
                'email' => 'sofie.maes@example.com',
                'subject' => 'Sponsoring herfstcompetitie',
                'message' => "Beste,\n\nOns bedrijf is op zoek naar lokale sportinitiatieven om te ondersteunen. Zouden jullie geïnteresseerd zijn in sponsoring van de herfstcompetitie? Ik hoor graag welke mogelijkheden er zijn.\n\nVriendelijke groeten,\nSofie Maes",
                'days_ago' => 4,
            ],
        ];

        foreach ($messages as $message) {
            $created = now()->subDays($message['days_ago']);

            $model = ContactMessage::create([
                'name' => $message['name'],
                'email' => $message['email'],
                'subject' => $message['subject'],
                'message' => $message['message'],
            ]);

            $model->forceFill([
                'created_at' => $created,
                'updated_at' => $created,
                'reply' => $message['reply'] ?? null,
                'replied_at' => isset($message['reply']) ? now()->subDays($message['replied_days_ago']) : null,
                'replied_by' => isset($message['reply']) ? $admin->id : null,
            ])->save();
        }
    }
}
