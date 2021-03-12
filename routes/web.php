<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

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

Route::get( '/error', function () {
    return response()->json(
        [
            'status' => 401,
            'token' =>'Headers o token bearer incorrecto usa: application/json y token'
        ],401);
}
)->name('login');
