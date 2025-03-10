<?php
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\Auth\MemberAuthController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});





// Member Login
Route::get('/login', [MemberAuthController::class, 'showLoginForm'])->name('member.login.form');
Route::post('/login', [MemberAuthController::class, 'login'])->name('member.login');
Route::post('/logout', [MemberAuthController::class, 'logout'])->name('member.logout');

// Member Dashboard (Protected)
Route::middleware('auth:member')->group(function () {
    Route::get('/dashboard', [SurveyController::class, 'dashboard'])->name('member.dashboard');

    Route::get('/survey/{survey}', [SurveyController::class, 'show'])->name('survey.show');
    Route::post('/survey/{survey}', [SurveyController::class, 'store'])->name('survey.store');
});

