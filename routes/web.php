<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FeedbackSystemController;
use App\Http\Controllers\RecommendationController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [FeedbackSystemController::class, 'index']);
// Route::get('/tes',[ProductController::class, 'getProduct']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/search', [ProductController::class, 'search']);
Route::get('/recommendation',[RecommendationController::class, 'index']);
Route::get('/hasilrec',[RecommendationController::class, 'getRecommendations'])->name('hasilrec');
Route::post('/feedback/store', [FeedbackSystemController::class, 'store'])->name('feedback.store');
// Route::get('/import-products', [ProductController::class, 'import']);
