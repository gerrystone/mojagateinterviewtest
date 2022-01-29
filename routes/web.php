<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $customers = \App\Models\Customer::all();
    return view('welcome', compact('customers'));
});
Route::post('add_customer', [\App\Http\Controllers\CustomersController::class, 'add_customer'])->name('add_customer');
Route::get('send_message_page', [\App\Http\Controllers\MessagesController::class, 'send_message_page'])->name('send_message_page');
Route::post('send_message', [\App\Http\Controllers\MessagesController::class, 'send_message'])->name('send_message');
