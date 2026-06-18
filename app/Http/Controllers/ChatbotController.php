<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BotResponse;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userMessage = strtolower(trim($request->input('message')));

        if (!$userMessage) {
            return response()->json(['error' => 'Message is empty'], 400);
        }

        // Tier 1: Foreign Language Blocker Check
        if (preg_match('/[\x{0400}-\x{04FF}\x{4E00}-\x{9FFF}\x{0590}-\x{05FF}]/u', $userMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => 'Sorry, I currently support Arabic and English queries only. / عذراً، أنا أدعم استفسارات البورتال باللغتين العربية والإنجليزية فقط حالياً.'
            ]);
        }

        // Tier 2: Search for an exact local database keyword match
        $matchedResponse = BotResponse::whereRaw('? LIKE CONCAT("%", keyword, "%")', [$userMessage])
            ->first();

        if ($matchedResponse) {
            return response()->json([
                'status' => 'success',
                'reply' => $matchedResponse->reply
            ]);
        }

        // Tier 3: If NO exact database match is found, apply smart Fallback routing
        // Context A: If the query is related to admissions, enrollment, or papers in any way shape or form
        $admissionContextKeywords = ['ورق', 'مستندات', 'التحاق', 'تسجيل', 'تقديم', 'اسجل', 'قدم', 'ملفات', 'شروط', 'admission', 'apply', 'documents', 'required', 'register'];
        foreach ($admissionContextKeywords as $kw) {
            if (str_contains($userMessage, $kw)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => 'يرجى مراجعة شؤون الطلاب بمقر الجامعة لمزيد من التفاصيل والملفات الرسمية. مواعيد العمل الرسمية لمكتب الشؤون: من الأحد إلى الخميس، من الساعة 10:00 صباحاً وحتى الساعة 2:00 ظهراً.'
                ]);
            }
        }

        // Context B: Absolutely anything else completely out of university scope
        return response()->json([
            'status' => 'success',
            'reply' => 'عذراً، أنا مساعد رقمي مخصص للاستفسارات الأكاديمية فقط.'
        ]);
    }
}
