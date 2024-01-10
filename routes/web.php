<?php

use App\Http\Controllers\PushController;
use App\Http\Controllers\TController;
use App\Http\Controllers\Web\Payment\PaymentCallBackController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Minishlink\WebPush\VAPID;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//   "publicKey" => "BJjLYY6AAogCJ2cwtIwV2NWiguCVkHzMfcW63oI1YZ59JMn9yD_Ci9nYXcOm7mU4dJBmOA0pFiVOcj19ZFf25g8"
//   "privateKey" => "7bw0xOPDDv1h7QKgxFX4Z71owq9oCh1PRMfU_pHy29I"

// Route::get('/admin', [PushController::class, 'index'])->name('push.index');
// Route::post('/admin/sendpush/{push}', [PushController::class, 'send'])->name('push.send');

// Route::
// middleware(['throttle:test'])->
// get('/', [TController::class, 'index'])->name('index');
// Route::get('/event', function () {
//     event(new \App\Events\TestEvent("hi","mahdi"));
// });
// Route::get('/event2', function () {
//     event(new \App\Events\TestPrivateEvent("hi", "mahdi"));
// });
// Route::get('/', function () {
//     return view("websocket");
// });
//
//////////////for market project
Route::any('/payment-call-back/{onlinePayment}/{type_payment}/{wallet_payment}', [PaymentCallBackController::class, 'paymentCallback'])->name('payment-call-back');
Route::get('/payment-result/{id}', [PaymentCallBackController::class, 'paymentResult'])->name('payment-result');
