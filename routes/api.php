<?php

use App\Http\Controllers\Api\ChatBotController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/whatsapp/{number}', [ChatBotController::class, 'sendwhatsapp']);

// Route::get('/webhook', [ChatBotController::class, 'getwebhook']);
// Route::post('/webhook', [ChatBotController::class, 'postwebhook']);

Route::post('/webhook', [ChatBotController::class, 'handleWebhook']);
