<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\BesoinController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');//zedtou
});

// Routes Associations
Route::get('/associations', [AssociationController::class, 'index'])
    ->name('associations.index');
Route::get('/associations/create', [AssociationController::class, 'create'])
    ->name('associations.create')->middleware('auth');
Route::post('/associations', [AssociationController::class, 'store'])
    ->name('associations.store')->middleware('auth');
Route::get('/associations/{association}/edit', [AssociationController::class, 'edit'])
    ->name('associations.edit')->middleware('auth');
Route::put('/associations/{association}', [AssociationController::class, 'update'])
    ->name('associations.update')->middleware('auth');
Route::delete('/associations/{association}', [AssociationController::class, 'destroy'])
    ->name('associations.destroy')->middleware('auth');
Route::get('/associations/{association}', [AssociationController::class, 'show'])
    ->name('associations.show');

// Routes Campaigns
Route::get('/campaigns', [CampaignController::class, 'index'])
    ->name('campaigns.index');
Route::get('/campaigns/create', [CampaignController::class, 'create'])
    ->name('campaigns.create')->middleware('auth');
Route::post('/campaigns', [CampaignController::class, 'store'])
    ->name('campaigns.store')->middleware('auth');
Route::get('/campaigns/{campaign}/edit', [CampaignController::class, 'edit'])
    ->name('campaigns.edit')->middleware('auth');
Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])
    ->name('campaigns.update')->middleware('auth');
Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])
    ->name('campaigns.destroy')->middleware('auth');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])
    ->name('campaigns.show');
// ===== Ajouter dans web.php après les routes campaigns existantes =====

// Photos galerie
Route::delete('/campaigns/photos/{photo}', [CampaignController::class, 'deletePhoto'])
    ->name('campaigns.photos.delete');

// Transactions (entrées/sorties)
Route::post('/campaigns/{campaign}/transactions', [CampaignController::class, 'storeTransaction'])
    ->name('campaigns.transactions.store');
Route::delete('/campaigns/transactions/{transaction}', [CampaignController::class, 'deleteTransaction'])
    ->name('campaigns.transactions.delete');

// Notation ⭐
Route::post('/campaigns/{campaign}/rate', [CampaignController::class, 'rate'])
    ->name('campaigns.rate');


// Routes Besoins
Route::get('/besoins', [BesoinController::class, 'index'])
    ->name('besoins.index');
Route::get('/besoins/create', [BesoinController::class, 'create'])
    ->name('besoins.create');
Route::post('/besoins', [BesoinController::class, 'store'])
    ->name('besoins.store');
Route::get('/besoins/confirmation', [BesoinController::class, 'confirmation'])
    ->name('besoins.confirmation');
Route::post('/besoins/{besoin}/prendre-en-charge', [BesoinController::class, 'prendreEnCharge'])
    ->name('besoins.prendre_en_charge')
    ->middleware('auth');
Route::post('/besoins/{besoin}/assigner', [BesoinController::class, 'assigner'])
    ->name('besoins.assigner')
    ->middleware(['auth', \App\Http\Middleware\AdminMiddleware::class]);

// Routes Donations
Route::middleware(['auth'])->group(function () {
    Route::get('/campaigns/{campaign}/donate', [DonationController::class, 'create'])
        ->name('donations.create');
    Route::post('/campaigns/{campaign}/donate', [DonationController::class, 'store'])
        ->name('donations.store');
    Route::get('/donations/historique', [DonationController::class, 'historique'])
        ->name('donations.historique');
});

// Routes Taches (Module Bénévolat)
Route::get('/taches', [TacheController::class, 'index'])
    ->name('taches.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/taches/mes-taches', [TacheController::class, 'mes_taches'])
        ->name('taches.mes_taches');
    Route::get('/taches/create', [TacheController::class, 'create'])
        ->name('taches.create');
    Route::post('/taches', [TacheController::class, 'store'])
        ->name('taches.store');
    Route::get('/taches/{tache}/edit', [TacheController::class, 'edit'])
        ->name('taches.edit');
    Route::put('/taches/{tache}', [TacheController::class, 'update'])
        ->name('taches.update');
    Route::delete('/taches/{tache}', [TacheController::class, 'destroy'])
        ->name('taches.destroy');
    Route::post('/taches/{tache}/postuler', [TacheController::class, 'postuler'])
        ->name('taches.postuler');
    Route::post('/taches/{tache}/compte-rendu', [TacheController::class, 'compte_rendu'])
        ->name('taches.compte_rendu');
    Route::post('/taches/{tache}/archiver', [TacheController::class, 'archiver'])
        ->name('taches.archiver'); // ← AJOUTER
});

// Routes Admin
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [AdminController::class, 'index'])
            ->name('index');
        Route::post('/associations/{association}/valider', [AdminController::class, 'validerAssociation'])
            ->name('associations.valider');
        Route::post('/associations/{association}/rejeter', [AdminController::class, 'rejeterAssociation'])
            ->name('associations.rejeter');
        Route::post('/besoins/{besoin}/valider', [AdminController::class, 'validerBesoin'])
            ->name('besoins.valider');
        Route::post('/besoins/{besoin}/rejeter', [AdminController::class, 'rejeterBesoin'])
            ->name('besoins.rejeter');
        //Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    });

// Routes Chatbot
Route::get('/chatbot', [ChatbotController::class, 'index'])
    ->name('chatbot.index');
Route::post('/chatbot/chat', [ChatbotController::class, 'chat'])
    ->name('chatbot.chat');

// Routes Notifications
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');
    Route::get('/notifications/count', [NotificationController::class, 'count'])
        ->name('notifications.count');
});

// Language switcher
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['fr', 'en'])) {
        Session::put('locale', $locale);
    }
    return redirect()->back();
})->name('lang.switch');

require __DIR__.'/auth.php';
