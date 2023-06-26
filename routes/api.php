<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;


Route::group(['prefix' => 'v1'], function () {
    Route::get('categories', [CategoryController::class, 'categories']);
    Route::get('products', [ProductController::class, 'index']);
    Route::post('product/store', [ProductController::class, 'store']);
    Route::get('product/{id}', [ProductController::class, 'edit']);
    Route::post('product/{id}', [ProductController::class, 'update']);
});
