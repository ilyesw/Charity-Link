<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssociationController;
use App\Http\Controllers\AdminController;
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
    ->name('associations.create')
    ->middleware('auth');

Route::post('/associations', [AssociationController::class, 'store'])
    ->name('associations.store')
    ->middleware('auth');

Route::get('/associations/{association}', [AssociationController::class, 'show'])
    ->name('associations.show');

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
