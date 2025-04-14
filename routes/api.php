<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\CategoryController;

// Debug route to test if API routes are working
Route::get('test', function () {
    return response()->json(['message' => 'API is working']);
});

// Debug route to check all registered routes
Route::get('debug-routes', function () {
    return response()->json([
        'routes' => Route::getRoutes()->getRoutesByName(),
        'current_route' => Route::currentRouteName(),
        'current_uri' => request()->path()
    ]);
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Public routes
Route::get('categories', [CategoryController::class, 'index']);
Route::get('categories/{category}', [CategoryController::class, 'show']);
Route::get('videos', [VideoController::class, 'index']);
Route::get('videos/{video}', [VideoController::class, 'show']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Video routes
    Route::post('videos', [VideoController::class, 'store']);
    Route::put('videos/{video}', [VideoController::class, 'update']);
    Route::delete('videos/{video}', [VideoController::class, 'destroy']);
    
    // Category management routes (admin only)
    Route::middleware('admin')->group(function () {
        Route::post('categories', [CategoryController::class, 'store']);
        Route::put('categories/{category}', [CategoryController::class, 'update']);
        Route::delete('categories/{category}', [CategoryController::class, 'destroy']);
    });
});
