<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\NewsItem;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('username', 'admin')->firstOrFail();
        $aya = User::where('username', 'aya')->firstOrFail();
        $members = User::where('is_admin', false)->get();

        $items = [
            [
                'author' => $aya,
                'title' => 'De nieuwe boulderzaal opent op 12 september',
                'image' => 'nieuwe-boulderzaal',
                'days_ago' => 3,
                'excerpt' => 'Na vier maanden verbouwen is het zover: de boulderzaal krijgt 180 vierkante meter extra klimoppervlak, een nieuwe valmat en een aparte opwarmzone.',
                'content' => <<<'TEXT'
                Vier maanden geleden sloten we de oude boulderzaal af met een laatste sessie en een stuk taart. Vandaag mogen we aankondigen dat de deuren op 12 september opnieuw opengaan, en dat wat erachter ligt niet meer te herkennen is.

                De zaal is uitgebreid met 180 vierkante meter klimoppervlak. De overhang aan de linkerkant loopt nu door tot tegen het plafond, en er is een aparte zone met vlakke wanden voor techniektraining. De volledige valmat is vervangen door een doorlopend systeem van 30 centimeter dik, wat een groot verschil maakt bij hoge dyno's.

                Onze routebouwers hebben de voorbije weken non-stop geschroefd. Bij de opening liggen er 95 nieuwe boulders klaar, verdeeld over alle graden van 4A tot 7C. De kleurcodes blijven dezelfde als vroeger, dus je hoeft niets nieuws te leren.

                De opening start om 18 uur met een rondleiding, gevolgd door een vrije klimavond. Leden klimmen die avond gratis, niet-leden betalen het gewone dagtarief. Om 21 uur is er een korte receptie waarop iedereen welkom is.
                TEXT,
            ],
            [
                'author' => $admin,
                'title' => 'Inschrijvingen herfstcompetitie zijn open',
                'image' => 'herfstcompetitie',
                'days_ago' => 9,
                'excerpt' => 'Op 18 oktober organiseren we opnieuw onze jaarlijkse herfstcompetitie, met aparte reeksen voor jeugd, recreanten en gevorderden.',
                'content' => <<<'TEXT'
                De herfstcompetitie is al jaren het drukste moment op onze clubkalender, en dit jaar breiden we uit naar drie reeksen. Naast de gebruikelijke recreanten- en gevorderdenreeks komt er een aparte jeugdreeks voor klimmers tot en met zestien jaar.

                Het formaat blijft ongewijzigd. Je krijgt drie uur om zoveel mogelijk boulders te klimmen; elke boulder levert punten op afhankelijk van de moeilijkheidsgraad, en je acht beste resultaten tellen mee. Je hoeft dus niet alles te proberen, wel slim te kiezen.

                Inschrijven kan via je profiel op deze website, of aan de balie tijdens de openingsuren. Deelname kost 10 euro voor leden en 18 euro voor niet-leden, drankje inbegrepen. De inschrijvingen sluiten op 11 oktober of zodra we aan 120 deelnemers zitten.

                Kan je zelf niet meedoen maar wil je helpen? We zoeken nog juryleden en mensen die de kleedkamers en de bar mee draaiende houden. Laat het weten via het contactformulier.
                TEXT,
            ],
            [
                'author' => $aya,
                'title' => 'Jeugdwerking zoekt begeleiders voor het nieuwe seizoen',
                'image' => 'jeugdwerking',
                'days_ago' => 21,
                'excerpt' => 'Onze jeugdgroep groeit sneller dan verwacht. Voor het nieuwe seizoen zoeken we drie extra begeleiders voor de woensdagnamiddag.',
                'content' => <<<'TEXT'
                Twee jaar geleden startten we de jeugdwerking met elf kinderen. Vandaag staan er vierenveertig op de ledenlijst en dertien op de wachtlijst. Dat is fantastisch nieuws, maar het betekent ook dat we met de huidige ploeg begeleiders aan onze limiet zitten.

                Voor het nieuwe seizoen zoeken we daarom drie extra begeleiders voor de woensdagnamiddag, van 14 tot 17 uur. Ervaring met kinderen is belangrijker dan een hoge klimgraad; het zekeren en de techniek leren we je zelf aan.

                Wie instapt, volgt in oktober een interne opleiding van twee zaterdagen. Daarna klim je een aantal weken mee met een ervaren begeleider voor je een eigen groepje krijgt. De club betaalt de opleiding en je lidgeld voor het seizoen.

                Interesse? Spreek Aya aan in de zaal of stuur een bericht via het contactformulier. We plannen begin september een informatieavond voor iedereen die twijfelt.
                TEXT,
            ],
            [
                'author' => $admin,
                'title' => 'Jaarlijkse materiaalcheck: breng je touw en gordel mee',
                'image' => 'materiaalcheck',
                'days_ago' => 34,
                'excerpt' => 'Op 28 september keuren onze instructeurs gratis je persoonlijke klimmateriaal. Gordels ouder dan tien jaar worden sowieso afgekeurd.',
                'content' => <<<'TEXT'
                Klimmateriaal slijt, ook als het er nog goed uitziet. Daarom organiseren we elk najaar een materiaalcheck waarbij onze instructeurs gratis je persoonlijke uitrusting nakijken.

                Breng je gordel, touw, karabiners en zekerapparaat mee naar het clublokaal op 28 september tussen 18 en 21 uur. We overlopen samen de slijtagepunten, zodat je nadien zelf weet waar je op moet letten.

                Enkele vuistregels die we sowieso toepassen: gordels ouder dan tien jaar worden afgekeurd, ongeacht hun staat. Touwen met een zichtbaar beschadigde mantel of een voelbare onderbreking in de kern gaan uit roulatie. Karabiners met een scherpe groef of een sluiting die niet vlot terugveert, vervang je best.

                Wordt je materiaal afgekeurd? Geen ramp. We knippen het ter plaatse door zodat het zeker niet meer gebruikt wordt, en je krijgt van ons een kortingsbon van 15 procent bij de clubshop.
                TEXT,
            ],
            [
                'author' => $aya,
                'title' => 'Clubreis naar Fontainebleau: 24 tot 26 oktober',
                'image' => 'clubreis-fontainebleau',
                'days_ago' => 52,
                'excerpt' => 'Drie dagen bouldering op het zandsteen van Fontainebleau, met overnachting in een gîte op tien minuten van de bossen.',
                'content' => <<<'TEXT'
                Het klassieke najaarsuitje komt eraan. Van vrijdag 24 tot zondag 26 oktober trekken we met de club naar Fontainebleau, het bekendste boulderbos van Europa.

                We logeren in een gîte in Bourron-Marlotte, op tien minuten rijden van de meeste sectoren. Er zijn 24 slaapplaatsen in kamers van vier tot zes personen. De prijs bedraagt 95 euro per persoon, inclusief twee overnachtingen, ontbijt en avondeten.

                Op zaterdag splitsen we in twee groepen: een groep trekt naar de klassiekers in Bas Cuvier, de andere naar de wat vriendelijkere circuits van Roche aux Sabots. Zondag beslissen we ter plaatse, afhankelijk van het weer en de vermoeide vingers.

                Vervoer regelen we samen via carpooling; bij je inschrijving geef je aan of je een auto hebt en hoeveel plaatsen er vrij zijn. Inschrijven kan tot 10 oktober en is pas definitief na betaling.
                TEXT,
            ],
            [
                'author' => $admin,
                'title' => 'Twaalf nieuwe routes in de hoofdzaal',
                'image' => 'nieuwe-routes',
                'days_ago' => 71,
                'excerpt' => 'De rechterhelft van de hoofdzaal is volledig herschroefd. Twaalf nieuwe touwroutes van 5c tot 7b staan klaar.',
                'content' => <<<'TEXT'
                Afgelopen weekend heeft het routebouwteam de rechterhelft van de hoofdzaal onder handen genomen. De oude routes hingen er anderhalf jaar, tijd voor iets nieuws.

                Er staan twaalf nieuwe touwroutes klaar, verdeeld van 5c tot 7b. De nadruk ligt deze keer op technisch klimwerk in plaats van pure kracht: verwacht je aan kleine voetjes, subtiele balansbewegingen en een paar zetten waar je even over moet nadenken.

                De 6a+ op de linkerkant van de overhang is een aanrader voor wie voor het eerst in die graad klimt. De 7b helemaal rechts is bewust stevig aangezet en zal waarschijnlijk een tijdje standhouden.

                Feedback op de routes is altijd welkom. Er hangt een blad naast de balie waar je opmerkingen kwijt kan, en die nemen we mee bij de volgende schroefbeurt.
                TEXT,
            ],
        ];

        foreach ($items as $item) {
            $newsItem = NewsItem::create([
                'user_id' => $item['author']->id,
                'title' => $item['title'],
                'slug' => Str::slug($item['title']),
                'image_path' => SeedAssets::newsImage($item['image']),
                'excerpt' => $item['excerpt'],
                // De heredoc is ingesprongen in de code; die inspringing halen we
                // eruit zodat de tekst netjes in de databank belandt.
                'content' => $this->dedent($item['content']),
                'published_at' => now()->subDays($item['days_ago'])->setTime(9, 0),
            ]);

            // Reacties van willekeurige leden op de recentste items.
            if ($item['days_ago'] < 40) {
                foreach ($members->random(min(3, $members->count())) as $index => $member) {
                    Comment::create([
                        'news_item_id' => $newsItem->id,
                        'user_id' => $member->id,
                        'body' => $this->sampleComments()[array_rand($this->sampleComments())],
                        'created_at' => $newsItem->published_at->addHours(4 + $index * 9),
                        'updated_at' => $newsItem->published_at->addHours(4 + $index * 9),
                    ]);
                }
            }
        }

        // Een item met een publicatiedatum in de toekomst: dit hoort niet op de
        // publieke lijst te staan, wel in het adminoverzicht.
        NewsItem::create([
            'user_id' => $admin->id,
            'title' => 'Kerstsluiting en openingsuren tijdens de feestdagen',
            'slug' => 'kerstsluiting-en-openingsuren-tijdens-de-feestdagen',
            'image_path' => SeedAssets::newsImage('herfstcompetitie'),
            'excerpt' => 'De zaal sluit op 24 en 25 december en op 31 december en 1 januari. Alle aangepaste uren op een rij.',
            'content' => "De volledige kalender voor de feestdagen wordt hier gepubliceerd zodra de planning van de begeleiders rond is.\n\nDit bericht staat klaar met een publicatiedatum in de toekomst en verschijnt dus nog niet op de nieuwspagina.",
            'published_at' => now()->addWeeks(3),
        ]);
    }

    /**
     * Haalt de gemeenschappelijke inspringing uit een heredoc-blok.
     */
    private function dedent(string $text): string
    {
        return preg_replace('/^[ \t]+/m', '', trim($text));
    }

    /**
     * @return list<string>
     */
    private function sampleComments(): array
    {
        return [
            'Top nieuws, ik ben er zeker bij!',
            'Eindelijk. Ik heb de voorbije maanden echt de zaal gemist.',
            'Kan ik me nog inschrijven als ik pas volgende week beslis?',
            'Bedankt voor de heldere uitleg, dat maakt het een pak duidelijker.',
            'Ik neem mijn broer mee, die wil dat al lang eens proberen.',
            'Staat in de agenda. Tot dan!',
        ];
    }
}
