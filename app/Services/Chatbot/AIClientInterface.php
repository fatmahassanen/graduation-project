<?php

namespace App\Services\Chatbot;

/**
 * Interface for AI client implementations
 * 
 * This interface defines the contract for AI service providers (OpenAI, Gemini, etc.)
 * to ensure consistent behavior across different AI backends.
 */
interface AIClientInterface
{
    /**
     * Send a message to the AI service and get a response
     *
     * @param string $systemPrompt The system prompt containing context and instructions
     * @param string $userMessage The user's message to process
     * @param array $conversationHistory Array of previous messages in the conversation
     * @return string The AI-generated response text
     * @throws \App\Services\Chatbot\Exceptions\AIServiceException If the AI service fails
     */
    public function sendMessage(string $systemPrompt, string $userMessage, array $conversationHistory = []): string;

    /**
     * Check if the AI service is available and properly configured
     *
     * @return bool True if the service is available, false otherwise
     */
    public function isAvailable(): bool;
}
