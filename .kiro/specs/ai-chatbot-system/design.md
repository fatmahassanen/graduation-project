# Design Document: AI-Powered Chatbot System

## Overview

The AI-Powered Chatbot System is a Laravel-based conversational interface that provides 100% accurate, database-grounded responses to user queries about the university management system. The chatbot queries live database data via Eloquent models, formats it into structured context tokens, and injects this context into AI system prompts to eliminate hallucinations. The system supports multilingual input (Arabic, Franco-Arabic, English) with typo/slang tolerance, implements jailbreak prevention, and includes comprehensive adversarial testing to ensure reliability across diverse user personas.

## Architecture

```mermaid
graph TD
    A[User Input] --> B[ChatbotController]
    B --> C[Input Filter & Sanitizer]
    C --> D[Language Detector]
    D --> E[Database Context Builder]
    E --> F1[Eloquent: News]
    E --> F2[Eloquent: Events]
    E --> F3[Eloquent: Admissions]
    E --> F4[Eloquent: Departments]
    E --> F5[Eloquent: Faculty Members]
    E --> F6[Eloquent: Training]
    E --> F7[Eloquent: Activities]
    E --> F8[Eloquent: Other Models]
    F1 --> G[Context Token Formatter]
    F2 --> G
    F3 --> G
    F4 --> G
    F5 --> G
    F6 --> G
    F7 --> G
    F8 --> G
    G --> H[AI Service OpenAI/Gemini]
    H --> I[Response Validator]
    I --> J[Response Formatter]
    J --> K[JSON Response]
    K --> L[Frontend Display]
