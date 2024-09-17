<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Profile\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value])->group(function () {
    Route::resource('profile', ProfileController::class)->except('update');
    Route::post('profile/{profile}', [ProfileController::class, 'update']);
});

Route::post('/refresh', [AccountController::class, 'refresh'])->middleware('ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value);

Route::middleware('guest:sanctum')->controller(AccountController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/refresh', 'refresh');
    Route::post('/isUserExists', 'isUserExists');
});
