<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Beginnen met klimmen',
                'description' => 'Alles wat je moet weten voor je eerste keer in de zaal staat.',
                'faqs' => [
                    [
                        'Ik heb nog nooit geklommen. Kan ik zomaar langskomen?',
                        'Ja. Je hoeft geen ervaring te hebben om te starten. Kom langs tijdens onze initiatiemomenten op maandag- en donderdagavond om 19 uur. Een begeleider legt je dan de basis uit: hoe je een gordel aandoet, hoe je zekert en hoe je veilig valt in de boulderzaal. Je hoeft niets te reserveren, gewoon een half uurtje op voorhand aanwezig zijn.',
                    ],
                    [
                        'Welk materiaal heb ik nodig als beginner?',
                        'In het begin heb je enkel klimschoenen nodig, en die kan je bij ons huren voor 4 euro per keer. Gordel en zekerapparaat krijg je in bruikleen tijdens de initiatie. Pas wanneer je regelmatig komt klimmen, is het interessant om eigen materiaal aan te kopen. Vraag gerust advies aan een instructeur voor je iets koopt.',
                    ],
                    [
                        'Vanaf welke leeftijd kan ik komen klimmen?',
                        'Vanaf 6 jaar kan je terecht in de jeugdwerking op woensdagnamiddag. Kinderen jonger dan 12 klimmen altijd onder begeleiding. Vanaf 16 jaar mag je zelfstandig klimmen zodra je het zekerbrevet hebt behaald. Voor die leeftijd kan je wel zelfstandig bouloeren in de boulderzaal, op voorwaarde dat een ouder aanwezig is.',
                    ],
                    [
                        'Moet ik iemand meebrengen om te zekeren?',
                        'Voor touwklimmen heb je een zekerpartner nodig. Kom je alleen? Geen probleem: in de boulderzaal klim je zonder touw en dus zonder partner. Bovendien is er tijdens de clubavonden op dinsdag en donderdag altijd wel iemand die met je wil klimmen. Zeg gewoon aan de balie dat je een partner zoekt.',
                    ],
                ],
            ],
            [
                'name' => 'Lidmaatschap en tarieven',
                'description' => 'Over lidgeld, beurtenkaarten en het opzeggen van je lidmaatschap.',
                'faqs' => [
                    [
                        'Wat kost een lidmaatschap?',
                        'Een volwassen lidmaatschap kost 180 euro per jaar. Voor jongeren tot 18 jaar en studenten is dat 120 euro, voor de jeugdwerking 145 euro inclusief begeleiding. Daarin zit de verzekering via de klimfederatie, onbeperkte toegang tijdens de openingsuren en deelname aan de clubactiviteiten. Het lidgeld loopt van 1 september tot 31 augustus en wordt niet pro rata verrekend.',
                    ],
                    [
                        'Kan ik komen klimmen zonder lid te worden?',
                        'Zeker. Een dagticket kost 14 euro voor volwassenen en 9 euro voor jongeren onder 18. Er zijn ook beurtenkaarten van 10 beurten aan 120 euro, geldig gedurende een jaar. Vanaf ongeveer vijftien bezoeken per jaar ben je goedkoper af met een lidmaatschap.',
                    ],
                    [
                        'Hoe zeg ik mijn lidmaatschap op?',
                        'Je lidmaatschap loopt automatisch af op 31 augustus en wordt niet stilzwijgend verlengd. Je hoeft dus niets te doen als je niet wil verlengen. Wil je in de loop van het jaar stoppen, laat het ons dan weten via het contactformulier. Terugbetaling van het resterende lidgeld is enkel mogelijk bij een langdurige blessure, op voorlegging van een medisch attest.',
                    ],
                    [
                        'Is mijn lidmaatschap ook geldig in andere klimzalen?',
                        'Je lidmaatschap geeft toegang tot onze eigen zalen. De verzekering via de klimfederatie loopt wel mee wanneer je elders klimt of op rots gaat, ook in het buitenland. Sommige bevriende clubs geven korting aan onze leden; vraag ernaar aan de balie voor je vertrekt.',
                    ],
                ],
            ],
            [
                'name' => 'Veiligheid en brevetten',
                'description' => 'Regels in de zaal en de opleidingen die we aanbieden.',
                'faqs' => [
                    [
                        'Heb ik een brevet nodig om zelfstandig te klimmen?',
                        'Om zelfstandig met touw te klimmen heb je het zekerbrevet toprope nodig. Voor voorklimmen komt daar het voorklimbrevet bij. Beide brevetten haal je bij ons via een cursus van vier avonden. Heb je elders al een brevet behaald, breng het dan mee; onze instructeurs doen een korte controle en nemen het over.',
                    ],
                    [
                        'Wat zijn de belangrijkste regels in de zaal?',
                        'Klim nooit boven of onder iemand anders, hou de valzone in de boulderzaal vrij en laat geen materiaal op de mat liggen. Controleer altijd samen met je partner de knoop en het zekerapparaat voor je start. Eten en drinken doe je in de kantine, niet op de matten. Wie de veiligheidsregels herhaaldelijk negeert, kan de toegang tot de zaal ontzegd worden.',
                    ],
                    [
                        'Wat als er een ongeval gebeurt?',
                        'Verwittig onmiddellijk een medewerker; er is altijd iemand met een EHBO-opleiding aanwezig tijdens de openingsuren. De verbanddoos hangt naast de balie en de AED bij de inkom. Elk ongeval, hoe klein ook, noteren we in het ongevallenregister. Voor de verzekering vul je binnen de 48 uur het aangifteformulier in dat je aan de balie krijgt.',
                    ],
                ],
            ],
            [
                'name' => 'Trainingen en activiteiten',
                'description' => 'Praktische info over het inschrijven op trainingen en clubactiviteiten.',
                'faqs' => [
                    [
                        'Hoe schrijf ik me in voor een training?',
                        'Maak een account aan op deze website en ga naar de pagina Trainingen. Bij elke training die nog niet gestart is en waar nog plaats vrij is, vind je een knop om je in te schrijven. Je ziet je eigen inschrijvingen terug op je profielpagina. Uitschrijven kan tot het moment dat de training begint.',
                    ],
                    [
                        'Wat als een training volzet is?',
                        'Zodra het maximum aantal deelnemers bereikt is, verdwijnt de inschrijfknop. Er is voorlopig geen automatische wachtlijst. Het loont wel om af en toe terug te kijken: er schrijven regelmatig mensen zich terug uit, en dan komt de plaats gewoon opnieuw vrij.',
                    ],
                    [
                        'Kan ik een training annuleren?',
                        'Ja, je kan jezelf uitschrijven zolang de training nog niet begonnen is. Doe dat zeker als je niet kan komen, zodat iemand anders je plaats kan innemen. Bij herhaaldelijk niet komen opdagen zonder uitschrijven kunnen we je tijdelijk uitsluiten van inschrijvingen.',
                    ],
                ],
            ],
        ];

        foreach ($categories as $categoryIndex => $category) {
            $model = FaqCategory::create([
                'name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'description' => $category['description'],
                'position' => $categoryIndex,
            ]);

            foreach ($category['faqs'] as $faqIndex => [$question, $answer]) {
                Faq::create([
                    'faq_category_id' => $model->id,
                    'question' => $question,
                    'answer' => $answer,
                    'position' => $faqIndex,
                ]);
            }
        }
    }
}
