<?php

use App\Http\Controllers\Api\ProviderController;
use Illuminate\Support\Facades\Route;

Route::get('/providers', [ProviderController::class, 'index']);
Route::get('/providers/{provider}', [ProviderController::class, 'show']);