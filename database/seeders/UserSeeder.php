<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // De vaste beheerder waarmee het project beoordeeld wordt.
        User::create([
            'name' => 'Beheerder',
            'username' => 'admin',
            'email' => 'admin@ehb.be',
            'password' => Hash::make('Password!321'),
            'email_verified_at' => now(),
            'birthday' => '1985-04-12',
            'avatar_path' => SeedAssets::avatar('admin'),
            'bio' => 'Beheerder van de website van Klimclub Verticaal. Vragen over de site of je account? Stuur gerust een berichtje via het contactformulier.',
            'is_admin' => true,
        ]);

        // Een tweede admin, zodat het beheer van adminrechten testbaar is.
        User::create([
            'name' => 'Aya Belkacem',
            'username' => 'aya',
            'email' => 'aya@klimclubverticaal.be',
            'password' => Hash::make('Password!321'),
            'email_verified_at' => now(),
            'birthday' => '1991-09-03',
            'avatar_path' => SeedAssets::avatar('aya'),
            'bio' => 'Hoofdtrainer en routebouwer. Klimt sinds haar veertiende, het liefst op graniet. Begeleidt de gevorderdengroep op dinsdagavond.',
            'is_admin' => true,
        ]);

        $members = [
            [
                'name' => 'Sven Dewitte',
                'username' => 'sven',
                'birthday' => '1994-01-22',
                'avatar' => 'sven',
                'bio' => 'Boulderaar in hart en nieren. Werkt al twee jaar aan een 7A in de Boulderzaal en blijft volhouden.',
            ],
            [
                'name' => 'Lotte Vermeiren',
                'username' => 'lotte',
                'birthday' => '2001-06-30',
                'avatar' => 'lotte',
                'bio' => 'Sinds vorig jaar lid en ondertussen niet meer weg te slaan. Favoriete graad: net iets te moeilijk.',
            ],
            [
                'name' => 'Mehdi Ouali',
                'username' => 'mehdi',
                'birthday' => '1988-11-14',
                'avatar' => 'mehdi',
                'bio' => 'Voorklimmer en zekerinstructeur. Neemt graag nieuwe leden op sleeptouw tijdens de initiatie.',
            ],
            [
                'name' => 'Nora Peeters',
                'username' => 'nora',
                'birthday' => '1997-03-08',
                'avatar' => 'nora',
                'bio' => 'Traint voor haar eerste buitenroute in Freyr. Altijd te vinden voor een clubreis.',
            ],
            [
                'name' => 'Jonas Claes',
                'username' => 'jonas',
                'birthday' => '2005-07-19',
                'avatar' => 'jonas',
                'bio' => 'Jongste lid van de competitieploeg. Klimt sneller dan hij kan uitleggen hoe.',
            ],
        ];

        foreach ($members as $member) {
            User::create([
                'name' => $member['name'],
                'username' => $member['username'],
                'email' => $member['username'] . '@klimclubverticaal.be',
                'password' => Hash::make('Password!321'),
                'email_verified_at' => now(),
                'birthday' => $member['birthday'],
                'avatar_path' => SeedAssets::avatar($member['avatar']),
                'bio' => $member['bio'],
                'is_admin' => false,
            ]);
        }

        // Een handvol extra leden zodat lijsten en paginatie gevuld zijn.
        User::factory(12)->create();
    }
}
