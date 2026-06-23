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

        // Normalize for pattern matching (preserve original for display)
        $normalizedMessage = strtolower($userMessage);

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
                'reply' => '🎓 القبول النهائي يتحدد بناءً على تنسيق العام الدراسي الحالي والحدود الدنيا الرسمية التي تُعلنها الجامعة. لمتابعة آخر أخبار حدود القبول ونسب التنسيق فور صدورها، يرجى متابعة الحسابات الرسمية للجامعة على منصات السوشيال ميديا، أو يمكنك زيارة مكتب شؤون الطلاب بالجامعة مباشرة. كما يمكنك إرسال طلب التحاق إلكتروني عبر رابط \'Apply Now\' الموجود في القائمة العلوية للبورتال ومتابعة حالة طلبك من هناك.'
            ]);
        }

        // ============================================================================
        // TIER 3: Intelligent Passion Matchmaking & Concise Department Routing
        // ============================================================================
        $passionKeywords = ['بحب', 'أحب', 'احب', 'شغوف', 'ميول', 'ميولي', 'اهتمامي', 'مجال', 'ادخل', 'تخصص', 'اشتغل', 'عايز', 'love', 'like', 'passionate', 'interested', 'interest', 'want to work', 'want to study'];
        $hasPassionQuery = false;

        foreach ($passionKeywords as $pk) {
            if (str_contains($normalizedMessage, $pk)) {
                $hasPassionQuery = true;
                break;
            }
        }

        if ($hasPassionQuery) {
            // ICT / Programming / Software / Cybersecurity
            if (preg_match('/(برمجة|برمجه|شبكات|اتصالات|داتا|سايبر|أمن معلومات|حماية|software|programming|cyber|ict|network|data|security|coding|developer)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '💻 بما أنك مهتم بمجالات تكنولوجيا المعلومات والبرمجة، فإن القسم المثالي لك هو قسم تكنولوجيا المعلومات والاتصالات (ICT Department). هذا القسم يركز على تطوير البرمجيات (Software Engineering) وهندسة الشبكات (Network Engineering) مع تخصصات عملية في PHP, Laravel, Cisco CCNA, والأمن السيبراني. يمكنك استعراض المنهج الدراسي الكامل والوظائف المستقبلية عبر الضغط على بطاقة قسم ICT الموجودة في جزئية Departments بصفحة \'Home Page\'.'
                ]);
            }

            // Autotronics / Cars / Mechanics / Hybrid / EVs
            if (preg_match('/(سيارات|سياره|ميكانيكا|أوتو|اوتو|عربيات|هايبرد|كهربائية|cars|auto|mechanic|vehicle|hybrid|electric|ev)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🚗 بما أنك مهتم بمجال السيارات والميكانيكا، فإن القسم المثالي لك هو قسم الأوتوترونكس (Autotronics Department). هذا القسم يركز على تكنولوجيا السيارات الحديثة، الهايبرد، والمركبات الكهربائية (EVs) مع أنظمة التحكم الذكية. يمكنك استعراض المنهج الدراسي الكامل والوظائف المستقبلية عبر الضغط على بطاقة قسم Autotronics الموجودة في جزئية Departments بصفحة \'Home Page\'.'
                ]);
            }

            // Mechatronics / Robotics / Automation / PLC / SCADA
            if (preg_match('/(روبوت|روبوتات|ميكا|تحكم|أتمتة|اتمته|plc|scada|robot|automation|control|smart)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🤖 بما أنك مهتم بمجالات الروبوتات والأنظمة الذكية، فإن القسم المثالي لك هو قسم الميكاترونكس (Mechatronics Department). هذا القسم يركز على الروبوتات الصناعية، أنظمة التحكم PLC/SCADA، والأتمتة الذكية. يمكنك استعراض المنهج الدراسي الكامل والوظائف المستقبلية عبر الضغط على بطاقة قسم Mechatronics الموجودة في جزئية Departments بصفحة \'Home Page\'.'
                ]);
            }

            // Renewable Energy / Solar / Wind / Clean Energy
            if (preg_match('/(طاقة|شمسية|متجددة|نظيفة|رياح|solar|wind|renewable|clean|energy|green)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '☀️ بما أنك مهتم بمجالات الطاقة النظيفة والمتجددة، فإن القسم المثالي لك هو قسم الطاقة المتجددة (Renewable Energy Department). هذا القسم يركز على تكنولوجيا الطاقة الشمسية والرياح، مع وجود مسار تخصصي في السنة الثالثة (Solar Track vs Wind Track). يمكنك استعراض المنهج الدراسي الكامل والوظائف المستقبلية عبر الضغط على بطاقة قسم Renewable Energy الموجودة في جزئية Departments بصفحة \'Home Page\'.'
                ]);
            }

            // Prosthetics / Medical / Bionic Limbs / Rehabilitation
            if (preg_match('/(طبي|طبية|أطراف|اطراف|صناعية|تعويضية|بيونيك|إعادة تأهيل|prosthetic|medical|bionic|limb|rehabilitation|ortho)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🦾 بما أنك مهتم بمجالات التكنولوجيا الطبية والأجهزة التعويضية، فإن القسم المثالي لك هو قسم الأطراف الصناعية والأجهزة التعويضية (Prosthetics & Orthotics Department). هذا القسم يركز على تصميم وتصنيع الأطراف البيونية المتقدمة وأجهزة إعادة التأهيل الميكانيكية الحيوية. يمكنك استعراض المنهج الدراسي الكامل والوظائف المستقبلية عبر الضغط على بطاقة قسم Prosthetics الموجودة في جزئية Departments بصفحة \'Home Page\'.'
                ]);
            }

            // Petroleum / Oil / Gas / Drilling
            if (preg_match('/(بترول|نفط|غاز|حفر|petroleum|oil|gas|drill|production)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🛢️ بما أنك مهتم بمجالات النفط والغاز الطبيعي، فإن القسم المثالي لك هو قسم تكنولوجيا إنتاج البترول (Petroleum Production Technology Department). هذا القسم يركز على أنظمة التحكم في محطات الإنتاج النفطي، عمليات المعالجة، وتكنولوجيا الحفر الحديثة. يمكنك استعراض المنهج الدراسي الكامل والوظائف المستقبلية عبر الضغط على بطاقة قسم Petroleum الموجودة في جزئية Departments بصفحة \'Home Page\'.'
                ]);
            }
        }

        // ============================================================================
        // TIER 4: Comprehensive Campus Facilities & Services (Human Phrasing Context)
        // ============================================================================

        // Faculty Definitions
        $facultyQueryPatterns = ['كليات', 'الكليات', 'كلية', 'الجامعة فيها إيه', 'الجامعة فيها ايه', 'faculties', 'colleges', 'what faculties'];
        foreach ($facultyQueryPatterns as $fqp) {
            if (str_contains($normalizedMessage, $fqp)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🏛️ جامعة القاهرة الجديدة التكنولوجية (NCTU) تتكون من كليتين رئيسيتين:\n\n1️⃣ كلية تكنولوجيا الصناعة والطاقة (Faculty of Industry and Energy Technology)\n   - قسم ICT\n   - قسم Mechatronics\n   - قسم Autotronics\n   - قسم Renewable Energy\n   - قسم Petroleum Production\n\n2️⃣ كلية تكنولوجيا العلوم الصحية (Faculty of Health Sciences Technology)\n   - قسم Prosthetics & Orthotics\n\nيمكنك استعراض تفاصيل كل قسم عبر صفحة \'Home Page\' ثم الضغط على بطاقة القسم الذي يهمك.'
                ]);
            }
        }

        // Central Library Check
        $libraryPatterns = ['مكتبة', 'المكتبة', 'كتاب', 'كتب', 'استعارة', 'library', 'books', 'borrow', 'reading'];
        foreach ($libraryPatterns as $lp) {
            if (str_contains($normalizedMessage, $lp)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '📚 المكتبة المركزية متاحة في المبنى الرئيسي للجامعة وتحتوي على مراجع أكاديمية وتقنية شاملة. يمكنك استعراض تفاصيل أوقات العمل، نظام الاستعارة، والمراجع المتاحة عبر صفحة \'Library\' الموجودة في قائمة التنقل العلوية بالبورتال.'
                ]);
            }
        }

        // Campus Tour Navigation
        $campusTourPatterns = ['جولة', 'تور', 'مدرج', 'قاعة', 'معمل', 'معامل', 'ملاعب', 'ملعب', 'tour', 'campus', 'labs', 'hall', 'facilities', 'field'];
        foreach ($campusTourPatterns as $ctp) {
            if (str_contains($normalizedMessage, $ctp)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🏫 يمكنك الاطلاع على جولة مصورة شاملة لمنشآت الجامعة، المدرجات، المعامل، القاعات الدراسية، والملاعب الرياضية من خلال زيارة صفحة \'Campus Tour\' الموجودة في القائمة العلوية للبورتال. ستجد صور عالية الجودة وتفاصيل كاملة لكل مرفق.'
                ]);
            }
        }

        // Location & Address Quick Check
        $locationPatterns = ['مكان', 'فين', 'اروح', 'ازاي اروح', 'عنوان', 'العنوان', 'لوكيشن', 'موقع', 'location', 'address', 'where', 'map', 'خريطة', 'directions'];
        foreach ($locationPatterns as $lop) {
            if (str_contains($normalizedMessage, $lop)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '📍 العنوان الرسمي لجامعة القاهرة الجديدة التكنولوجية (NCTU):\n\n🏢 القاهرة الجديدة - التجمع الخامس - اللوتس الجنوبية - شارع النصر - مقابل نادي بنك مصر\n\nيمكنك الاطلاع على الخريطة التفاعلية وجميع وسائل التواصل الرسمية عبر صفحة \'Contact Us\' الموجودة في القائمة العلوية، أو مراسلتنا مباشرة عبر البريد الإلكتروني: info@nctu.edu.eg'
                ]);
            }
        }

        // ============================================================================
        // TIER 5: Dynamic Database Pattern Matching (BotResponse Model)
        // ============================================================================
        $matchedResponse = BotResponse::whereRaw('? LIKE CONCAT("%", keyword, "%")', [$normalizedMessage])
            ->first();

        if ($matchedResponse) {
            return response()->json([
                'status' => 'success',
                'reply' => $matchedResponse->reply
            ]);
        }

        // ============================================================================
        // TIER 6: Enforce Strict Page Naming Layouts (Additional Context Routing)
        // ============================================================================

        // General Departments / Programs Query
        $deptGeneralPatterns = ['قسم', 'أقسام', 'اقسام', 'تخصص', 'تخصصات', 'برامج', 'departments', 'programs', 'majors', 'specialization'];
        foreach ($deptGeneralPatterns as $dgp) {
            if (str_contains($normalizedMessage, $dgp)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🎯 يمكنك مراجعة جميع التخصصات والأقسام المتاحة بالجامعة عبر صفحة \'Home Page\' في قسم Departments، ثم الاطلاع على الشروط الأكاديمية والقبول التفصيلية لكل برنامج عبر صفحة \'Faculties Requirements\'. بعد الاطلاع على الشروط، يمكنك التقديم مباشرة عبر رابط \'Apply Now\' الموجود في القائمة العلوية.'
                ]);
            }
        }

        // Papers / Documents / Requirements
        $documentsPatterns = ['ورق', 'الورق', 'أوراق', 'مستندات', 'المستندات', 'documents', 'papers', 'ملفات', 'required documents'];
        foreach ($documentsPatterns as $dp) {
            if (str_contains($normalizedMessage, $dp)) {
                // Check if postgraduate context
                $postgradPatterns = ['دراسات عليا', 'دراسات', 'عليا', 'ماجستير', 'دكتوراه', 'postgraduate', 'master', 'phd', 'graduate studies'];
                foreach ($postgradPatterns as $pgp) {
                    if (str_contains($normalizedMessage, $pgp)) {
                        return response()->json([
                            'status' => 'success',
                            'reply' => '📄 بالنسبة للأوراق والمستندات المطلوبة للتقديم في برامج الدراسات العليا، يرجى زيارة صفحة \'Postgraduate Studies\' الموجودة في القائمة العلوية بالبورتال. ستجد قائمة شاملة بالشروط والمستندات المطلوبة لكل برنامج تكنولوجي متقدم (ماجستير ودكتوراه).'
                        ]);
                    }
                }

                // Undergraduate documents
                return response()->json([
                    'status' => 'success',
                    'reply' => '📄 الأوراق والمستندات الرسمية المطلوبة للالتحاق بالجامعة (للطلاب المستجدين) تختلف حسب نوع المؤهل الحاصل عليه. يمكنك الاطلاع على القائمة الكاملة للمستندات المطلوبة وكيفية رفعها عبر صفحة \'Admission Requirements\' الموجودة في القائمة العلوية. يرجى مراجعة مكتب شؤون الطلاب بمقر الجامعة لتسليم الملفات الرسمية.\n\n⏰ مواعيد العمل: من الأحد إلى الخميس، من الساعة 10:00 صباحاً وحتى الساعة 2:00 ظهراً.'
                ]);
            }
        }

        // Training / Internship / Workshops
        $trainingPatterns = ['تدريب', 'تدريبات', 'ورش', 'ورشة', 'training', 'internship', 'workshop', 'practical', 'hands-on'];
        foreach ($trainingPatterns as $tp) {
            if (str_contains($normalizedMessage, $tp)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🎓 الجامعة توفر برامج تدريبية متنوعة، ورش عمل، وفرص تدريب ميداني في الصناعة. يمكنك استعراض جميع البرامج التدريبية المتاحة، الشركاء من القطاع الصناعي، ومواعيد التقديم عبر صفحة \'Training\' الموجودة في القائمة العلوية بالبورتال.'
                ]);
            }
        }

        // Admission / Apply / Register
        $admissionPatterns = ['التحاق', 'تسجيل', 'تقديم', 'اسجل', 'قدم', 'ابدأ', 'admission', 'apply', 'register', 'enroll', 'application'];
        foreach ($admissionPatterns as $ap) {
            if (str_contains($normalizedMessage, $ap)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '📝 يمكنك إرسال طلب التحاق جديد أو متابعة حالة طلبك الحالي مباشرة من خلال الانتقال إلى صفحة التقديم الإلكتروني عبر رابط \'Apply Now\' الموجود في القائمة العلوية للبورتال. بعد ملء النموذج، ستتمكن من متابعة حالة طلبك من خلال بوابة Student Portal الخاصة بك.'
                ]);
            }
        }

        // Protocols (Internal/External)
        if (preg_match('/(بروتوكول|بروتوكولات|اتفاقيات|شراكات|protocol|agreement|partnership)/u', $normalizedMessage)) {
            if (preg_match('/(داخلي|محلي|internal|local)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🤝 يمكنك الاطلاع على جميع البروتوكولات والاتفاقيات الداخلية مع الجهات والمؤسسات المصرية عبر صفحة \'Internal Protocols\' الموجودة في قائمة About بالبورتال.'
                ]);
            }

            if (preg_match('/(خارجي|دولي|external|international)/u', $normalizedMessage)) {
                return response()->json([
                    'status' => 'success',
                    'reply' => '🌍 يمكنك الاطلاع على جميع البروتوكولات والاتفاقيات الدولية مع الجامعات والمؤسسات العالمية عبر صفحة \'External Protocols\' الموجودة في قائمة About بالبورتال.'
                ]);
            }

            // General protocols query
            return response()->json([
                'status' => 'success',
                'reply' => '🤝 يمكنك الاطلاع على جميع البروتوكولات والشراكات الاستراتيجية للجامعة (الداخلية والدولية) عبر صفحتي \'Internal Protocols\' و \'External Protocols\' الموجودتان في قائمة About بالبورتال.'
            ]);
        }

        // ============================================================================
        // TIER 7: Human-Style Logical Fallback & Campus Visiting Guard
        // ============================================================================
        return response()->json([
            'status' => 'success',
            'reply' => '🤖 عذراً، استفسارك خارج نطاق المعلومات الرقمية المتاحة حالياً. أنا مساعد رقمي متخصص في الاستفسارات الأكاديمية المتعلقة بجامعة NCTU (مثل التقديم، الأقسام، المصاريف، نظام بيرسون، والبرامج الدراسية).\n\n📍 للحصول على معلومات تفصيلية إضافية أو استفسارات خاصة، يمكنك زيارة:\n\n🏢 مكتب شؤون الطلاب بمقر الجامعة\n📅 أيام العمل: من الأحد إلى الخميس\n⏰ مواعيد العمل: من الساعة 10:00 صباحاً وحتى الساعة 2:00 ظهراً\n\n📧 أو يمكنك التواصل معنا عبر: info@nctu.edu.eg'
        ]);
    }
}
