<?php

use App\Http\Controllers\OtpController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect(route('filament.user.auth.login'));

});
Route::controller(\App\Http\Controllers\OtpController::class)->group(function () {
    Route::post('/sms/{phoneNumber?},{message?}',  'Sms')->name('sms');
    Route::get('/viewcontact',  'ViewContact')->name('viewcontact');
});







