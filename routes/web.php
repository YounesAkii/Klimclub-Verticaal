<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingRegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Publieke routes
|--------------------------------------------------------------------------
|
| Deze pagina's zijn voor iedereen toegankelijk, ook zonder account.
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::controller(NewsItemController::class)->prefix('nieuws')->name('news.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{newsItem:slug}', 'show')->name('show');
});

Route::controller(TrainingController::class)->prefix('trainingen')->name('trainings.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{training:slug}', 'show')->name('show');
});

Route::controller(UserController::class)->prefix('leden')->name('users.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{user:username}', 'show')->name('show');
});

Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

Route::controller(ContactController::class)->prefix('contact')->name('contact.')->group(function () {
    Route::get('/', 'create')->name('create');
    Route::post('/', 'store')->name('store');
});

/*
|--------------------------------------------------------------------------
| Routes voor ingelogde gebruikers
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/mijn-klimclub', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profiel', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profiel', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profiel', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Reacties op nieuwsitems.
    Route::post('/nieuws/{newsItem:slug}/reacties', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/reacties/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // In- en uitschrijven voor een training (many-to-many user <-> training).
    Route::post('/trainingen/{training:slug}/inschrijven', [TrainingRegistrationController::class, 'store'])
        ->name('trainings.register');
    Route::delete('/trainingen/{training:slug}/inschrijven', [TrainingRegistrationController::class, 'destroy'])
        ->name('trainings.unregister');
});

/*
|--------------------------------------------------------------------------
| Adminpaneel
|--------------------------------------------------------------------------
|
| Alles achter /beheer vereist een ingelogde gebruiker met adminrechten.
| De 'admin'-middleware is geregistreerd in bootstrap/app.php.
|
*/

Route::middleware(['auth', 'admin'])->prefix('beheer')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    Route::resource('nieuws', Admin\NewsItemController::class)
        ->parameters(['nieuws' => 'newsItem'])
        ->names('news')
        ->except('show');

    Route::resource('faq-categorieen', Admin\FaqCategoryController::class)
        ->parameters(['faq-categorieen' => 'faqCategory'])
        ->names('faq-categories')
        ->except('show');

    Route::resource('faq', Admin\FaqController::class)
        ->names('faqs')
        ->except('show');

    Route::resource('trainingen', Admin\TrainingController::class)
        ->parameters(['trainingen' => 'training'])
        ->names('trainings');

    Route::patch('gebruikers/{user}/rol', [Admin\UserController::class, 'toggleRole'])->name('users.role');
    Route::resource('gebruikers', Admin\UserController::class)
        ->parameters(['gebruikers' => 'user'])
        ->names('users')
        ->except('show');

    Route::controller(Admin\ContactMessageController::class)
        ->prefix('berichten')
        ->name('contact-messages.')
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{contactMessage}', 'show')->name('show');
            Route::post('/{contactMessage}/antwoord', 'reply')->name('reply');
            Route::delete('/{contactMessage}', 'destroy')->name('destroy');
        });
});

require __DIR__.'/auth.php';
