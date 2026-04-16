<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\BesoinController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\TacheController;
use Illuminate\Support\Facades\Route;

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
});

// Routes Associations
Route::get('/associations', [AssociationController::class, 'index'])
    ->name('associations.index');
Route::get('/associations/create', [AssociationController::class, 'create'])
    ->name('associations.create')->middleware('auth');
Route::post('/associations', [AssociationController::class, 'store'])
    ->name('associations.store')->middleware('auth');
Route::get('/associations/{association}', [AssociationController::class, 'show'])
    ->name('associations.show');

// Routes Campaigns
Route::get('/campaigns', [CampaignController::class, 'index'])
    ->name('campaigns.index');
Route::get('/campaigns/create', [CampaignController::class, 'create'])
    ->name('campaigns.create')->middleware('auth');
Route::post('/campaigns', [CampaignController::class, 'store'])
    ->name('campaigns.store')->middleware('auth');
Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])
    ->name('campaigns.show');

// Routes Besoins (accessible sans connexion)
Route::get('/besoins/create', [BesoinController::class, 'create'])
    ->name('besoins.create');
Route::post('/besoins', [BesoinController::class, 'store'])
    ->name('besoins.store');
Route::get('/besoins/confirmation', [BesoinController::class, 'confirmation'])
    ->name('besoins.confirmation');

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
    Route::post('/taches/{tache}/postuler', [TacheController::class, 'postuler'])
        ->name('taches.postuler');
    Route::post('/taches/{tache}/compte-rendu', [TacheController::class, 'compte_rendu'])
        ->name('taches.compte_rendu');
});

// Routes Admin
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'index'])
        ->name('index');
    Route::post('/associations/{association}/valider', [AdminController::class, 'validerAssociation'])
        ->name('associations.valider');
    Route::post('/associations/{association}/rejeter', [AdminController::class, 'rejeterAssociation'])
        ->name('associations.rejeter');
});

require __DIR__.'/auth.php';
