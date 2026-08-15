# Klimclub Verticaal

Website voor een fictieve klimclub in Anderlecht, gebouwd met **Laravel 13**.
Dit is mijn project voor het opleidingsonderdeel Web Advanced.

De site is volledig data driven: nieuws, FAQ, trainingen, gebruikers en
contactberichten komen allemaal uit de databank en worden beheerd via een
adminpaneel op de site zelf.

---

## Inhoudsopgave

- [Snel starten](#snel-starten)
- [Vereisten](#vereisten)
- [Installatie](#installatie)
- [Inloggegevens](#inloggegevens)
- [E-mail bekijken](#e-mail-bekijken)
- [Wat zit er in de site](#wat-zit-er-in-de-site)
- [Technische opbouw](#technische-opbouw)
- [Tests](#tests)
- [Bronvermelding](#bronvermelding)

---

## Snel starten

```bash
git clone <url-van-deze-repo>
cd <projectmap>

composer install
npm install

cp .env.example .env          # Windows: copy .env.example .env
php artisan key:generate

# Pas de DB_*-regels in .env aan naar je eigen databank
php artisan migrate:fresh --seed
php artisan storage:link

npm run build
php artisan serve
```

Surf daarna naar <http://localhost:8000>.

---

## Vereisten

| Software | Versie |
| --- | --- |
| PHP | 8.3 of hoger (ontwikkeld op 8.4) |
| Composer | 2.x |
| Node.js | 20 of hoger (ontwikkeld op 24) |
| MySQL of MariaDB | MySQL 8+ (ontwikkeld op MySQL 9.7) |

Benodigde PHP-extensies: `pdo_mysql`, `mbstring`, `openssl`, `fileinfo`, `gd`,
`zip`, `curl`, `intl`. Die staan standaard aan in de meeste PHP-installaties.

---

## Installatie

### 1. Dependencies installeren

```bash
composer install
npm install
```

### 2. Omgevingsbestand aanmaken

```bash
cp .env.example .env
php artisan key:generate
```

Zet in `.env` de gegevens van je eigen databank. Standaard staat er:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=klimclub
DB_USERNAME=root
DB_PASSWORD=
```

Maak de databank zelf eenmalig aan, bijvoorbeeld met:

```sql
CREATE DATABASE klimclub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Databank vullen

```bash
php artisan migrate:fresh --seed
```

Dit maakt alle tabellen aan en vult de site met basisdata: gebruikers,
zeven nieuwsitems met reacties, vier FAQ-categorieën met veertien vragen,
acht trainingen met inschrijvingen en vijf contactberichten.

### 4. Bestanden zichtbaar maken

```bash
php artisan storage:link
```

De profielfoto's en nieuwsafbeeldingen staan in `storage/app/public` en zijn
via deze symlink bereikbaar op `/storage/...`.

> De `DatabaseSeeder` legt deze symlink zelf al aan als hij nog niet bestaat,
> dus in de praktijk is de stap hierboven meestal niet meer nodig. Draai hem
> gerust toch: het commando is veilig om te herhalen.

### 5. Frontend bouwen

```bash
npm run build     # eenmalige build
# of
npm run dev       # met live reload tijdens het ontwikkelen
```

### 6. Server starten

```bash
php artisan serve
```

---

## Inloggegevens

Na het seeden bestaan de volgende accounts. **Alle accounts gebruiken hetzelfde
wachtwoord: `Password!321`**

| Gebruikersnaam | E-mail | Rol |
| --- | --- | --- |
| `admin` | `admin@ehb.be` | Beheerder |
| `aya` | `aya@klimclubverticaal.be` | Beheerder |
| `sven` | `sven@klimclubverticaal.be` | Lid |
| `lotte` | `lotte@klimclubverticaal.be` | Lid |
| `mehdi` | `mehdi@klimclubverticaal.be` | Lid |
| `nora` | `nora@klimclubverticaal.be` | Lid |
| `jonas` | `jonas@klimclubverticaal.be` | Lid |

Daarnaast maakt de seeder nog twaalf willekeurige leden aan (wachtwoord
`password`) zodat lijsten en paginatie gevuld zijn.

Het adminpaneel bereik je via de knop **Beheer** in de navigatie, of
rechtstreeks op `/beheer`.

---

## E-mail bekijken

Het contactformulier stuurt een e-mail naar de beheerder, en een antwoord vanuit
het adminpaneel stuurt een e-mail naar de afzender.

Standaard staat `MAIL_MAILER=log` in `.env`. De verstuurde mails worden dan
volledig weggeschreven naar **`storage/logs/laravel.log`**, zodat je zonder
extra software kan controleren dat ze vertrekken.

Wil je de mails als echte e-mail zien, installeer dan
[Mailpit](https://github.com/axllent/mailpit) en zet in `.env`:

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
```

Mailpit vangt alles op en toont het op <http://localhost:8025>.

Het adres waar contactformulieren naartoe gaan, staat los in `.env`:

```dotenv
MAIL_ADMIN_ADDRESS=admin@ehb.be
```

---

## Wat zit er in de site

### Verplichte functionaliteit

| Vereiste | Waar |
| --- | --- |
| Inloggen, registreren, uitloggen | `/login`, `/register` |
| Remember me | Vinkje "Ingelogd blijven" op het loginscherm |
| Wachtwoord vergeten en opnieuw instellen | `/forgot-password` |
| Gewone gebruiker of admin | Kolom `is_admin` op `users` |
| Enkel admins geven of nemen adminrechten | `/beheer/gebruikers`, knop "Maak beheerder" |
| Enkel admins maken handmatig een gebruiker aan | `/beheer/gebruikers/create` |
| Publieke profielpagina voor iedereen | `/leden/{gebruikersnaam}` |
| Eigen gegevens aanpassen | `/profiel` |
| Profiel met username, verjaardag, foto en "over mij" | `/profiel` |
| Nieuws beheren (admin) | `/beheer/nieuws` |
| Nieuwslijst en detail voor iedereen | `/nieuws` |
| Nieuws met titel, afbeelding, inhoud, publicatiedatum | Tabel `news_items` |
| FAQ gegroepeerd per categorie | `/faq` |
| FAQ-categorieën en vragen beheren (admin) | `/beheer/faq-categorieen`, `/beheer/faq` |
| Contactformulier voor iedereen | `/contact` |
| Admin krijgt een mail met de inhoud | `App\Mail\ContactMessageReceived` |

### Extra features

- **Adminpaneel met eigen layout.** Zijbalk, kerncijfers en een teller van het
  aantal onbeantwoorde berichten.
- **Inbox voor contactformulieren.** Alle ingevulde formulieren staan in
  `/beheer/berichten`, met filters op open of beantwoord. Een beheerder tikt
  daar een antwoord in, dat opgeslagen wordt én per e-mail naar de afzender gaat.
- **Reacties op nieuwsitems.** Ingelogde leden reageren onder een bericht. Je
  eigen reactie mag je zelf wissen, beheerders mogen elke reactie wissen
  (`CommentPolicy`).
- **Trainingsagenda met inschrijvingen.** Leden schrijven zich in en weer uit
  voor trainingen. Er is een maximum aantal deelnemers, inschrijven kan niet
  meer zodra een training gestart of volzet is, en beheerders zien per training
  de volledige deelnemerslijst.
- **Geplande nieuwsitems.** Een bericht met een publicatiedatum in de toekomst
  is nog niet zichtbaar voor bezoekers, maar wel al voor beheerders.
- **Ledenlijst met zoekfunctie** op `/leden`, en filters op niveau en periode
  in de trainingsagenda.
- **Persoonlijk dashboard** op `/mijn-klimclub` met je eigen inschrijvingen.
- **Nederlandstalige validatie- en foutmeldingen** via `lang/nl`.

---

## Technische opbouw

### Modellen en relaties

| Model | Tabel |
| --- | --- |
| `User` | `users` |
| `NewsItem` | `news_items` |
| `Comment` | `comments` |
| `FaqCategory` | `faq_categories` |
| `Faq` | `faqs` |
| `Training` | `trainings` |
| `TrainingRegistration` | `training_user` (pivotmodel) |
| `ContactMessage` | `contact_messages` |

**One-to-many**

- `User` → `NewsItem` (een admin schrijft veel nieuwsitems)
- `NewsItem` → `Comment` (een bericht heeft veel reacties)
- `User` → `Comment`
- `FaqCategory` → `Faq` (een categorie groepeert veel vragen)
- `User` → `Training` via `instructor_id` (een lesgever begeleidt veel trainingen)

**Many-to-many**

- `User` ↔ `Training` via de koppeltabel `training_user`. De pivot bewaart
  `registered_at` als extra kolom en wordt gemapt op het pivotmodel
  `TrainingRegistration`, zodat die kolom meteen een datumobject is.

### Views

- **Drie layouts**: `layouts/app` (publieke site), `layouts/admin` (beheer met
  zijbalk) en `layouts/guest` (in- en uitlogschermen). De eerste twee zijn
  class-based componenten in `app/View/Components`.
- **Componenten** in `resources/views/components`: `alert`, `avatar`, `badge`,
  `card`, `delete-form`, `empty-state`, `faq-item`, `news-card`, `page-header`,
  `rich-text`, `training-card`, `select-input`, `textarea` en `admin/nav-link`,
  naast de formuliercomponenten van Breeze.
- **Control structures**: `@if`, `@foreach`, `@forelse`, `@auth`, `@guest`,
  `@can`, `@selected`, `@checked`, `@required` en `@method` worden doorheen de
  views gebruikt.
- **XSS-bescherming**: alle uitvoer gaat via `{{ }}`. Waar meerregelige tekst uit
  de databank getoond wordt, gebeurt dat via de component `x-rich-text`, die
  eerst `e()` toepast en pas daarna `nl2br()`. Er staat nergens ongefilterde
  invoer in een `{!! !!}`.
- **CSRF-bescherming**: elk formulier bevat `@csrf`; verwijder- en
  wijzigingsformulieren gebruiken daarnaast `@method`.
- **Client-side validatie**: de formulieren gebruiken `required`, `minlength`,
  `maxlength`, `min`, `max`, `pattern`, `accept` en de juiste `type`-waarden
  (`email`, `date`, `datetime-local`, `number`). Dezelfde regels staan nog eens
  in de form requests op de server.

### Routes

Alle routes staan in `routes/web.php` en verwijzen naar controller methods; er
staat geen logica in een closure. Ze zijn gegroepeerd per sectie:

- publieke routes (geen middleware);
- routes voor ingelogde leden achter `auth`;
- het adminpaneel achter `['auth', 'admin']` met prefix `/beheer` en naamprefix
  `admin.`.

De CRUD-schermen gebruiken `Route::resource`. De authenticatieroutes van Breeze
staan apart in `routes/auth.php`.

### Controllers

De publieke controllers doen enkel lezen; het beheer zit in aparte resource
controllers onder `App\Http\Controllers\Admin`. Validatie gebeurt in form
requests (`app/Http/Requests`), het opslaan en verwijderen van uploads in
`App\Services\ImageUploader`.

### Autorisatie

- `App\Http\Middleware\EnsureUserIsAdmin`, geregistreerd als alias `admin` in
  `bootstrap/app.php`, bewaakt het volledige adminpaneel.
- `App\Policies\CommentPolicy` bepaalt wie een reactie mag verwijderen.

### Afbeeldingen

Uploads komen op de `public` disk (`storage/app/public`) terecht met een door
Laravel gegenereerde unieke bestandsnaam. De voorbeeldafbeeldingen die met de
seeders meekomen staan in `database/seeders/assets` en worden bij het seeden
naar diezelfde disk gekopieerd. Ze zijn met PHP GD gegenereerd, dus er is geen
internetverbinding nodig om de site te vullen.

---

## Tests

```bash
php artisan test
```

De testsuite draait op een SQLite-databank in het geheugen en raakt je eigen
databank dus niet aan. Ze dekt de publieke pagina's, de adminmiddleware, CRUD op
nieuws, het contactformulier met beide mails, de inschrijvingen op trainingen,
de reacties en het gebruikersbeheer.

---

## Bronvermelding

Alle code in dit project is door mij geschreven, met uitzondering van de
scaffolding die hieronder vermeld staat. De gebruikte documentatie:

**Startpunt en scaffolding**

- [Laravel 13 documentatie](https://laravel.com/docs/13.x) — het volledige
  framework: routing, Eloquent, validatie, Blade, mail, testing.
- [Laravel Breeze](https://laravel.com/docs/13.x/starter-kits#laravel-breeze) —
  gebruikt om de authenticatie te scaffolden (`php artisan breeze:install blade`).
  Dat leverde de basisschermen voor inloggen, registreren, wachtwoord vergeten
  en het profiel, plus de layout `layouts/guest` en de formuliercomponenten.
  Ik heb die bestanden daarna aangepast: de opmaak is herwerkt, alle teksten zijn
  vertaald, het registratieformulier kreeg een verplicht `username`-veld en het
  profielformulier is uitgebreid met verjaardag, "over mij" en de upload van een
  profielfoto.

**Documentatie die ik per onderdeel geraadpleegd heb**

- [Eloquent: relaties](https://laravel.com/docs/13.x/eloquent-relationships) —
  voor de one-to-many relaties en voor de many-to-many met extra pivotkolom
  (`withPivot`, `using`, `syncWithoutDetaching`).
- [Bestandsopslag](https://laravel.com/docs/13.x/filesystem) en
  [Validatie van bestanden](https://laravel.com/docs/13.x/validation#rule-image) —
  voor het opslaan van profielfoto's en nieuwsafbeeldingen op de `public` disk.
- [Mail](https://laravel.com/docs/13.x/mail#markdown-mailables) — voor de twee
  markdown-mailables van het contactformulier.
- [Autorisatie](https://laravel.com/docs/13.x/authorization#creating-policies) —
  voor de `CommentPolicy`.
- [Middleware](https://laravel.com/docs/13.x/middleware#registering-middleware) —
  voor het registreren van de alias `admin` in `bootstrap/app.php`.
- [Blade-componenten](https://laravel.com/docs/13.x/blade#components) — voor de
  herbruikbare componenten en de twee eigen layouts.
- [Tailwind CSS v3 documentatie](https://v3.tailwindcss.com/docs) — voor de
  opmaak van alle pagina's.
- [Alpine.js documentatie](https://alpinejs.dev/start-here) — voor het
  uitklapmenu op mobiel, de FAQ-accordeon en het bevestigingspaneel bij het
  verwijderen van een account.
- [PHP GD-documentatie](https://www.php.net/manual/en/book.image.php) — voor het
  script waarmee ik de voorbeeldafbeeldingen van de seeders gegenereerd heb.

De teksten op de site (nieuwsberichten, FAQ-antwoorden, trainingsomschrijvingen)
zijn zelf geschreven voor deze fictieve club. De afbeeldingen zijn gegenereerd,
er is dus geen materiaal van derden gebruikt.

---

## Belangrijk om te weten

- **`vendor` en `node_modules` staan in `.gitignore`** en zitten dus niet in de
  repo. Draai `composer install` en `npm install` na het clonen.
- **`.env` staat ook in `.gitignore`.** Gebruik `.env.example` als vertrekpunt.
- De site is in het Nederlands; `APP_LOCALE` staat op `nl` met `en` als terugval.
- Datums worden getoond met `translatedFormat()`, zodat maanden en dagen in het
  Nederlands verschijnen.
