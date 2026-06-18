<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BotResponse;
use Illuminate\Support\Facades\DB;

class BotResponseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TRUNCATE to avoid duplication conflicts
        DB::table('bot_responses')->truncate();
        
        $responses = [
            // [1. GENERAL GREETINGS - ARABIC & ENGLISH]
            ['keyword' => 'hello', 'reply' => 'Welcome to New Cairo Technological University Portal! How can I assist you today?'],
            ['keyword' => 'hi', 'reply' => 'Hello! Welcome to NCTU Portal. How can I help you navigate our services today?'],
            ['keyword' => 'ازيك', 'reply' => 'الحمد لله! أهلاً بك في بورتال جامعة القاهرة الجديدة التكنولوجية، كيف يمكنني مساعدتك اليوم؟'],
            ['keyword' => 'اهلا', 'reply' => 'أهلاً بك في بورتال جامعة القاهرة الجديدة التكنولوجية (NCTU)! كيف يمكنني مساعدتك اليوم؟'],
            ['keyword' => 'مرحبا', 'reply' => 'مرحباً بك في بورتال الجامعة! يسعدني مساعدتك في معرفة شروط التقديم، المصاريف، أو معلومات الأقسام.'],
            
            // [2. ONLINE ADMISSIONS & REGISTRATION]
            ['keyword' => 'admission', 'reply' => 'Online admission is open! Navigate to the Admissions menu -> \'How to Apply Online\' to submit your files and fill out the form step-by-step.'],
            ['keyword' => 'apply', 'reply' => 'To apply online, please log in or create a student account, then access the Admission Requirements and online forms.'],
            ['keyword' => 'تقديم', 'reply' => 'التقديم الإلكتروني مفتوح الآن! يمكنك الذهاب إلى قائمة Admissions ثم اختيار \'How to Apply Online\' وملء استمارة التقديم ورفع ملفاتك خطوة بخطوة.'],
            ['keyword' => 'اسجل', 'reply' => 'يمكنك التسجيل في بورتال الجامعة عن طريق إنشاء حساب طالب جديد، ثم ملء البيانات ورفع شهادة الميلاد والمستندات المطلوبة في استمارة القبول.'],
            
            // [3. TUITION FEES]
            ['keyword' => 'fees', 'reply' => 'Tuition fees for Year 1 & Year 2 are 15,000.00 EGP per year, and for Year 3 & Year 4 are 20,000.00 EGP per year, as officially set by the university.'],
            ['keyword' => 'cost', 'reply' => 'The annual tuition cost is 15,000 EGP for the diploma stage (Years 1-2) and 20,000 EGP for the bachelor\'s stage (Years 3-4).'],
            ['keyword' => 'مصاريف', 'reply' => 'المصاريف الدراسية الرسمية للجامعة هي: الفرقة الأولى والثانية (مرحلة الدبلوم) 15,000 جنيه سنوياً، والفرقة الثالثة والرابعة (مرحلة البكالوريوس) 20,000 جنيه سنوياً.'],
            ['keyword' => 'رسوم', 'reply' => 'الرسوم الدراسية ثابتة للعام الحالي بناءً على قرارات المجلس الأعلى للجامعات: 15 ألف لسنوات الدبلوم و 20 ألف لسنوات البكالوريوس.'],
            
            // [4. SCORES, COORDINATION PERCENTAGES & ACCEPTANCE]
            ['keyword' => 'coordination', 'reply' => 'The official coordination minimums for the current academic year are currently under review. Last year\'s acceptance threshold for technical diplomas and Applied Technology schools was around 98%.'],
            ['keyword' => 'كام', 'reply' => 'حالياً تنسيق العام الحالي لا يزال تحت المراجعة والاعتماد، ولكن للعلم: تنسيق العام الماضي لطلاب الدبلومات الفنية ومدارس التكنولوجيا التطبيقية كان بحد أدنى حوالي 98%، وهو غير مؤكد بنسبة كاملة لهذا العام حتى الآن.'],
            ['keyword' => 'مجموع', 'reply' => 'إذا كنت تسأل عن المجموع والقبول: التنسيق الحالي قيد المراجعة ولم يعلن رسمياً بعد. تنسيق العام الماضي كان في حدود 98% للدبلومات الفنية والتكنولوجيا التطبيقية. ننصحك بمتابعة البورتال بانتظام لمعرفة الحدود الدنيا فور صدورها.'],
            ['keyword' => 'جايب', 'reply' => 'أهلاً بك! لمعرفة هل مجموعك مقبول أم لا: التنسيق الجديد لسه تحت المراجعة، لكن كمرجع لك، تنسيق السنة اللي فاتت استقبل رغبات الطلاب من حوالي 98% لشهادات الدبلومات والتكنولوجيا التطبيقية.'],
            
            // [5. APPLIED TECHNOLOGY SCHOOLS eligibility]
            ['keyword' => 'applied technology', 'reply' => 'Graduates of Applied Technology Schools are highly eligible to join our advanced departments (ICT, Mechatronics, Autotronics, Petroleum) provided they meet coordination rules and pass capability entrance tests.'],
            ['keyword' => 'مدارس', 'reply' => 'الجامعة ترحب بخريجي مدارس التكنولوجيا التطبيقية التي تضم تخصصات مطابقة لأقسامنا (مثل: مدرسة WE ومدرسة HST للحاسبات ونظم المعلومات، مدرسة ظهر لتكنولوجيا البترول، ومدارس السويدي للميكاتروينكس والأوتوترونكس).'],
            ['keyword' => 'تطبيقية', 'reply' => 'خريجو مدارس التكنولوجيا التطبيقية مؤهلون تماماً للتقديم في أقسام الجامعة المختلفة (ICT، ميكاترونكس، أوتوترونكس، بترول) بشرط اجتياز اختبارات القبول المحددة وتوافق التنسيق.'],
            
            // [6. PROSTHETICS & HEALTH SCIENCES DEGREE INFRASTRUCTURE]
            ['keyword' => 'prosthetics', 'reply' => 'The Prosthetics, Orthotics, and Health Science Technology program accepts high school graduates (Scientific Section - Biology branch) strictly via the official Egyptian Government Electronic Coordination Office.'],
            ['keyword' => 'اطراف', 'reply' => 'بالنسبة لتخصص الأطراف الصناعية والأجهزة التعويضية وتكنولوجيا العلوم الصحية: التقديم متاح لطلاب الثانوية العامة (شعبة علمي علوم) من خلال مكتب التنسيق الإلكتروني الحكومي الرسمي.'],
            ['keyword' => 'علوم صحية', 'reply' => 'كلية تكنولوجيا العلوم الصحية بالجامعة مخصصة لطلاب الثانوية العامة (علمي علوم)، ويتم الترشيح لها مباشرة عبر مكتب التنسيق الحكومي للجامعات المصرية.'],
            
            // [7. AGE LIMITS & ACCREDITATION STIPULATIONS]
            ['keyword' => 'age', 'reply' => 'NCTU admission does not enforce a biological age limit, but requires that your high school, diploma, or applied technology certificate must be issued within the current or previous year at maximum.'],
            ['keyword' => 'accredited', 'reply' => 'Yes, all programs at New Cairo Technological University are fully accredited by the Supreme Council of Universities and directly regulated by the Ministry of Higher Education.'],
            ['keyword' => 'سني', 'reply' => 'القبول بالجامعة لا يشترط سناً معيناً بشكل مباشر، وإنما يشترط سنة الحصول على المؤهل. التقديم متاح لحديثي التخرج من الثانوية العامة، الدبلومات الفنية، ومدارس التكنولوجيا التطبيقية (خريجي العام الحالي أو العام السابق كحد أقصى) بشرط استيفاء مجموع التنسيق واجتياز اختبارات القبول.'],
            ['keyword' => 'السن', 'reply' => 'شرط السن مرتبط بسنة التخرج: القبول متاح لطلاب الثانوية والدبلومات والتكنولوجيا التطبيقية الذين لم يمر على تاريخ تخرجهم أكثر من عامين كحد أقصى من تاريخ فتح باب التنسيق.'],
            ['keyword' => 'شهادة', 'reply' => 'تمنح الجامعة خريجيها شهادة \'البكالوريوس التكنولوجي المهني\' في التخصص، وهي شهادة رسمية معتمدة بالكامل من وزارة التعليم العالي المصرية والمجلس الأعلى للجامعات، وتؤهل الخريج كأخصائي تكنولوجي في مجاله بسوق العمل المحلي والدولي.'],
            ['keyword' => 'معتمد', 'reply' => 'نعم، جميع برامج وأقسام جامعة NCTU معتمدة رسمياً من المجلس الأعلى للجامعات المصرية وتخضع لإشراف وزارة التعليم العالي والبحث العلمي.'],
            ['keyword' => 'بنات', 'reply' => 'الدراسة في جميع أقسام الجامعة المتقدمة (مثل تكنولوجيا المعلومات ICT، الميكاترونكس، والأوتوترونكس) متاحة تماماً للبنين والبنات بالتساوي وبدون أي تفرقة.'],
            
            // [8. INTERNAL / EXTERNAL PROTOCOLS & COLLABORATIONS]
            ['keyword' => 'protocols', 'reply' => 'NCTU maintains prominent industrial ties. For domestic partnerships with conglomerates like Petrojet and telecommunication firms, view \'Internal Protocols\'. For partnerships with Chinese technology giants, view \'External Protocols\'.'],
            ['keyword' => 'بروتوكول', 'reply' => 'ترتبط الجامعة بروابط وثيقة مع قطاع الصناعة لضمان التدريب العملي؛ حيث تم توقيع بروتوكولات تعاون كبرى داخل مصر مع شركات عملاقة مثل Petrojet وشركات الطاقة والاتصالات. للاطلاع على التفاصيل الكاملة، يرجى الانتقال إلى صفحة \'Internal Protocols\' بالبورتال.'],
            ['keyword' => 'جوه مصر', 'reply' => 'الشراكات المحلية داخل مصر تشمل بروتوكولات تعاون مع كيانات صناعية رائدة وشركات هندسية كبرى لتوفير تدريب ميداني معتمد للطلاب. القائمة كاملة ومحدثة متوفرة في صفحة \'Internal Protocols\' بالموقع.'],
            ['keyword' => 'بره مصر', 'reply' => 'على الصعيد الدولي، تمتلك الجامعة شراكات وبروتوكولات متميزة خارج مصر، أبرزها التعاون مع الشركات الصينية التكنولوجية الكبرى لتطوير المعايير التقنية وتبادل الخبرات. يمكنك تصفح تفاصيلها بالكامل عبر صفحة \'External Protocols\'.'],
            ['keyword' => 'دولية', 'reply' => 'International partnerships at NCTU include strategic academic and industrial protocols with major Chinese technology corporations to align our curriculum with global tech standards. View more on the \'External Protocols\' page.'],
            
            // [9. STUDENT FIELD TRAINING, EVENTS & EVENTS LINKS]
            ['keyword' => 'training', 'reply' => 'We offer tailored student field training backed by Orange Egypt, ITIDA qualification programs (itida+gigs), and technical workshops hosted by GDG NCTU. Check open scopes on the dedicated \'Training\' page.'],
            ['keyword' => 'تدريب', 'reply' => 'تهتم الجامعة بالجانب العملي وتوفر تدريبات ميدانية وايفينتات تقنية بالتعاون مع جهات داعمة كبرى مثل Orange Egypt، وبرامج التأهيل الحر مع ITIDA (برنامج itida+gigs)، بالإضافة للورش الفنية التي يقدمها مجتمع مطوري جوجل GDG NCTU. لمتابعة الفرص الحالية، قم بزيارة صفحة \'Training\' بالبورتال.'],
            ['keyword' => 'ايفينت', 'reply' => 'تستضيف الجامعة وتشارك في ايفينتات ومعارض تقنية كبرى (مثل Cairo ICT)، وتوفر ورش عمل مستمرة للطلاب مدعومة من مجتمعات التكنولوجيا مثل GDG على كامبس الجامعة والشركاء الصناعيين. تابع التفاصيل في صفحة \'Training\' أو المعارض الرسمية.'],
            
            // [10. RECOGNIZED UNIVERSITY SYLLABUS & INTEGRATED HOME ROUTING]
            ['keyword' => 'courses', 'reply' => 'To review the complete course syllabi, modules, and credit flows for all technological departments, please inspect the dynamic \'Departments Layout Grid\' located inside our portal\'s Home Page.'],
            ['keyword' => 'ادرس', 'reply' => 'لمعرفة المناهج والكورسات بالتفصيل، يرجى مراجعة جزئية الأقسام (Departments Section) في الصفحة الرئيسية (Home Page) بالموقع، حيث تجد تفاصيل المواد والمستقبل الوظيفي لكل تخصص.'],
            ['keyword' => 'كورسات', 'reply' => 'To see the complete syllabus and course list for each department, please check the \'Departments\' layout grid embedded directly in our website\'s Home Page.'],
            
            // [11. EXTENSIVE PEARSON BRITISH EVALUATION SYSTEM & MARKS SPECIFICATIONS]
            ['keyword' => 'pearson', 'reply' => 'Evaluation follows the British Pearson system across 3 tiers: Pass (Foundational), Merit (Intermediate - 80%), and Distinction (Advanced - 100%). Students must correctly clear all Pass criteria to avoid a \'Resubmission\' round. Theoretical courses hold 100 marks, practical courses hold 150 marks (Passing line is 60%) distributed across Assignment 1, Assignment 2, Attendance, and Finals.'],
            ['keyword' => 'صعبة', 'reply' => 'الدراسة تعتمد على ميولك؛ اختر القسم المناسب لشغفك وستجدها ممتعة! الجامعة تضم نخبة من أعضاء هيئة التدريس والمعيدين على أعلى مستوى. نتبع نظام تقييم Pearson البريطاني المقسم لـ 3 مستويات: Pass (مستوى النجاح الأساسي)، Merit (المستوى المتوسط 80%)، وDistinction (المستوى الأعلى للتفوق 100%).'],
            ['keyword' => 'تقييم', 'reply' => 'نظام التقييم لدينا يتبع معايير Pearson البريطانية: الامتحان مقسم لـ P (Pass)، M (Merit)، D (Distinction). يجب حل أسئلة الـ Pass كاملة وبشكل صحيح أولاً للنجاح. إذا أخطأت في الـ Pass تدخل محاولة ثانية (Resubmission) على أسئلة الـ Pass. إذا قفلت الـ P والـ M تأخذ 80%، وإذا قفلت الامتحان كاملاً تأخذ D (امتياز 100%). المواد نوعان: نظري (100 درجة) وعملي (150 درجة)، والنجاح من 60% مقسمة على Assignment 1 و Assignment 2 والحضور والامتحان النهائي.'],
            ['keyword' => 'اسايمنت', 'reply' => 'نظام بيرسون يعتمد على تقديم Assignments لتغطية معايير المادة. في حال عدم تحقيق معايير الـ Pass في المحاولة الأولى، يمنح الطالب فرصة محاولة ثانية مخصصة (Resubmission). وإذا لم يوفق فيها، ينتقل للمحاولة النهائية (Retake) على المادة لضمان تكافؤ الفرص التعليمية.'],
            
            // [12. GRADUATION CEREMONIES & SOCIAL MEDIA HANDLES]
            ['keyword' => 'graduation', 'reply' => 'Official graduation dates and ceremony announcements are regularly uploaded to our official website nctu.edu.eg and corresponding social platforms (LinkedIn: linkedin.com/in/nctu, Twitter/X: x.com/nctu_edu_eg_1, YouTube: @nctu.edu.eg.1).'],
            ['keyword' => 'حفلة', 'reply' => 'لمعرفة مواعيد وتفاصيل حفلات التخرج الرسمية، يرجى متابعة الروابط الرسمية وصفحة الفيسبوك الخاصة بالجامعة nctu.edu.eg حيث يتم نشر التحديثات اللحظية هناك.'],
            ['keyword' => 'تخرج', 'reply' => 'تفاصيل تخرج الدفعات وحفلات التخرج يتم إعلانها رسمياً عبر الموقع الإلكتروني nctu.edu.eg وقنوات التواصل الاجتماعي التابعة للجامعة.'],
            
            // [13. ICT WORK DEPARTMENTS, CISCO TRACKS & FREELANCING PLATFORMS]
            ['keyword' => 'ict', 'reply' => 'The ICT Department provides professional software engineering training focusing on Back-end Web Development (PHP & Laravel), Database structures, and Cisco-certified Networking Academies (CCNA, Subnetting, and VLAN configurations).'],
            ['keyword' => 'freelance', 'reply' => 'NCTU supports career Readiness via ITIDA+gigs Freelance Qualification training paths, steering ICT backend developers toward global remote work and software engineering architectures.'],
            ['keyword' => 'شبكات', 'reply' => 'نعم، يتضمن برنامج تكنولوجيا المعلومات (ICT) تدريباً مكثفاً ومكتملاً على هندسة الشبكات وبنيتها التحتية، ويشمل ذلك شهادات وتدريبات Cisco الأكاديمية (مثل CCNA وNetworking Basics)، بالإضافة إلى حسابات الشبكات (Subnetting) وإعداد الـ VLANs.'],
            ['keyword' => 'برمجة', 'reply' => 'إذا كنت شغوفاً بالبرمجة، يفضل دخول قسم تكنولوجيا المعلومات (ICT). يؤهلك القسم للعمل كمطور ويب للباك إند (Back-end Developer باستخدام PHP/Laravel)، أو مهندس شبكات (Network Engineer)، أو مسؤول إدارة قواعد البيانات (Database Administrator).'],
            ['keyword' => 'شغل', 'reply' => 'بورتال الجامعة يدعم تأهيل الطلاب لسوق العمل الحر والوظائف الشركاتية؛ حيث توفر الجامعة برامج qualification بالتعاون مع جهات مثل ITIDA (برنامج itida+gigs) لتمكين خريجي الـ ICT من اقتناص فرص العمل المستقل في تطوير الباك إند والشبكات فور التخرج.'],
            ['keyword' => 'قسم', 'reply' => 'تضم الكلية عدة أقسام متميزة مثل: تكنولوجيا المعلومات (ICT)، الأوتوترونكس، الميكاترونكس، تكنولوجيا البترول، الأطراف الصناعية، والطاقة المتجددة. يمكنك تصفح تفاصيل كل قسم من قائمة Departments.'],
            
            // [14. FOREIGN INTERNATIONAL STUDENTS & POSTGRADUATE SCOPES]
            ['keyword' => 'postgraduate', 'reply' => 'NCTU offers advanced professional Postgraduate Programs (Professional Masters and Technological Doctorate) for bachelor holders aiming to blend real industrial R&D with field labor.'],
            ['keyword' => 'international', 'reply' => 'Foreign and international students are welcomed to enroll in NCTU\'s tech degrees through the official Ministry of Higher Education platform \'Study In Egypt\'.'],
            ['keyword' => 'دراسات', 'reply' => 'نعم، تتيح الجامعة لخريجي البكالوريوس التكنولوجي إمكانية التقديم في برامج الدراسات العليا التكنولوجية المهنية المتقدمة (الماجستير والدكتوراه التكنولوجي) لربط البحث العلمي بالتطوير الصناعي وسوق العمل.'],
            ['keyword' => 'وافد', 'reply' => 'ترحب الجامعة بالطلاب الوافدين من خارج مصر للالتحاق بكلياتها التكنولوجية المتطورة، ويتم التقديم الرسمي للطلاب الدوليين والوافدين عبر منصة \'ادرس في مصر\' (Study In Egypt) الحكومية التابعة لوزارة التعليم العالي.'],
            
            // [15. CAMPUS OPERATIONAL TIMINGS & SITE CREDENTIALS]
            ['keyword' => 'open', 'reply' => 'The campus operating hours are Sunday to Thursday from 8:30 AM to 3:00 PM. Friday and Saturday are official university holidays.'],
            ['keyword' => 'تفتح', 'reply' => 'تفتح الجامعة أبوابها ومكاتب شؤون الطلاب يومياً من الأحد إلى الخميس، وتبدأ المواعيد الرسمية للمحاضرات والإدارات من الساعة 8:30 صباحاً وحتى الساعة 3:00 عصراً.'],
            ['keyword' => 'عنوان', 'reply' => 'تقع جامعة القاهرة الجديدة التكنولوجية (NCTU) في منطقة اللوتس، التجمع الخامس، القاهرة الجديدة. الروابط الرسمية: nctu.edu.eg والإيميل info@nctu.edu.eg.'],
            
            // [16. SECURED CORE BLOCKERS & OUT-OF-SCOPE INQUIRIES]
            ['keyword' => 'أكل', 'reply' => 'عذراً، أنا مساعد رقمي مخصص للإجابة على الاستفسارات الأكاديمية والتقنية لبورتال جامعة القاهرة الجديدة التكنولوجية (NCTU) فقط (مثل التقديم، المصاريف، والأقسام). يسعدني مساعدتك في هذه المجالات.'],
            ['keyword' => 'اكل', 'reply' => 'عذراً، أنا مساعد رقمي مخصص للإجابة على الاستفسارات الأكاديمية والتقنية لبورتال جامعة القاهرة الجديدة التكنولوجية (NCTU) فقط (مثل التقديم، المصاريف، والأقسام). يسعدني مساعدتك في هذه المجالات.'],
            ['keyword' => 'food', 'reply' => 'Apologies, I am a digital assistant dedicated solely to academic and technical inquiries for the NCTU Portal (e.g., Admissions, Fees, and Departments). I\'d be glad to help you with any university-related questions.'],
            ['keyword' => 'movie', 'reply' => 'Apologies, I am a digital assistant dedicated solely to academic and technical inquiries for the NCTU Portal (e.g., Admissions, Fees, and Departments). I\'d be glad to help you with any university-related questions.'],
            ['keyword' => 'امسح', 'reply' => 'هذا ليس من اختصاصي. أنا مساعد رقمي مخصص لخدمتك والإجابة على الاستفسارات الأكاديمية فقط، ولا يمكنني إجراء أي تعديلات على قواعد البيانات أو النظام.'],
            ['keyword' => 'delete', 'reply' => 'This is outside my scope. I am a secured digital assistant dedicated strictly to providing academic information; database or system manipulation is blocked.'],
        ];

        foreach ($responses as $response) {
            BotResponse::create($response);
        }
    }
}
