<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::apiResource('pages', PageController::class);
