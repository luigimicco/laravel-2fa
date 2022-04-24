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
    return view('welcome');
});

Auth::routes();

Route::prefix('2fa')->name('2fa.')->group(function(){

    Route::post('/store', 'Google2FAController@store')->name('store');
    Route::get('/enable', 'Google2FAController@enable')->name('enable');
    Route::post('/disable', 'Google2FAController@disable')->name('disable');

    // 2fa middleware
    Route::post('/verify', function () {
        return redirect(URL()->previous());
    })->name('verify')->middleware('2fa');
});
//Route::post('/2fa/validate', ['middleware' => 'throttle:5', 'uses' => 'Auth\LoginController@postValidateToken']);

/*
// test middleware
Route::get('/test_middleware', function () {
    return "2FA middleware work!";
})->middleware(['auth', '2fa']);
*/

Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth', '2fa', 'throttle:5']);
