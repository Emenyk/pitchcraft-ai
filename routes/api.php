<?php

use App\Http\Controllers\ProposalController;
use Illuminate\Support\Facades\Route;

Route::post('/generate-proposal', [ProposalController::class, 'generate']);