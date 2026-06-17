<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gemini\Laravel\Facades\Gemini;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = $request->input('message');
        
        try {
            // Use the official Gemini Laravel package with gemini-1.5-flash model
            $result = Gemini::model('gemini-1.5-flash')->generateContent($request->input('message'));
            
            $botReply = $result->text();
            
            return response()->json([
                'success' => true,
                'message' => $botReply,
            ]);

        } catch (\Exception $e) {
            \Log::error('Gemini API exception', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Debug Error: ' . $e->getMessage(),
            ], 500);
        }
    }
}
