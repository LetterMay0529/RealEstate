<?php

use Illuminate\Http\Request;
use \App\Http\Controllers\AdminController;
use \App\Http\Controllers\AgentController;
use \App\Http\Controllers\CommercialController;
use \App\Http\Controllers\LandController;
use \App\Http\Controllers\ResidentialController;
use \App\Http\Controllers\SeekerController;
use Illuminate\Support\Facades\Route;

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
Route::post('/admin/login', [AdminController::class, 'login']);
Route::post('/admin/register', [AdminController::class, 'register']);

Route::post('/agent/login', [AgentController::class, 'login']);
Route::post('/agent/register', [AgentController::class, 'register']);

Route::post('/seeker/login', [SeekerController::class, 'login']);
Route::post('/seeker/register', [SeekerController::class, 'register']);

Route::group(['middleware'=>'auth:api'], function() {
    Route::get('/admin/admin', [AdminController::class, 'me']);
    Route::post('/admin/logout', [AdminController::class, 'logout']);
});

Route::group(['middleware'=>'auth:agent-api'], function() {
    Route::get('/agent/agent', [AgentController::class, 'agent']);
    Route::post('/agent/logout', [AgentController::class, 'logout']);

    Route::post('/commercial/search', [CommercialController::class, 'search']);
    Route::post('/commercial', [CommercialController::class, 'store']);
    Route::get('/commercial', [CommercialController::class, 'index']);

    Route::post('/residential/search', [ResidentialController::class, 'search']);
    Route::post('/residential', [ResidentialController::class, 'store']);
    Route::get('/residential', [ResidentialController::class, 'index']);

    Route::post('/land/search', [LandController::class, 'search']);
    Route::post('/land', [LandController::class, 'store']);
    Route::get('/land', [LandController::class, 'index']);
});

Route::group(['middleware'=>'owner'], function() {
    Route::get('/commercial/{commercial}', [CommercialController::class, 'show']);
    Route::put('/commercial/{commercial}', [CommercialController::class, 'update']);
    Route::delete('/commercial/{commercial}', [CommercialController::class, 'destroy']);
});

Route::group(['middleware'=>'owner'], function() {
    Route::get('/residential/{residential}', [ResidentialController::class, 'show']);
    Route::put('/residential/{residential}', [ResidentialController::class, 'update']);
    Route::delete('/residential/{residential}', [ResidentialController::class, 'destroy']);
});

Route::group(['middleware'=>'ownr'], function() {
    Route::get('/land/{land}', [LandController::class, 'show']);
    Route::put('/land/{land}', [LandController::class, 'update']);
    Route::delete('/land/{land}', [LandController::class, 'destroy']);
});

Route::group(['middleware'=>'auth:seeker-api'], function() {
    Route::get('/seeker/seeker', [SeekerController::class, 'seeker']);
    Route::post('/seeker/logout', [SeekerController::class, 'logout']);
});