<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatroomController;
use App\Http\Controllers\MessageController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('chatrooms')->group(function () {
        Route::post('/', [ChatroomController::class, 'createChatroom'])
            ->name('chatrooms.create');

        Route::get('/', [ChatroomController::class, 'listChatrooms'])
            ->name('chatrooms.list');

        Route::post('{chatroomId}/enter', [ChatroomController::class, 'enterChatroom'])
            ->name('chatrooms.enter');

        Route::delete('{chatroomId}/leave', [ChatroomController::class, 'leaveChatroom'])
            ->name('chatrooms.leave');

        Route::prefix('{chatroomId}/messages')->group(function () {
            Route::post('/', [MessageController::class, 'sendMessage'])
                ->name('messages.send');

            Route::get('/', [MessageController::class, 'listMessages'])
                ->name('messages.list');
        });
    });
});
