<?php

use App\Http\Controllers\AplicationController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('{view}', AplicationController::class)->where('view','(.*)');