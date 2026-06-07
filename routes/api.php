<?php

use App\Http\Controllers\Api\AttendanceApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Api\FingerprintController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/fingerprints', [FingerprintController::class, 'index']);
Route::post('/fingerprints/enroll', [FingerprintController::class, 'enroll']);
Route::get('/fingerprints/{studentId}/{fingerIndex}', [FingerprintController::class, 'show']);
Route::delete('/fingerprints/{studentId}/{fingerIndex}', [FingerprintController::class, 'destroy']);

Route::post('/attendance/verify', [AttendanceApiController::class, 'verify']);
