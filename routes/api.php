<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Apis;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register', [Apis::class, 'register']);
Route::post('/login', [Apis::class, 'login']);
Route::get('/login', [Apis::class, 'autherror'])->name('login');

Route::middleware('auth:api')->get('/userlist',[Apis::class,'userlist'] );
Route::middleware('auth:api')->post('/addtask',[Apis::class,'addtask'] );
Route::middleware('auth:api')->get('/logout',[Apis::class,'logout'] );


