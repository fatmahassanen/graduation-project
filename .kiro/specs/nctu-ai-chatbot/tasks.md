# Implementation Plan: NCTU AI Chatbot

## Overview

This implementation plan breaks down the NCTU AI Chatbot feature into discrete coding tasks. The chatbot is a multilingual conversational assistant built with Laravel (PHP) backend and JavaScript frontend. It integrates with AI providers (OpenAI/Gemini), provides bilingual support (Arabic/English), includes hallucination prevention, jailbreak protection, and embeds university navigation and marketing content into AI prompts.

## Tasks

- [-] 1. Set up core project structure and service interfaces
  - Create directory structure for chatbot services in `app/Services/Chatbot/`
  - Define `AIClientInterface` with `sendMessage()` and `isAvailable()` methods
  - Create base exception classes: `AIServiceException`, `ValidationException`
  - Set up configuration file `config/chatbot.php` for AI provider settings
  - _Requirements: 10.1, 10.6, 15.1, 15.2_

- [ ] 2. Implement AI client abstraction layer
  - [-] 2.1 Create OpenAI client implementation
    - Implement `OpenAIClient` class that implements `AIClientInterface`
    - Add methods for formatting requests to OpenAI API specification
    - Add methods for parsing and normalizing OpenAI responses
    - Handle authentication with API key from environment
    - _Requirements: 10.2, 10.4, 14.1_
  
  - [-] 2.2 Create Gemini client implementation
    - Implement `GeminiClient` class that implements `AIClientInterface`
    - Add methods for formatting requests to Google Gemini API specification
    - Add methods for parsing and normalizing Gemini responses
    - Handle authentication with API key from environment
    - _Requirements: 10.3, 10.4, 14.1_
  
  - [ ] 2.3 Implement unified response normalization
    - Create method to normalize different provider responses into consistent format
    - Ensure both providers return `AIResponse` objects with same structure
    - _Requirements: 10.5_
  
  - [ ]* 2.4 Write unit tests for AI client implementations
    - Test OpenAI client request formatting and response parsing
    - Test Gemini client request formatting and response parsing
    - Test error handling for both providers
    - Mock HTTP responses to avoid actual API calls
    - _Requirements: 10.1, 10.2, 10.3_

- [ ] 3. Build navigation map and marketing content providers
  - [-] 3.1 Implement NavigationMapProvider service
    - Create `NavigationMapProvider` class with `getNavigationMap()` method
    - Define complete navigation structure matching university website navbar
    - Map all navigation items to Laravel route names
    - Include descriptions for each navigation item
    - Implement `formatForPrompt()` method to format navigation for AI consumption
    - _Requirements: 4.1, 4.2, 20.1, 20.2, 20.3, 20.4_
  
  - [ ] 3.2 Implement MarketingContentProvider service
    - Create `MarketingContentProvider` class with `getMarketingContent()` method
    - Define NCTU unique value propositions
    - Include Top 10 Reasons content
    - Add graduate achievement highlights
    - Implement `formatForPrompt()` method to format marketing content for AI
    - _Requirements: 5.1, 5.2_
  
  - [ ]* 3.3 Write unit tests for content providers
    - Test navigation map structure completeness
    - Test route validity for all navigation items
    - Test marketing content formatting
    - _Requirements: 4.3, 20.3_

- [ ] 4. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 5. Implement prompt builder service
  - [ ] 5.1 Create PromptBuilderService class
    - Implement `buildSystemPrompt()` method
    - Inject NavigationMapProvider and MarketingContentProvider
    - Build prompt with role definition, navigation map, marketing content, and behavioral directives
    - Add bilingual support directives (Arabic/English)
    - Add jailbreak prevention directives
    - Add hallucination prevention directives (avoid specific dates/deadlines)
    - _Requirements: 1.2, 5.5, 12.1, 12.2, 12.3, 12.4_
  
  - [ ] 5.2 Implement prompt caching
    - Cache constructed system prompt for performance
    - Ensure cache invalidation when content changes
    - _Requirements: 12.5_
  
  - [ ] 5.3 Add prompt length validation
    - Validate that system prompt is between 1000 and 8000 characters
    - Log warning if prompt exceeds recommended length
    - _Requirements: 12.6_
  
  - [ ]* 5.4 Write unit tests for prompt builder
    - Test that prompt contains all required sections
    - Test prompt length validation
    - Test caching behavior
    - _Requirements: 12.1, 12.2, 12.3, 12.4, 12.6_

- [ ] 6. Implement language detection functionality
  - [ ] 6.1 Create language detection helper function
    - Implement `detectLanguage()` function that analyzes text
    - Count Arabic characters vs total letter characters
    - Return 'ar' if Arabic ratio >= 30%, otherwise 'en'
    - Handle edge cases (empty text, no letters)
    - _Requirements: 3.1, 3.2, 3.3_
  
  - [ ]* 6.2 Write property test for language detection
    - **Property 1: Language Detection Returns Valid Language Code**
    - **Validates: Requirements 3.1**
    - Test that function always returns 'ar' or 'en'
  
  - [ ]* 6.3 Write property test for Arabic threshold detection
    - **Property 2: Arabic Character Threshold Detection**
    - **Validates: Requirements 3.2**
    - Test that messages with >= 30% Arabic characters return 'ar'
  
  - [ ]* 6.4 Write property test for English threshold detection
    - **Property 3: English Character Threshold Detection**
    - **Validates: Requirements 3.3**
    - Test that messages with < 30% Arabic characters return 'en'
  
  - [ ]* 6.5 Write unit tests for language detection edge cases
    - Test with Egyptian slang and Franco-Arabic
    - Test with mixed language input
    - Test with empty or non-letter input
    - _Requirements: 18.1, 18.4_

- [ ] 7. Implement hallucination detection and sanitization
  - [ ] 7.1 Create hallucination detection function
    - Implement `containsHallucinationPatterns()` function
    - Define patterns: "deadline is on", "exam is on", "registration closes on", etc.
    - Check for uncertainty markers: "please check", "contact", "official announcement"
    - Return true if patterns found without uncertainty markers
    - _Requirements: 6.1, 6.2, 6.5_
  
  - [ ] 7.2 Implement response sanitization
    - Create `sanitizeResponse()` function to modify flagged responses
    - Add uncertainty language to responses with hallucination patterns
    - _Requirements: 6.2, 16.3_
  
  - [ ]* 7.3 Write property test for hallucination detection
    - **Property 5: Hallucination Pattern Sanitization**
    - **Validates: Requirements 6.2, 16.3**
    - Test that responses with hallucination patterns are sanitized
  
  - [ ]* 7.4 Write unit tests for hallucination detection
    - Test detection of various date/deadline patterns
    - Test that uncertainty markers prevent false positives
    - Test case-insensitive detection
    - _Requirements: 6.1, 6.2, 6.5_

- [ ] 8. Implement conversation history management
  - [ ] 8.1 Create conversation history session handlers
    - Implement `loadConversationHistory()` to retrieve messages from session
    - Implement `storeMessage()` to add messages to session
    - Implement `clearConversation()` to remove all messages
    - Store messages as array of ChatMessage objects with role, content, timestamp, language
    - _Requirements: 8.1, 8.5_
  
  - [ ] 8.2 Implement conversation history length limiting
    - Check conversation history length before adding new messages
    - Remove oldest messages when history exceeds 50 messages
    - _Requirements: 8.3, 8.4_
  
  - [ ]* 8.3 Write property test for conversation history length limit
    - **Property 8: Conversation History Length Limit**
    - **Validates: Requirements 8.3**
    - Test that history never exceeds 50 messages
  
  - [ ]* 8.4 Write property test for conversation history pruning
    - **Property 9: Conversation History Pruning**
    - **Validates: Requirements 8.4**
    - Test that oldest messages are removed when limit exceeded
  
  - [ ]* 8.5 Write property test for message role validity
    - **Property 10: Conversation History Role Validity**
    - **Validates: Requirements 8.3**
    - Test that all messages have role 'user' or 'assistant'
  
  - [ ]* 8.6 Write unit tests for conversation history management
    - Test session storage and retrieval
    - Test clearing conversation
    - Test session expiration handling
    - _Requirements: 8.1, 8.5, 8.6, 14.2_

- [ ] 9. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 10. Implement input validation
  - [ ] 10.1 Create request validation rules
    - Add validation for 'message' field: required, string, max 2000 characters
    - Add CSRF token validation for POST requests
    - _Requirements: 2.1, 2.2, 2.4_
  
  - [ ] 10.2 Implement validation error responses
    - Return 422 status code with clear error messages for validation failures
    - Return 419 status code for invalid CSRF tokens
    - _Requirements: 2.3, 2.5_
  
  - [ ]* 10.3 Write property test for message length validation
    - **Property 11: Message Length Validation**
    - **Validates: Requirements 2.1, 2.2**
    - Test that empty, null, and >2000 character messages are rejected
  
  - [ ]* 10.4 Write property test for validation error response format
    - **Property 12: Validation Error Response Format**
    - **Validates: Requirements 2.3**
    - Test that validation failures return 422 with error message
  
  - [ ]* 10.5 Write unit tests for input validation
    - Test various invalid inputs
    - Test CSRF token validation
    - Test error message clarity
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5_

- [ ] 11. Implement rate limiting
  - [ ] 11.1 Add rate limiting middleware
    - Implement rate limit of 10 messages per minute per user
    - Track by session ID for authenticated users
    - Track by IP address for unauthenticated users
    - _Requirements: 13.1, 13.4, 13.5_
  
  - [ ] 11.2 Implement rate limit error responses
    - Return 429 status code when rate limit exceeded
    - Provide clear error message with retry time
    - _Requirements: 13.2, 13.3_
  
  - [ ]* 11.3 Write unit tests for rate limiting
    - Test rate limit enforcement
    - Test rate limit reset after time window
    - Test different tracking methods (session vs IP)
    - _Requirements: 13.1, 13.2, 13.3, 13.4, 13.5_

- [ ] 12. Implement ChatbotController
  - [ ] 12.1 Create ChatbotController with sendMessage endpoint
    - Create controller class extending Laravel Controller
    - Inject AIClientService and PromptBuilderService dependencies
    - Implement `sendMessage()` method handling POST /api/chatbot/message
    - Validate incoming request
    - Load conversation history from session
    - Build system prompt using PromptBuilderService
    - Detect user message language
    - Call AI service with system prompt, user message, and conversation history
    - Validate AI response (check for empty content, hallucination patterns)
    - Store user message and AI response in conversation history
    - Return JSON response with AI reply and detected language
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5_
  
  - [ ] 12.2 Implement error handling and graceful degradation
    - Catch AI service exceptions and return user-friendly error messages
    - Implement retry logic for timeouts (retry once after 2 seconds)
    - Return fallback response directing to contact page if retry fails
    - Handle 429 rate limit errors from AI service
    - Handle empty or malformed AI responses
    - Log all errors with timestamp and request details
    - _Requirements: 9.1, 9.2, 9.3, 9.4, 9.5, 9.6_
  
  - [ ] 12.3 Implement getConversationHistory endpoint
    - Create method to retrieve conversation history from session
    - Return JSON array of messages
    - _Requirements: 8.1_
  
  - [ ] 12.4 Implement clearConversation endpoint
    - Create method to clear all messages from session
    - Return success response
    - _Requirements: 8.5_
  
  - [ ]* 12.5 Write integration tests for ChatbotController
    - Test complete message processing workflow
    - Test error handling scenarios
    - Test conversation history management
    - Mock AI service responses
    - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 9.1, 9.2, 9.3, 9.4, 9.5_

- [ ] 13. Implement response validation
  - [ ] 13.1 Create response validation functions
    - Validate response content is non-empty
    - Validate response content is valid UTF-8
    - Check for hallucination patterns and sanitize if needed
    - Validate response maintains university advisor character
    - _Requirements: 16.1, 16.2, 16.3, 16.5_
  
  - [ ] 13.2 Implement fallback response mechanism
    - Create generic fallback response for malformed AI responses
    - Log malformed responses for review
    - _Requirements: 16.4_
  
  - [ ]* 13.3 Write property test for response content validation
    - **Property 4: Response Content Non-Empty**
    - **Validates: Requirements 1.4, 16.1**
    - Test that all AI responses have non-empty content
  
  - [ ]* 13.4 Write unit tests for response validation
    - Test UTF-8 validation
    - Test fallback response generation
    - Test character validation
    - _Requirements: 16.1, 16.2, 16.4, 16.5_

- [ ] 14. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 15. Implement logging and monitoring
  - [ ] 15.1 Add error logging
    - Log errors with timestamp, error type, and request details
    - Log AI API call failures
    - _Requirements: 17.1_
  
  - [ ] 15.2 Add usage and performance logging
    - Log token usage for each AI API call
    - Log response times for performance monitoring
    - _Requirements: 17.2, 17.5_
  
  - [ ] 15.3 Add security event logging
    - Log detected jailbreak attempts
    - Log detected hallucination patterns
    - _Requirements: 17.3, 17.4_
  
  - [ ] 15.4 Implement log sanitization
    - Ensure sensitive information is not logged (API keys, passwords, PII)
    - _Requirements: 17.6, 14.5_
  
  - [ ]* 15.5 Write unit tests for logging
    - Test that errors are logged correctly
    - Test that sensitive data is not logged
    - Test log format and structure
    - _Requirements: 17.1, 17.2, 17.3, 17.4, 17.5, 17.6_

- [ ] 16. Implement security and data privacy measures
  - [ ] 16.1 Add input sanitization
    - Sanitize all user input before processing
    - Escape all output before displaying in frontend
    - _Requirements: 14.3, 14.4_
  
  - [ ] 16.2 Implement session security
    - Ensure conversation history is stored in session only (not database)
    - Clear conversation data on session expiration
    - _Requirements: 14.2, 14.6_
  
  - [ ] 16.3 Add API key security
    - Verify API keys are stored in environment configuration
    - Ensure API keys are never exposed to frontend
    - _Requirements: 14.1_
  
  - [ ]* 16.4 Write unit tests for security measures
    - Test input sanitization
    - Test output escaping
    - Test session data isolation
    - _Requirements: 14.1, 14.2, 14.3, 14.4, 14.5, 14.6_

- [ ] 17. Create API routes
  - [ ] 17.1 Define chatbot API routes
    - Add POST route `/api/chatbot/message` to ChatbotController@sendMessage
    - Add GET route `/api/chatbot/history` to ChatbotController@getConversationHistory
    - Add POST route `/api/chatbot/clear` to ChatbotController@clearConversation
    - Apply rate limiting middleware to all routes
    - Apply CSRF protection to POST routes
    - _Requirements: 1.1, 8.1, 8.5, 13.1, 2.4_
  
  - [ ]* 17.2 Write integration tests for API routes
    - Test route accessibility
    - Test middleware application
    - Test CSRF protection
    - _Requirements: 1.1, 2.4, 13.1_

- [ ] 18. Implement frontend chat widget
  - [ ] 18.1 Create ChatWidget JavaScript class
    - Create `ChatWidget` class with constructor accepting options
    - Implement `open()` and `close()` methods for widget visibility
    - Implement `sendMessage()` method to submit messages to backend
    - Implement `displayMessage()` method to render messages in UI
    - Implement `clearConversation()` method to clear chat history
    - _Requirements: 11.1, 11.5_
  
  - [ ] 18.2 Implement chat UI rendering
    - Render chat interface overlay on university website
    - Create message input field with Enter key and send button support
    - Display messages with sender identification (user vs assistant)
    - Add loading indicator for AI response wait time
    - _Requirements: 11.2, 11.6_
  
  - [ ] 18.3 Implement bilingual text rendering
    - Detect message language from backend response
    - Apply RTL formatting for Arabic messages
    - Apply LTR formatting for English messages
    - _Requirements: 11.4, 3.6, 3.7_
  
  - [ ] 18.4 Implement AJAX request handling
    - Make POST requests to `/api/chatbot/message` endpoint
    - Include CSRF token in request headers
    - Handle JSON responses from backend
    - Display AI responses in chat UI
    - _Requirements: 11.2, 11.3_
  
  - [ ] 18.5 Implement error handling in widget
    - Handle network errors gracefully
    - Display user-friendly error messages
    - Handle rate limit errors (429 status)
    - Handle validation errors (422 status)
    - _Requirements: 11.7_
  
  - [ ]* 18.6 Write property test for RTL formatting
    - **Property 13: RTL Formatting for Arabic**
    - **Validates: Requirements 3.6**
    - Test that Arabic messages have RTL formatting applied
  
  - [ ]* 18.7 Write property test for LTR formatting
    - **Property 14: LTR Formatting for English**
    - **Validates: Requirements 3.7**
    - Test that English messages have LTR formatting applied
  
  - [ ]* 18.8 Write unit tests for chat widget
    - Test message sending and receiving
    - Test UI rendering
    - Test error handling
    - Test conversation clearing
    - _Requirements: 11.1, 11.2, 11.3, 11.4, 11.5, 11.6, 11.7_

- [ ] 19. Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

- [ ] 20. Add widget styling and theming
  - [ ] 20.1 Create CSS styles for chat widget
    - Style chat overlay container
    - Style message bubbles (user vs assistant)
    - Style input field and send button
    - Style loading indicator
    - Add responsive design for mobile devices
    - _Requirements: 11.1_
  
  - [ ] 20.2 Implement NCTU theme
    - Apply university brand colors
    - Add university logo to widget header
    - Match website design language
    - _Requirements: 11.1_

- [ ] 21. Integrate widget into university website
  - [ ] 21.1 Add widget script to website layout
    - Include ChatWidget JavaScript file in main layout
    - Initialize widget with configuration options
    - Set API endpoint URL
    - Set widget position and theme
    - _Requirements: 11.1_
  
  - [ ] 21.2 Add widget toggle button
    - Create floating button to open/close chat widget
    - Position button in bottom-right corner
    - Add icon and hover effects
    - _Requirements: 11.1_

- [ ] 22. Configure AI provider settings
  - [ ] 22.1 Add environment configuration
    - Add AI provider selection to .env (CHATBOT_AI_PROVIDER=openai or gemini)
    - Add OpenAI API key to .env (OPENAI_API_KEY)
    - Add Gemini API key to .env (GEMINI_API_KEY)
    - Add max_tokens configuration (CHATBOT_MAX_TOKENS=500)
    - Add temperature configuration (CHATBOT_TEMPERATURE=0.7)
    - _Requirements: 10.6, 15.3, 15.4, 14.1_
  
  - [ ] 22.2 Implement configuration validation
    - Validate temperature is between 0.0 and 1.0
    - Validate max_tokens is positive integer
    - Validate API keys are present for selected provider
    - _Requirements: 15.5, 15.6_
  
  - [ ]* 22.3 Write unit tests for configuration
    - Test configuration loading
    - Test validation rules
    - Test default values
    - _Requirements: 15.1, 15.2, 15.3, 15.4, 15.5, 15.6_

- [ ] 23. Final integration and end-to-end testing
  - [ ]* 23.1 Write end-to-end tests for complete workflows
    - Test basic user query in English
    - Test Egyptian slang query in Arabic
    - Test marketing query
    - Test jailbreak attempt rejection
    - Test hallucination prevention for date queries
    - Test conversation history persistence
    - Test rate limiting
    - _Requirements: 1.1, 3.1, 3.2, 3.3, 5.3, 5.4, 6.4, 7.1, 7.2, 8.1, 13.1_
  
  - [ ]* 23.2 Write property test for navigation route validity
    - **Property 6: Navigation Route Validity**
    - **Validates: Requirements 4.3, 20.3**
    - Test that all navigation routes exist in Laravel routing table
  
  - [ ]* 23.3 Write property test for system prompt structure
    - **Property 15: System Prompt Contains Required Sections**
    - **Validates: Requirements 12.1, 12.2, 12.3, 12.4**
    - Test that system prompt contains role, navigation, marketing, and directives

- [ ] 24. Final checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.

## Notes

- Tasks marked with `*` are optional and can be skipped for faster MVP
- Each task references specific requirements for traceability
- Checkpoints ensure incremental validation at key milestones
- Property tests validate universal correctness properties from the design document
- Unit tests validate specific examples and edge cases
- The implementation uses Laravel (PHP) for backend and vanilla JavaScript for frontend
- AI provider abstraction allows switching between OpenAI and Gemini without code changes
- Conversation history is stored in session storage for privacy
- Rate limiting protects against abuse and excessive API costs
- Hallucination detection prevents AI from making false claims about dates and deadlines
- Jailbreak prevention ensures chatbot maintains its university advisor character

## Task Dependency Graph

```json
{
  "waves": [
    { "id": 0, "tasks": ["1.1"] },
    { "id": 1, "tasks": ["2.1", "2.2", "3.1", "3.2"] },
    { "id": 2, "tasks": ["2.3", "2.4", "3.3", "5.1"] },
    { "id": 3, "tasks": ["5.2", "5.3", "5.4", "6.1"] },
    { "id": 4, "tasks": ["6.2", "6.3", "6.4", "6.5", "7.1"] },
    { "id": 5, "tasks": ["7.2", "7.3", "7.4", "8.1"] },
    { "id": 6, "tasks": ["8.2", "8.3", "8.4", "8.5", "8.6", "10.1"] },
    { "id": 7, "tasks": ["10.2", "10.3", "10.4", "10.5", "11.1"] },
    { "id": 8, "tasks": ["11.2", "11.3", "12.1"] },
    { "id": 9, "tasks": ["12.2", "12.3", "12.4", "13.1"] },
    { "id": 10, "tasks": ["12.5", "13.2", "13.3", "13.4", "15.1", "15.2", "15.3", "15.4"] },
    { "id": 11, "tasks": ["15.5", "16.1", "16.2", "16.3"] },
    { "id": 12, "tasks": ["16.4", "17.1"] },
    { "id": 13, "tasks": ["17.2", "18.1"] },
    { "id": 14, "tasks": ["18.2", "18.3", "18.4", "18.5"] },
    { "id": 15, "tasks": ["18.6", "18.7", "18.8", "20.1"] },
    { "id": 16, "tasks": ["20.2", "21.1"] },
    { "id": 17, "tasks": ["21.2", "22.1"] },
    { "id": 18, "tasks": ["22.2", "22.3"] },
    { "id": 19, "tasks": ["23.1", "23.2", "23.3"] }
  ]
}
```
