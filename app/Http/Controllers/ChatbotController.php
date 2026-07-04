<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BotResponse;

class ChatbotController extends Controller
{
    public function sendMessage(Request $request)
    {
        $userMessage = trim($request->input('message'));

        if (!$userMessage) {
            return response()->json(['error' => 'Message is empty'], 400);
        }

        $normalizedMessage = mb_strtolower($userMessage);
        $isArabic = preg_match('/\p{Arabic}/u', $userMessage);

        // ============================================================================
        // TIER 1: Foreign Language Blocker
        // ============================================================================
        if (preg_match('/[\x{0400}-\x{04FF}\x{4E00}-\x{9FFF}\x{0590}-\x{05FF}\x{3040}-\x{30FF}\x{AC00}-\x{D7AF}]/u', $userMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => 'Sorry, I currently support Arabic and English queries only. / عذراً، أنا أدعم الاستفسارات باللغتين العربية والإنجليزية فقط حالياً.'
            ]);
        }

        // ============================================================================
        // TIER 2: Percentage & Score Evaluation
        // ============================================================================
        $scorePatterns = ['%', 'مجموعي', 'مجموعى', 'نسبة', 'نسبه', 'درجات', 'الدرجات', 'جبت', 'جايب', 'جايبه', 'حصلت', 'هقبل', 'هاقبل', 'أقبل', 'في الميه', 'في المائة', 'بالميه', 'score', 'grade', 'percentage'];
        $hasScoreQuery = false;
        $hasNumericValue = preg_match('/\d+/', $normalizedMessage);

        foreach ($scorePatterns as $pattern) {
            if (str_contains($normalizedMessage, $pattern)) {
                $hasScoreQuery = true;
                break;
            }
        }

        if ($hasScoreQuery && $hasNumericValue) {
            return response()->json([
                'status' => 'success',
                'reply' => "🎓 القبول النهائي يتحدد بناءً على تنسيق العام الدراسي الحالي والحدود الدنيا الرسمية التي تُعلنها الجامعة.\n\nلمتابعة آخر أخبار حدود القبول ونسب التنسيق، يرجى متابعة شؤون الطلاب. يمكنك إرسال طلب التحاق إلكتروني عبر رابط 'Apply Now' في القائمة العلوية."
            ]);
        }

        // ============================================================================
        // TIER 3: Intelligent Department, Faculty Definitions & Interests
        // ============================================================================

        // 1. منطق الكليات (Faculties)
        if (preg_match('/(كلية|كليه|كليات|الكلية|الكليه|الكليات|faculty|faculties)/u', $normalizedMessage)) {

            if (preg_match('/(علوم صحية|علوم صحيه|صحي|صحية|صحيه|health|علوم طبية|علوم طبيه)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => "🏥 **كلية تكنولوجيا العلوم الصحية:**\nمتخصصة في الأجهزة الطبية، وتضم قسماً واحداً:\n- قسم الأطراف الصناعية والأجهزة التعويضية (Prosthetics & Orthotics).\n\n💡 لمزيد من المعلومات، يرجى زيارة صفحة 'Faculty of Health Sciences Technology' من القائمة."
                ]);
            }

            if (preg_match('/(صناعة|صناعه|طاقة|طاقه|تكنولوجيا|industrial|energy)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => "🏭 **كلية تكنولوجيا الصناعة والطاقة:**\nتضم 5 أقسام تكنولوجية:\n- تكنولوجيا المعلومات والاتصالات (ICT)\n- الميكاترونكس (Mechatronics)\n- الأوتوترونكس (Autotronics)\n- الطاقة المتجددة (Renewable Energy)\n- تكنولوجيا إنتاج البترول (Petroleum Production)\n\n💡 لمزيد من المعلومات، يرجى زيارة صفحة 'Faculty of Industrial and Energy Technology' من القائمة."
                ]);
            }

            if (preg_match('/(متاحه|متاحة|اي|ايه|اى|عباره|عبارة|موجوده|موجودة|what|available)/u', $normalizedMessage) && !preg_match('/(طب|هندسة|هندسه|تجارة|تجاره|حقوق|صيدلة|صيدله|اسنان|أسنان|حاسبات|علاج طبيعي)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => "🏛️ جامعة القاهرة الجديدة التكنولوجية (NCTU) تتكون من كليتين رئيسيتين:\n\n1️⃣ **كلية تكنولوجيا الصناعة والطاقة:**\n(تضم 5 أقسام: ICT، الميكاترونكس، الأوتوترونكس، الطاقة المتجددة، والبترول).\n\n2️⃣ **كلية تكنولوجيا العلوم الصحية:**\n(تضم قسماً واحداً: الأطراف الصناعية والأجهزة التعويضية).\n\n💡 يمكنك السؤال عن كلية محددة لمعرفة تفاصيل أقسامها."
                ]);
            }

            return response()->json([
                'status' => 'success',
                'reply' => "عذراً، هذه الكلية غير متاحة بالجامعة. ❌\n\nالجامعة تضم كليتين رئيسيتين فقط:\n1️⃣ كلية تكنولوجيا الصناعة والطاقة.\n2️⃣ كلية تكنولوجيا العلوم الصحية.\n\n💡 لمزيد من المعلومات حول الكليات والأقسام المتاحة، يرجى زيارة صفحة 'Faculties' في القائمة."
            ]);
        }

        // 2. منطق الأقسام (Departments) - فصل نية السؤال (اسم القسم vs الاهتمام)
        $deptNamesKeywords = [
            'ict' => ['ict', 'اي سي تي', 'أى سى تى', 'تكنولوجيا المعلومات'],
            'mechatronics' => ['mechatronic', 'ميكاترون', 'ميكا ترون'],
            'autotronics' => ['autotronic', 'اوتوترون', 'أوتوترون', 'اتوترون', 'أتوترون', 'اوتو ترون'],
            'renewable energy' => ['renewable', 'متجدد'],
            'petroleum' => ['petroleum', 'بترول'],
            'prosthetics' => ['prosthetic', 'اطراف', 'أطراف', 'تعويض']
        ];

        $deptInterestsKeywords = [
            'ict' => ['حاسب', 'برمج', 'معلومات', 'شبكات', 'كمبيوتر', 'سوفت', 'software', 'programming'],
            'mechatronics' => ['روبوت', 'ذكاء', 'robot', 'ai'],
            'autotronics' => ['سيارات', 'سياره', 'عربيات', 'عربيه', 'cars'],
            'renewable energy' => ['شمس', 'رياح', 'نظيف', 'solar'],
            'petroleum' => ['تعدين', 'غاز', 'حفر', 'oil', 'gas'],
            'prosthetics' => ['طبي', 'طبيه', 'مستشف', 'medical']
        ];

        $matchedDeptKey = null;
        $matchType = null;

        foreach ($deptNamesKeywords as $key => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($normalizedMessage, $keyword)) {
                    $matchedDeptKey = $key;
                    $matchType = 'name';
                    break 2;
                }
            }
        }

        if (!$matchedDeptKey) {
            foreach ($deptInterestsKeywords as $key => $keywords) {
                foreach ($keywords as $keyword) {
                    if (str_contains($normalizedMessage, $keyword)) {
                        $matchedDeptKey = $key;
                        $matchType = 'interest';
                        break 2;
                    }
                }
            }
        }

        $hasDeptWord = preg_match('/(قسم|أقسم|اقسام|الاقسام|الأقسام|تخصص|تخصصات|التخصصات|مجال|مجالات|بحب|ادرس|أدرس|اتعلم|أتعلم|ادخل|أدخل|مهتم|department|departments|major|majors)/u', $normalizedMessage);

        if ($hasDeptWord || $matchedDeptKey) {

            $deptStandardInfo = [
                'ict' => "💻 **قسم تكنولوجيا المعلومات (ICT):**\nهو تخصص يركز على دراسة علوم الحاسب، البرمجة، هندسة البرمجيات، تصميم وتحليل النظم الرقمية، وإدارة الشبكات السلكية واللاسلكية.",
                'mechatronics' => "🤖 **قسم الميكاترونكس (Mechatronics):**\nهو تخصص دقيق يجمع بين الهندسة الميكانيكية والكهربائية والإلكترونيات، ويركز على تصميم وتشغيل أنظمة التحكم الآلي، الروبوتات، والذكاء الاصطناعي.",
                'autotronics' => "🚗 **قسم الأوتوترونكس (Autotronics):**\nيهتم بدراسة ميكانيكا السيارات الحديثة، تكنولوجيا السيارات الكهربائية والهجينة، وأنظمة التحكم الإلكتروني بها وتشخيص الأعطال بالكمبيوتر.",
                'renewable energy' => "☀️ **قسم الطاقة المتجددة (Renewable Energy):**\nيركز على دراسة وتوليد الطاقة النظيفة والمستدامة، مثل تكنولوجيا الطاقة الشمسية وطاقة الرياح، وتصميم وصيانة محطات الطاقة.",
                'petroleum' => "🛢️ **قسم تكنولوجيا إنتاج البترول (Petroleum):**\nيختص بمجالات التعدين، تكنولوجيا استكشاف وحفر آبار البترول والغاز، بالإضافة إلى عمليات النقل والمعالجة في محطات التكرير.",
                'prosthetics' => "🦿 **قسم الأطراف الصناعية والأجهزة التعويضية (Prosthetics & Orthotics):**\nيركز على دمج التكنولوجيا الهندسية بالمجال الطبي، لتصميم وتصنيع وصيانة الأطراف الصناعية والأجهزة التعويضية لمساعدة المرضى."
            ];

            $deptInterestInfo = [
                'ict' => "✅ **نعم، القسم ده متاح!**\n\n💻 **قسم تكنولوجيا المعلومات (ICT) هو الأنسب لاهتمامك:**\nلأنه بيدرس كل ما يخص البرمجة، الكمبيوتر، الشبكات، وتطوير السوفت وير.",
                'mechatronics' => "✅ **نعم، القسم ده متاح!**\n\n🤖 **قسم الميكاترونكس (Mechatronics) هو الأنسب لاهتمامك:**\nلأنه بيعلمك إزاي تبني وتبرمج الروبوتات، وتشتغل في مجال الذكاء الاصطناعي والتحكم الآلي.",
                'autotronics' => "✅ **نعم، القسم ده متاح!**\n\n🚗 **قسم الأوتوترونكس (Autotronics) هو الأنسب لاهتمامك:**\nلأنه متخصص بالكامل في ميكانيكا وعالم السيارات، تكنولوجيا السيارات الحديثة والكهربائية، وأنظمة التحكم الخاصة بيها.",
                'renewable energy' => "✅ **نعم، القسم ده متاح!**\n\n☀️ **قسم الطاقة المتجددة (Renewable Energy) هو الأنسب لاهتمامك:**\nلأنه بيهتم بتوليد الطاقة النظيفة زي الطاقة الشمسية وطاقة الرياح والحلول البديلة.",
                'petroleum' => "✅ **نعم، القسم ده متاح!**\n\n🛢️ **قسم تكنولوجيا إنتاج البترول هو الأنسب لاهتمامك:**\nلأنه بيختص بمجال التعدين، الغاز، وعمليات حفر آبار البترول.",
                'prosthetics' => "✅ **نعم، القسم ده متاح!**\n\n🦿 **قسم الأطراف الصناعية والأجهزة التعويضية هو الأنسب لاهتمامك:**\nلأنه بيربط بين الهندسة والمجال الطبي، وهتتعلم فيه تصميم وتصنيع الأجهزة الطبية والأطراف لمساعدة المرضى."
            ];

            if ($matchedDeptKey) {
                $finalReply = ($matchType === 'interest') ? $deptInterestInfo[$matchedDeptKey] : $deptStandardInfo[$matchedDeptKey];
                return response()->json([
                    'status' => 'success',
                    'reply' => $finalReply . "\n\n💡 لمعلومات أكثر وتفاصيل دقيقة، يرجى زيارة صفحة 'Departments' في الـ Home Page."
                ]);
            }

            if (preg_match('/(متاحه|متاحة|اي|ايه|اى|ما هي|كم|موجوده|موجودة|شغاله|available|what|عباره|عبارة)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => "🏛️ تضم الجامعة 6 أقسام رئيسية:\n1️⃣ ICT (تكنولوجيا المعلومات)\n2️⃣ Mechatronics (الميكاترونكس والروبوتات)\n3️⃣ Autotronics (السيارات)\n4️⃣ Renewable Energy (الطاقة المتجددة)\n5️⃣ Petroleum (البترول)\n6️⃣ Prosthetics & Orthotics (الأطراف الصناعية)\n\n💡 يمكنك استعراض تفاصيل كل قسم عبر صفحة 'Departments' في الـ Home Page."
                ]);
            }

            return response()->json([
                'status' => 'success',
                'reply' => "عذراً، هذا القسم أو التخصص غير متاح بالجامعة. ❌\n\nالجامعة تركز على 6 تخصصات تكنولوجية فقط وهي:\n1️⃣ ICT\n2️⃣ Mechatronics\n3️⃣ Autotronics\n4️⃣ Renewable Energy\n5️⃣ Petroleum\n6️⃣ Prosthetics & Orthotics"
            ]);
        }

        // ============================================================================
        // TIER 4: Custom QA Overrides & FAQs
        // ============================================================================

        if (preg_match('/(ايه ي الجامعه|إيه هي الجامعة|اي هي الجامعه|الجامعه عباره عن اي|ماهي الجامعة|معلومات عن|نظام الجامعه|نظام الكليه|what is nct|what is nctu|about nctu)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "🏛️ **جامعة القاهرة الجديدة التكنولوجية (NCTU):**\nهي جامعة حكومية مصرية تهدف لتقديم تعليم تطبيقي متميز يربط الدراسة النظرية باحتياجات سوق العمل والمصانع مباشرة.\n\nتركز الدراسة بنسبة 60% على التدريب العملي و40% على النظري، وتمنح شهادة البكالوريوس التكنولوجي المعتمد."]);
        }

        if (preg_match('/(نظام التقييم|بيرسون|pearson|الامتحانات|الدرجات|امتحانات|تقييم|بننجح ازاي|بتتحسب ازاي|نظام الدراسه|نظام الدراسة|شرح نظام)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "📝 **نظام التقييم (نظام بيرسون Pearson البريطاني):**\nالتقييم عندنا لا يعتمد على الحفظ والتلقين في الامتحانات النهائية فقط! بل يرتكز بشكل أساسي على التكليفات (Assignments) والمشاريع العملية طوال الترم لقياس مهاراتك الحقيقية.\n\nالتقديرات مقسمة لـ 3 مستويات:\n- Pass (نجاح)\n- Merit (جدارة)\n- Distinction (امتياز)"]);
        }

        if (preg_match('/(امتحان قدرات|اختبار قدرات|تنسيق|الحد الادنى|بتاخد من كام|aptitude test)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "📊 لا يوجد امتحان قدرات خاص بالجامعة.\nالقبول يتم بناءً على نتيجة التنسيق الرسمي المعلن من وزارة التعليم العالي."]);
        }

        if (preg_match('/(مصاريف|المصاريف|مصروفات|فلوس|تكلفة|تكلفه|كام في السنه|بدفع كام|fees|tuition)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "💰 **المصاريف الدراسية للجامعة:**\n(تقريبياً وبحسب آخر التحديثات):\n- السنة الأولى والثانية: 15,000 جنيه.\n- السنة الثالثة والرابعة: 20,000 جنيه."]);
        }

        if (preg_match('/(منح|منحة|تكافل|منحه|مجانية|مجانيه|scholarship)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "🤖 يرجى مراجعة إدارة شؤون الطلاب (إدارة الرعاية والتكافل) بالجامعة لمعرفة التفاصيل الدقيقة حول التخفيضات أو المنح المتاحة."]);
        }

        if (preg_match('/(لاب توب|كمبيوتر|لابتوب|حاسب|laptop|pc)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "💻 الجامعة لا توفر جهاز لاب توب شخصي لكل طالب، ولكنها توفر معامل حاسب آلي مجهزة بالكامل للاستخدام العملي."]);
        }

        if (preg_match('/(سكن|مدينة جامعية|مدينه جامعيه|مغتربين|اقعد فين|مبيت|dorm|housing)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "❌ الجامعة لا توفر سكناً أو مدينة جامعية للطلاب المغتربين حالياً."]);
        }

        if (preg_match('/(ورق|أوراق|الورق|مستندات|المطلوب للتقديم|اجيب ورق ايه|الورق المطلوب|documents|requirements|faculties-requirements)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "📄 لمعرفة كافة الأوراق والمستندات المطلوبة للتقديم، يرجى زيارة صفحة 'Faculties-requirements' في القائمة الرئيسية."]);
        }

        // ============================================================================
        // TIER 5: Branches, Location & NCTU Differentiation
        // ============================================================================
        if (preg_match('/(مميزات|تتميزوا بايه|ليه اخترتوا التجمع|why nctu special|differentiation)/u', $normalizedMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => "🌟 **ما يميز جامعتنا (NCTU):**\n1️⃣ التخصص التكنولوجي الدقيق المطلوب في سوق العمل.\n2️⃣ الاعتماد على الجانب العملي بنسبة 60%.\n3️⃣ شراكة التقييم مع بيرسون (Pearson) البريطانية.\n4️⃣ الموقع الاستراتيجي بالقرب من المناطق الصناعية."
            ]);
        }

        if (preg_match('/(فروع|فرع|فروعها|فروع تانية|مكانها|فين بالظبط|مقر الجامعه|عنوان|مكان|موقعها|branches|location)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "📍 **جامعة القاهرة الجديدة التكنولوجية (NCTU):**\nلها مقر رئيسي واحد ووحيد يقع في: القاهرة الجديدة، التجمع الخامس (منطقة اللوتس الجنوبية)."]);
        }

        // ============================================================================
        // TIER 6: Dynamic Database Pattern Matching
        // ============================================================================
        $matchedResponse = BotResponse::whereRaw('? LIKE CONCAT("%", keyword, "%")', [$normalizedMessage])->first();

        if ($matchedResponse) {
            return response()->json(['status' => 'success', 'reply' => $matchedResponse->reply]);
        }

        // ============================================================================
        // TIER 7: Human-Style Logical Fallback
        // ============================================================================
        return response()->json([
            'status' => 'success',
            'reply' => $isArabic
                ? "🤖 عذراً، لم أتمكن من فهم سؤالك بشكل كامل أو أن استفسارك خارج نطاق المعلومات المتاحة لدي.\n\nيمكنك زيارة شؤون الطلاب بمقر الجامعة للحصول على معلومات تفصيلية."
                : "🤖 Sorry, I didn't fully understand your question or your request is outside my current knowledge base.\n\nPlease visit Student Affairs on campus."
        ]);
    }
}
