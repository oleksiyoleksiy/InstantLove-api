<?php

use App\Enums\TokenAbility;
use App\Http\Controllers\Account\AccountController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\ProfileImage\ProfileImageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'ability:' . TokenAbility::ACCESS_API->value])->group(function () {
    Route::resource('profile', ProfileController::class);
    // Route::post('profile/update', [ProfileController::class, 'update']);
    Route::resource('profile.image', ProfileImageController::class)->only(['store', 'destroy']);
});

Route::resource('image', ImageController::class)->only('show');
Route::post('/refresh', [AccountController::class, 'refresh'])->middleware('ability:' . TokenAbility::ISSUE_ACCESS_TOKEN->value);

Route::middleware('guest:sanctum')->controller(AccountController::class)->group(function () {
    Route::post('/login', 'login');
    Route::post('/register', 'register');
    Route::post('/refresh', 'refresh');
    Route::post('/isUserExists', 'isUserExists');
});
