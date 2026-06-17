<?php

use App\Http\Controllers\ChatbotController;

// Chatbot Route
Route::post('/chatbot/message', [ChatbotController::class, 'sendMessage'])->name('chatbot.message');

require __DIR__.'/web_back/auth.php';
require __DIR__.'/web_back/profile.php';
require __DIR__.'/web_front/front.php';
require __DIR__.'/web_back/back.php';
