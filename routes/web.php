<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProposalController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/generate-proposal', [ProposalController::class, 'generate']);


Route::get('/pitchcraft', [ProposalController::class, 'index'])->name('pitchcraft.index');
Route::post('/api/generate-proposal', [ProposalController::class, 'generate'])->name('api.generate-proposal');