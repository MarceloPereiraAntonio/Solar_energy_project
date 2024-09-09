<?php

use App\Http\Controllers\Api\{
    ClientController, 
    EquipmentController, 
    ProjectController, 
    InstallationTypeController};
use Illuminate\Support\Facades\Route;

//Client
Route::get('/client', [ClientController::class, 'index']);
Route::post('/client', [ClientController::class, 'store']);
Route::get('/client/{id}', [ClientController::class, 'show']);
Route::put('/client/{id}', [ClientController::class, 'update']);
Route::delete('/client/{id}', [ClientController::class, 'destroy']);

//Installation types
Route::get('/install_type', [InstallationTypeController::class, 'index']);
Route::post('/install_type', [InstallationTypeController::class, 'store']);
Route::get('/install_type/{id}', [InstallationTypeController::class, 'show']);
Route::put('/install_type/{id}', [InstallationTypeController::class, 'update']);
Route::delete('/install_type/{id}', [InstallationTypeController::class, 'destroy']);

//Equipment
Route::get('/equipment', [EquipmentController::class, 'index']);
Route::post('/equipment', [EquipmentController::class, 'store']);
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);
Route::put('/equipment/{id}', [EquipmentController::class, 'update']);
Route::delete('/equipment/{id}', [EquipmentController::class, 'destroy']);

//Project
Route::get('/projects', [ProjectController::class, 'index']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);




