<?php

use Illuminate\Support\Facades\Route;

// controllers
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BookController;
use App\Http\Controllers\API\BorrowController;



// Route::prefix('')->group(function () {

    // Route::get('/test', function () {
    //     return response()->json(['message' => 'API is working!']);
    // });

    
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/books', [BookController::class, 'index']);
    Route::get('/books/{id}', [BookController::class, 'show']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::post('/books/{id}/borrow', [BorrowController::class, 'borrow']);
        Route::post('/books/{id}/return', [BorrowController::class, 'returnBook']);

        Route::middleware('role:admin')->group(function () {
            Route::post('/books', [BookController::class, 'store']);   // Add book
            Route::put('/books/{id}', [BookController::class, 'update']); // Edit book
            Route::delete('/books/{id}', [BookController::class, 'destroy']); // Delete book
        });



        // // Example: admin-only route
        // Route::middleware('role:admin')->get('/admin/dashboard', function () {
        //     return response()->json(['message' => 'Welcome Admin!']);
        // });

        // // Example: normal user route
        // Route::get('/user/profile', function (\Illuminate\Http\Request $request) {
        //     return $request->user();
        // });
    });
// });
