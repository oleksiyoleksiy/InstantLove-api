<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Account\AccountController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value])->group(function () {
    Route::post('/refresh', [AccountController::class, 'refresh']);
});

Route::middleware('guest:sanctum')->controller(AccountController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/refresh', 'refresh');
    Route::post('/isUserExists', 'isUserExists');
});
