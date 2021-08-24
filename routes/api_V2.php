<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//
Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/mail/show_headings/{mail}', 'MailController@show_headings');
    Route::get('/mail/show_mails/{headings_id}', 'MailController@show_mails');


    Route::post('/logout', [AuthController::class, 'logout']);
});
Route::apiResources([
    'mail' => MailController::class,

]);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


Route::get('/mail/destroy/{mail}/{headings_id}', 'MailController@destroy_headings');
Route::delete('/mail/destroy/{mail}/{key}', 'MailController@destroy');




