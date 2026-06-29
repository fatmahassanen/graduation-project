<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BotResponse;

class ChatbotController extends Controller
{
    /**
     * Handle incoming chatbot messages with 7-tier intelligent routing architecture
     * Supports bilingual queries (Arabic/English) with 0% hallucination tolerance
     */
    public function sendMessage(Request $request)
    {
        $userMessage = trim($request->input('message'));

        // Empty message guard
        if (!$userMessage) {
            return response()->json(['error' => 'Message is empty'], 400);
        }

        // Normalize for pattern matching
        $normalizedMessage = strtolower($userMessage);
        $isArabic = preg_match('/\p{Arabic}/u', $userMessage);

        // ============================================================================
        // TIER 1: Foreign Language Blocker (Non-Arabic/Non-English Scripts)
        // ============================================================================
        if (preg_match('/[\x{0400}-\x{04FF}\x{4E00}-\x{9FFF}\x{0590}-\x{05FF}\x{3040}-\x{30FF}\x{AC00}-\x{D7AF}]/u', $userMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => 'Sorry, I currently support Arabic and English queries only. / عذراً، أنا أدعم الاستفسارات باللغتين العربية والإنجليزية فقط حالياً.'
            ]);
        }

        // ============================================================================
        // TIER 2: Percentage & Score Evaluation (%)
        // ============================================================================
        $scorePatterns = ['%', 'مجموعي', 'نسبة', 'درجات', 'جبت', 'جايب', 'حصلت', 'هقبل', 'هاقبل', 'أقبل', 'score', 'grade', 'percentage'];
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
                'reply' => '🎓 القبول النهائي يتحدد بناءً على تنسيق العام الدراسي الحالي والحدود الدنيا الرسمية التي تُعلنها الجامعة. لمتابعة آخر أخبار حدود القبول ونسب التنسيق، يرجى متابعة شؤون الطلاب. يمكنك إرسال طلب التحاق إلكتروني عبر رابط \'Apply Now\' في القائمة العلوية.'
            ]);
        }

        // ============================================================================
        // TIER 3: Intelligent Passion Matchmaking
        // ============================================================================
        $passionKeywords = ['بحب', 'أحب', 'احب', 'شغوف', 'ميول', 'ميولي', 'اهتمامي', 'مجال', 'ادخل', 'تخصص', 'اشتغل', 'عايز', 'love', 'like', 'passionate', 'interested', 'interest'];
        $hasPassionQuery = false;

        foreach ($passionKeywords as $pk) {
            if (str_contains($normalizedMessage, $pk)) {
                $hasPassionQuery = true;
                break;
            }
        }

        if ($hasPassionQuery) {
            if (preg_match('/(برمجة|برمجه|شبكات|اتصالات|داتا|سايبر|أمن معلومات|software|programming|cyber|ict|network|data)/u', $normalizedMessage)) {
                return response()->json(['status' => 'success', 'reply' => '💻 بما أنك مهتم بالبرمجة وتكنولوجيا المعلومات، القسم المثالي لك هو (ICT Department). يمكنك استعراض التفاصيل عبر الضغط على بطاقة القسم بصفحة \'Home Page\'.']);
            }
            if (preg_match('/(سيارات|سياره|ميكانيكا|أوتو|عربيات|هايبرد|كهربائية|cars|auto|mechanic|hybrid|ev)/u', $normalizedMessage)) {
                return response()->json(['status' => 'success', 'reply' => '🚗 القسم المثالي لك هو (Autotronics Department) المتخصص في السيارات الحديثة والهايبرد. استعرض التفاصيل بصفحة \'Home Page\'.']);
            }
            if (preg_match('/(روبوت|روبوتات|ميكا|تحكم|أتمتة|اتمته|plc|scada|robot|automation|control|smart)/u', $normalizedMessage)) {
                return response()->json(['status' => 'success', 'reply' => '🤖 القسم المثالي لك هو (Mechatronics Department) للروبوتات والأنظمة الذكية. استعرض التفاصيل بصفحة \'Home Page\'.']);
            }
            if (preg_match('/(طاقة|شمسية|متجددة|نظيفة|رياح|solar|wind|renewable|clean|energy)/u', $normalizedMessage)) {
                return response()->json(['status' => 'success', 'reply' => '☀️ القسم المثالي لك هو (Renewable Energy Department). استعرض التفاصيل بصفحة \'Home Page\'.']);
            }
            if (preg_match('/(طبي|طبية|أطراف|صناعية|تعويضية|بيونيك|prosthetic|medical|bionic|rehabilitation)/u', $normalizedMessage)) {
                return response()->json(['status' => 'success', 'reply' => '🦾 القسم المثالي لك هو (Prosthetics & Orthotics Department) للأجهزة التعويضية. استعرض التفاصيل بصفحة \'Home Page\'.']);
            }
            if (preg_match('/(بترول|نفط|غاز|حفر|petroleum|oil|gas|drill)/u', $normalizedMessage)) {
                return response()->json(['status' => 'success', 'reply' => '🛢️ القسم المثالي لك هو (Petroleum Production Technology Department). استعرض التفاصيل بصفحة \'Home Page\'.']);
            }
        }

        // ============================================================================
        // TIER 3.5: Dynamic Knowledge Routing
        // ============================================================================
        $knowledgeMap = [
            'ICT' => ['شبكات', 'برمجة', 'it', 'ict', 'سايبر', 'داتا'],
            'Autotronics' => ['سيارات', 'اوتوترونكس', 'ميكانيكا سيارات'],
            'Mechatronics' => ['روبوت', 'ميكاترونكس', 'تحكم آلي'],
            'Renewable Energy' => ['طاقة شمسية', 'طاقة رياح', 'طاقة متجددة', 'سولار'],
            'Petroleum' => ['بترول', 'حفر', 'نفط'],
            'Prosthetics' => ['اطراف صناعية', 'أجهزة تعويضية']
        ];

        foreach ($knowledgeMap as $dept => $keywords) {
            foreach ($keywords as $word) {
                if (str_contains($normalizedMessage, $word)) {
                    return response()->json(['status' => 'success', 'reply' => "نعم، تخصص $dept متاح عندنا في الكلية! يمكنك الاطلاع على تفاصيله والمنهج الخاص به في صفحة الـ Departments على البورتال."]);
                }
            }
        }

        // ============================================================================
        // TIER 4: Exact Departments & Non-Existent Faculty Guard (قواعد المعيد الصارمة)
        // ============================================================================
        if (preg_match('/^( اي هي الكليات|الاقسام|الأقسام|ايه هي الاقسام|أقسام الكلية|اقسام الكليه|departments|programs|majors)$/u', $normalizedMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => "🏛️ جامعة القاهرة الجديدة التكنولوجية (NCTU) تتكون من كليتين رئيسيتين:\n\n1️⃣ كلية تكنولوجيا الصناعة والطاقة (Faculty of Industry and Energy Technology)\n   - قسم ICT\n   - قسم Mechatronics\n   - قسم Autotronics\n   - قسم Renewable Energy\n   - قسم Petroleum Production\n\n2️⃣ كلية تكنولوجيا العلوم الصحية (Faculty of Health Sciences Technology)\n   - قسم Prosthetics & Orthotics\n\nيمكنك استعراض تفاصيل كل قسم عبر صفحة 'Home Page' ثم الضغط على بطاقة القسم الذي يهمك."
            ]);
        }

        $allowedKeywords = ['ict', 'it', 'mechatronics', 'autotronics', 'energy', 'petroleum', 'prosthetics', 'orthotics', 'صناعة وطاقة', 'علوم صحية', 'طاقة', 'بترول', 'ميكاترونكس', 'اوتوترونكس', 'أطراف صناعية', 'حاسبات'];
        $isAskingAboutDepartmentOrFaculty = preg_match('/(قسم|كلية|كليه|تخصص|department|faculty)/ui', $normalizedMessage);
        $hasValidKeyword = preg_match('/(' . implode('|', $allowedKeywords) . ')/ui', $normalizedMessage);

        if (preg_match('/(برمجة|برمجه|coding|software|programming)/u', $normalizedMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => "💻 نعم، البرمجة موجودة! يمكنك دراسة البرمجة وتطوير البرمجيات ضمن قسم تكنولوجيا المعلومات والاتصالات (ICT Department) بكلية تكنولوجيا الصناعة والطاقة.\n\n💡 يمكنك استعراض المنهج الدراسي الكامل عبر صفحة 'Departments' أو بالضغط على بطاقة قسم ICT في الـ Home Page."
            ]);
        }
        if ($isAskingAboutDepartmentOrFaculty && !$hasValidKeyword) {
            if ($isArabic) {
                return response()->json([
                    'status' => 'success',
                    'reply' => "❌ عذراً، هذا غير متاح في جامعة القاهرة الجديدة التكنولوجية (NCTU).\n\nنحن نهتم بتقديم تعليم تكنولوجي متخصص، والجامعة تضم كليتين فقط:\n\n1️⃣ كلية تكنولوجيا الصناعة والطاقة (وتشمل: ICT، الميكاترونكس، الأوتوترونكس، الطاقة المتجددة، وبترول).\n2️⃣ كلية تكنولوجيا العلوم الصحية (وتشمل: الأطراف الصناعية والأجهزة التعويضية).\n\n💡 إذا كنت تبحث عن تفاصيل أكثر حول تخصصاتنا المتاحة، يمكنك زيارة صفحة يمكنك الانتقال لصفحات الكليات الرسمية لدينا:🔗 كلية تكنولوجيا الصناعة والطاقة (Faculty of Industrial and Energy Technology)🔗 كلية العلوم الصحية (Faculty of Health Sciences Technology).."
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'reply' => "❌ Sorry, this department or major is not available at NCTU.\n\nOur university focuses on specialized technological education across two main faculties:\n\n1️⃣ Faculty of Industry and Energy Technology (ICT, Mechatronics, Autotronics, Renewable Energy, Petroleum).\n2️⃣ Faculty of Health Sciences Technology (Prosthetics & Orthotics).\n\n💡 For more details about our programs, please visit the 'Departments' page or explore our faculties from the Home Page."
                ]);
            }
        }
        if (preg_match('/(ايه ي الجامعه|إيه هي الجامعة|ماهي الجامعة|عن الجامعة|what is the university|about nctu|what is nctu)/u', $normalizedMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => '🏛️ جامعة القاهرة الجديدة التكنولوجية (NCTU) هي جامعة حكومية مصرية تهدف لتقديم تعليم تطبيقي متميز يربط الدراسة النظرية باحتياجات سوق العمل والمصانع مباشرة. تركز الدراسة بنسبة 60% على التدريب العملي في المعامل والورش والمواقع الإنتاجية و40% على الجانب النظري، وتمنح شهادة البكالوريوس التكنولوجي المعتمد في تخصصات هندسية وصحية متطورة.'
            ]);
        }

        // ============================================================================
        // TIER 5: Comprehensive University & Custom QA Overrides
        // ============================================================================
        if (preg_match('/(ايه ي الجامعه |اي هي الجامعه|اي هي الجامعة|إيه هي الجامعة|ماهي الجامعة|عن الجامعة|what is the university)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => '🏛️ جامعة القاهرة الجديدة التكنولوجية (NCTU) هي جامعة حكومية تهدف لتقديم تعليم تطبيقي يربط الدراسة باحتياجات سوق العمل. تركز الدراسة بنسبة 60% عملي و40% نظري، وتمنح شهادة البكالوريوس التكنولوجي المعتمد.']);
        }

        if (preg_match('/(نظام التقييم|بيرسون|pearson|الامتحانات|الدرجات)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => '📝 نظام التقييم يعتمد على مؤسسة "بيرسون" (Pearson) البريطانية. لا يعتمد على الحفظ التقليدي بل يرتكز على الـ Assignments طوال الترم لقياس المهارات، والتقديرات مقسمة لمستويات (Pass / Merit / Distinction).']);
        }

        if (preg_match('/(امتحان قدرات|اختبار قدرات|تنسيق|مجموع|aptitude test)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => '📊 لا يوجد امتحان قدرات خاص بالكلية. القبول والمجموع يتم فقط بناءً على نتيجة التنسيق الرسمي المعلن من وزارة التعليم العالي.']);
        }

        if (preg_match('/(مصاريف|المصاريف|fees|tuition)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => "💰 المصاريف الدراسية للجامعة:\n- السنة الأولى والثانية: 15,000 جنيه.\n- السنة الثالثة والرابعة: 20,000 جنيه."]);
        }

        if (preg_match('/(منح|منحة|تكافل|scholarship)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => '🤖 عذراً، لا أمتلك معلومات دقيقة حالياً بخصوص المنح الدراسية. يرجى مراجعة إدارة شؤون الطلاب بالجامعة.']);
        }

        if (preg_match('/(لاب توب|كمبيوتر|laptop|pc)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => '💻 الجامعة لا توفر جهاز لاب توب شخصي لكل طالب، ولكنها توفر معامل حاسب آلي مجهزة بالكامل للاستخدام.']);
        }

        if (preg_match('/(سكن|مدينة جامعية|dorm|housing)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => '❌ الجامعة لا توفر سكناً أو مدينة جامعية للطلاب المغتربين.']);
        }

        if (preg_match('/(ورق|أوراق|مستندات|documents|faculties-requirements)/u', $normalizedMessage)) {
            return response()->json(['status' => 'success', 'reply' => '📄 لمعرفة كافة الأوراق والمستندات المطلوبة للتقديم، يرجى زيارة صفحة "faculties-requirements" في القائمة الرئيسية.']);
        }

        // ============================================================================
        // TIER: Branches & NCTU Differentiation (التميز وفروع الجامعة)
        // ============================================================================
        if (preg_match('/( مميزات|فروع|فروع الجامعة|مميزات فرع|تتميزوا بايه|ليه اخترتوا التجمع|branches|why nctu special|differentiation)/u', $normalizedMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => "📍 جامعة القاهرة الجديدة التكنولوجية (NCTU) تتميز بموقعها الاستراتيجي في قلب التجمع الخامس (منطقة اللوتس)، وهو ما يضعنا في قلب المنطقة الصناعية والخدمية الأكثر تطوراً في مصر، مما يسهل على طلابنا التدريب الميداني والشراكة مع كبرى الشركات.\n\n🌟 ما يميز جامعتنا:\n1️⃣ **التخصص التكنولوجي الدقيق:** نركز على تخصصات مطلوبة بشدة في سوق العمل (مثل ICT والبترول والأطراف الصناعية) بتجهيزات معامل عالمية.\n2️⃣ **شراكة بيرسون (Pearson):** نظام تعليمي وتقييمي يحاكي المعايير البريطانية، مما يعطي خريجنا أولوية في التوظيف.\n3️⃣ **الربط بالمنطقة الصناعية:** موقعنا في التجمع الخامس جعلنا الأقرب للمصانع والشركات الكبرى، مما يوفر لطلابنا فرص تدريبية (Internships) تفوق غيرنا.\n4️⃣ **مجتمع الابتكار:** دعمنا للأنشطة الطلابية التقنية مثل مجتمعات Google (GDG) والمسابقات الدولية يجعل الطالب خريجاً ذا شخصية قيادية وليس مجرد حاصل على شهادة."
            ]);
        }

        // ============================================================================
        // TIER: University Branches (هل للجامعة فروع؟)
        // ============================================================================
        if (preg_match('/(ليها فروع|فروع الجامعه|هل للجامعة فروع|فروع تانية|other branches|do you have branches)/u', $normalizedMessage)) {
            return response()->json([
                'status' => 'success',
                'reply' => "📍 جامعة القاهرة الجديدة التكنولوجية (NCTU) لها مقر رئيسي واحد ووحيد في القاهرة الجديدة، التجمع الخامس (منطقة اللوتس الجنوبية).\n\nنحن لا نملك فروعاً أخرى في محافظات أخرى حالياً؛ حيث أن مقرنا الرئيسي مجهز بالكامل بأحدث المعامل والورش التكنولوجية المتخصصة التي تخدم أقسامنا الفريدة. تجميعنا في مقر واحد يضمن توحيد جودة التعليم والتدريب العملي لجميع طلابنا."
            ]);
        }

        // ============================================================================
        // TIER 6: Dynamic Database Pattern Matching (BotResponse Model)
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
                ? '🤖 عذراً، استفسارك خارج نطاق المعلومات المتاحة. يمكنك زيارة شؤون الطلاب بمقر الجامعة للحصول على معلومات تفصيلية.'
                : '🤖 Sorry, your request is outside my current knowledge base. Please visit Student Affairs on campus.'
        ]);
    }
}
