<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProposalController;

Route::get('/', fn() => view('welcome'));
Route::view('/generate', 'pitchcraft')->name('pitchcraft');
// Route::get('/generate', fn() => view('pitchcraft'));

// Route::post('/generate-proposal', [ProposalController::class, 'generate']);


// Route::get('/pitchcraft', [ProposalController::class, 'index'])->name('pitchcraft.index');
// Route::post('/api/generate-proposal', [ProposalController::class, 'generate'])->name('api.generate-proposal');