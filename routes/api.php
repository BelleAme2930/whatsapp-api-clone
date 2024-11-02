<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes handle user registration and login. All user-related routes
| are secured using Sanctum for authentication.
|
*/

// Registration route
Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

// Login route
Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

// Authenticated user route
Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Chatroom Routes
|--------------------------------------------------------------------------
|
| These routes handle all chatroom-related actions. Access is secured using
| Sanctum and organized into a prefix group for cleaner routing.
|
*/

Route::middleware(['auth:sanctum'])->group(function () {
    // Chatroom routes
    Route::prefix('chatrooms')->name('chatrooms.')->group(function () {

        // Create a new chatroom
        Route::post('/', [ChatroomController::class, 'createChatroom'])
            ->name('create');

        // List all chatrooms
        Route::get('/', [ChatroomController::class, 'listChatrooms'])
            ->name('list');

        // Enter a chatroom
        Route::post('{chatroomId}/enter', [ChatroomController::class, 'enterChatroom'])
            ->name('enter');

        // Leave a chatroom
        Route::delete('{chatroomId}/leave', [ChatroomController::class, 'leaveChatroom'])
            ->name('leave');

        // Message routes within a chatroom
        Route::prefix('{chatroomId}/messages')->group(function () {

            // Send a message
            Route::post('/', [MessageController::class, 'sendMessage'])
                ->name('messages.send');

            // List all messages
            Route::get('/', [MessageController::class, 'listMessages'])
                ->name('messages.list');
        });
    });
});
