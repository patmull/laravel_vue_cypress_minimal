<?php

use App\Http\Controllers\Http\Controllers\Auth\AdminEmailController;
use App\Http\Controllers\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Http\Controllers\Auth\DocumentController;
use App\Http\Controllers\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Http\Controllers\ProfileImageController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

require __DIR__.'/auth.php';
