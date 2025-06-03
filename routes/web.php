<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\AbsensiController;

Route::post('/login', [AuthController::class, 'login'])-> name('login');
Route::post('/register', [AuthController::class, 'register'])-> name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/membership/payment', [MembershipController::class, 'createPayment']);
Route::post('/midtrans/callback', [MembershipController::class, 'handleNotification']);

Route::middleware('auth')->group(function () {
    Route::post('/absensi', [AbsensiController::class, 'store']);
    Route::get('/absensi', [AbsensiController::class, 'getByDate']);
});




Route::get('/', function () {
    return view('landingPage');
});
Route::get('/dashboardUser', [MembershipController::class, 'showMembership'])->name('dashboardUser'); // atau nama rute lain

Route::get('/login', function () {
    return view('login');
});