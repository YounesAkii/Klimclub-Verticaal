<?php

namespace Database\Seeders;

use App\Models\Training;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TrainingSeeder extends Seeder
{
    public function run(): void
    {
        $aya = User::where('username', 'aya')->firstOrFail();
        $mehdi = User::where('username', 'mehdi')->firstOrFail();
        $admin = User::where('username', 'admin')->firstOrFail();
        $members = User::where('is_admin', false)->get();

        $trainings = [
            [
                'instructor' => $mehdi,
                'title' => 'Initiatie touwklimmen',
                'description' => "Een eerste kennismaking met touwklimmen voor wie nog nooit in een gordel hing. We overlopen het materiaal, oefenen de achtknoop en klimmen daarna in toprope onder begeleiding.\n\nJe hebt geen ervaring en geen eigen materiaal nodig. Klimschoenen kan je ter plaatse huren. Draag comfortabele kledij waarin je vlot kan bewegen.",
                'location' => 'Hoofdzaal',
                'level' => 'beginner',
                'capacity' => 10,
                'in_days' => 5,
                'hour' => 19,
                'duration' => 2,
            ],
            [
                'instructor' => $aya,
                'title' => 'Techniektraining voetwerk',
                'description' => "De meeste klimmers trekken te veel met de armen en staan te weinig op hun voeten. In deze sessie werken we uitsluitend aan voetwerk: precies plaatsen, stil houden en je gewicht correct verplaatsen.\n\nWe klimmen op vlakke wanden met bewust kleine voetgrepen. Verwacht je niet aan zware graden, wel aan spierpijn op plaatsen die je niet verwachtte.",
                'location' => 'Boulderzaal',
                'level' => 'alle niveaus',
                'capacity' => 14,
                'in_days' => 9,
                'hour' => 20,
                'duration' => 2,
            ],
            [
                'instructor' => $aya,
                'title' => 'Voorklimcursus: avond 1',
                'description' => "De eerste van vier avonden richting het voorklimbrevet. Deze avond focussen we op het inhangen van tussenzekeringen, touwbeheer en de meest gemaakte fouten.\n\nJe hebt het zekerbrevet toprope nodig om deel te nemen. Breng je eigen gordel en zekerapparaat mee als je die hebt.",
                'location' => 'Hoofdzaal',
                'level' => 'gevorderd',
                'capacity' => 8,
                'in_days' => 14,
                'hour' => 19,
                'duration' => 3,
            ],
            [
                'instructor' => $mehdi,
                'title' => 'Boulderavond voor gevorderden',
                'description' => "Een begeleide sessie rond de moeilijkere boulders in de nieuwe zaal. We bekijken samen de bewegingen, proberen verschillende oplossingen uit en werken projectgericht.\n\nRicht je op boulders vanaf 6B. De sessie is bedoeld voor wie al zelfstandig bouldert en op zoek is naar een duwtje.",
                'location' => 'Boulderzaal',
                'level' => 'gevorderd',
                'capacity' => 12,
                'in_days' => 20,
                'hour' => 19,
                'duration' => 2,
            ],
            [
                'instructor' => $admin,
                'title' => 'Materiaalcheck en onderhoud',
                'description' => "Breng je gordel, touw en karabiners mee en leer waar je op moet letten. We overlopen slijtagepunten, keuringsdata en hoe je je materiaal het best bewaart.\n\nDeze sessie is gratis voor leden en duurt ongeveer anderhalf uur.",
                'location' => 'Clublokaal',
                'level' => 'alle niveaus',
                'capacity' => 20,
                'in_days' => 27,
                'hour' => 18,
                'duration' => 2,
            ],
            [
                'instructor' => $aya,
                'title' => 'Voorbereiding clubreis Fontainebleau',
                'description' => "Praktische infosessie voor iedereen die meegaat naar Fontainebleau. We bespreken de sectoren, het vervoer, wat je meeneemt en hoe je op zandsteen anders klimt dan in de zaal.\n\nOok interessant als je nog twijfelt om mee te gaan.",
                'location' => 'Clublokaal',
                'level' => 'alle niveaus',
                'capacity' => 24,
                'in_days' => 33,
                'hour' => 20,
                'duration' => 1,
            ],
            [
                'instructor' => $mehdi,
                'title' => 'Initiatie bouldering',
                'description' => "Klimmen zonder touw, dicht bij de grond, op dikke matten. Deze sessie leert je veilig vallen, de kleurcodes lezen en de eerste bewegingen maken.\n\nIdeaal als je eens wil proeven zonder je meteen te engageren voor een volledige cursus.",
                'location' => 'Boulderzaal',
                'level' => 'beginner',
                'capacity' => 16,
                'in_days' => -12,
                'hour' => 19,
                'duration' => 2,
            ],
            [
                'instructor' => $aya,
                'title' => 'Krachttraining voor klimmers',
                'description' => "Een sessie rond vingerkracht, core-stabiliteit en blessurepreventie. We werken met de campusboard, de hangboard en een reeks oefeningen die je thuis kan herhalen.\n\nNiet geschikt voor klimmers die minder dan een jaar klimmen: je pezen hebben tijd nodig om zich aan te passen.",
                'location' => 'Clublokaal',
                'level' => 'gevorderd',
                'capacity' => 10,
                'in_days' => -26,
                'hour' => 20,
                'duration' => 2,
            ],
        ];

        foreach ($trainings as $training) {
            $startsAt = now()->addDays($training['in_days'])->setTime($training['hour'], 0);

            $model = Training::create([
                'instructor_id' => $training['instructor']->id,
                'title' => $training['title'],
                'slug' => Str::slug($training['title']),
                'description' => $training['description'],
                'location' => $training['location'],
                'level' => $training['level'],
                'capacity' => $training['capacity'],
                'starts_at' => $startsAt,
                'ends_at' => $startsAt->copy()->addHours($training['duration']),
            ]);

            // Vul de training gedeeltelijk met deelnemers. De eerste training in
            // de lijst zetten we bewust volledig vol, zodat de "volzet"-status
            // meteen zichtbaar is.
            $count = $model->title === 'Initiatie touwklimmen'
                ? $model->capacity
                : random_int(1, max(1, (int) ($model->capacity / 2)));

            $participants = $members->random(min($count, $members->count()));

            foreach ($participants as $participant) {
                $model->participants()->attach($participant->id, [
                    'registered_at' => $startsAt->copy()->subDays(random_int(1, 10)),
                ]);
            }
        }
    }
}
