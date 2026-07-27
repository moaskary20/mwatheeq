<?php

use App\Models\Client;
use App\Models\Partner;
use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $now = now();

        $settings = [
            'intro_eyebrow' => 'تعرف علينا',
            'intro_title' => 'شريككم الموثوق لإنجاز معاملات الجهات الحكومية',
            'intro_p1' => 'نوفر حلولًا متكاملة لإنجاز جميع المعاملات والإجراءات الحكومية بكفاءة واحترافية، من خلال فريق متخصص يمتلك خبرة واسعة في التعامل مع مختلف الجهات الحكومية، بما في ذلك الشهر العقاري، ودواوين المحافظات، والأحياء، وهيئة المساحة المصرية، وغيرها من الجهات ذات الصلة.',
            'intro_p2' => 'نتولى تنفيذ جميع الإجراءات اللازمة لتسجيل الأراضي والعقارات، واستخراج التراخيص، وإنهاء معاملات تأسيس الشركات وتعديلها، مع الالتزام الكامل بالأنظمة واللوائح القانونية المعمول بها.',
            'intro_p3' => 'نعمل على تبسيط الإجراءات وتسريع دورة العمل، بما يضمن توفير الوقت والجهد، وتحقيق أعلى مستويات الدقة والموثوقية في إنجاز معاملاتكم.',
            'intro_p4' => 'خبرتنا... تضمن لكم إنجازًا أسرع، وإجراءات أكثر سلاسة، وخدمة احترافية يمكنكم الاعتماد عليه.',
            'intro_float_label' => 'نهج قانوني متكامل',
            'intro_float_value' => 'دقة · سرعة · التزام',
            'intro_trust_exp' => 'خبرة',
            'intro_trust_exp_sub' => 'متخصصون حكوميون',
            'intro_trust_speed' => 'سرعة',
            'intro_trust_speed_sub' => 'إنجاز في أقصر وقت',
            'intro_trust_commit' => 'التزام',
            'intro_trust_commit_sub' => 'إطار قانوني واضح',
            'intro_tags' => "الشهر العقاري\nديوان المحافظات\nديوان الأحياء\nالدفاع المدني\nتراخيص الشركات",
            'intro_image' => 'image/sections/intro.jpg',
            'services_eyebrow' => 'خدماتنا',
            'services_title' => 'الخدمات الحكومية',
            'services_lead' => 'حلول متكاملة تسهّل إجراءاتكم الحكومية بكفاءة ووضوح واحترافية عالية.',
            'goals_eyebrow' => 'رؤيتنا العملية',
            'goals_title' => 'أهدافنا',
            'goals_subtitle' => 'نحن ملتزمون بتحقيق أهدافنا من خلال فريق عمل محترف وملتزم.',
            'why_eyebrow' => 'تميّزنا',
            'why_title' => 'لماذا تختارنا؟',
            'why_lead' => 'نجمع بين الخبرة الميدانية والدقة الإدارية لنقدّم تجربة سلسة ونتائج موثوقة.',
            'clients_eyebrow' => 'ثقة المصانع والشركات',
            'clients_title' => 'عملاؤنا',
            'clients_lead' => 'نفتخر بشراكتنا مع مجموعة من المصانع والشركات الرائدة، ونقدّم لهم حلولًا حكومية موثوقة تسرّع الإنجاز وتحفظ الجودة.',
            'clients_count_label' => 'مصنع وشركة',
            'clients_sectors' => 'قطاعات متعددة',
            'clients_sectors_sub' => 'تجارة · إنشاء · بنوك',
            'clients_partnership' => 'شراكة مستمرة',
            'clients_partnership_sub' => 'متابعة وإنجاز حكومي',
            'partners_eyebrow' => 'شبكة تعامل حكومي',
            'partners_title' => 'الجهات المتعامل معها',
            'partners_lead' => 'خريطة الجهات والهيئات التي نتعامل معها يوميًا لإنجاز معاملاتكم بمسار واضح وموثوق.',
            'partners_seal' => 'جهة وهيئة',
            'partners_label' => 'جهة معتمدة',
            'contact_eyebrow' => 'تواصل معنا',
            'contact_title' => 'اتصل بنا',
            'contact_lead' => 'يسعدنا تواصلكم معنا، أرسل استفسارك أو زر مقرنا في الإسكندرية.',
            'cta_consult' => 'اطلب استشارة',
            'cta_view_services' => 'استعرض خدماتنا',
            'cta_contact_us' => 'تواصل معنا',
            'cta_contact_now' => 'تواصل معنا الآن',
            'cta_request_service' => 'اطلب خدمة الآن',
            'preloader_welcome' => 'يرحب بكم',
            'footer_designed_by' => 'تم التصميم بواسطة',
            'footer_designer_name' => 'Caesar Agency',
            'website_url' => 'mwatheeq.com',
            'whatsapp_display' => '01272269000',
        ];

        foreach ($settings as $key => $value) {
            if (blank(Setting::get($key))) {
                Setting::set($key, $value);
            }
        }

        if (Schema::hasTable('clients') && Client::query()->count() === 0) {
            $clients = [
                ['name' => 'شركة الصفاء للاستيراد والتصدير (للمولدات)', 'logo' => 'image/clients/al-safa.svg', 'sort_order' => 1],
                ['name' => 'شركة الوادي لتصدير الحاصلات الزراعية', 'logo' => 'image/clients/al-wadi.svg', 'sort_order' => 2],
                ['name' => 'شركة الحياة للإنشاء والتعمير', 'logo' => 'image/clients/al-hayat.svg', 'sort_order' => 3],
                ['name' => 'شركة البركة لقطاع غيار سيارات النقل الثقيل', 'logo' => 'image/clients/al-baraka-parts.svg', 'sort_order' => 4],
                ['name' => 'الجمعية التعاونية للبناء والإسكان للعاملين بشركة النصر للأصواف والمنسوجات الممتازة (ستيا)', 'logo' => 'image/clients/setia-coop.svg', 'sort_order' => 5],
                ['name' => 'بنك البركة مصر', 'logo' => 'image/clients/al-baraka-bank.svg', 'sort_order' => 6],
                ['name' => 'شركة حلوان للحديد والصلب', 'logo' => 'image/clients/helwan-steel.svg', 'sort_order' => 7],
            ];

            foreach ($clients as $client) {
                Client::query()->create($client + [
                    'is_published' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }

        if (Schema::hasTable('partners') && Partner::query()->count() === 0) {
            $partners = [
                ['name' => 'مأموريات الشهر العقاري', 'icon' => 'registry', 'sort_order' => 1],
                ['name' => 'هيئة المساحة المصرية', 'icon' => 'survey', 'sort_order' => 2],
                ['name' => 'هيئة الطيران المدني', 'icon' => 'aviation', 'sort_order' => 3],
                ['name' => 'هيئة الآثار', 'icon' => 'antiquities', 'sort_order' => 4],
                ['name' => 'هيئة المياه وهيئة الصرف الصحي', 'icon' => 'water', 'sort_order' => 5],
                ['name' => 'هيئة الاستثمار', 'icon' => 'investment', 'sort_order' => 6],
                ['name' => 'هيئة الاتصالات', 'icon' => 'telecom', 'sort_order' => 7],
                ['name' => 'هيئة المجتمعات العمرانية', 'icon' => 'urban', 'sort_order' => 8],
                ['name' => 'جهاز مدينة برج العرب', 'icon' => 'city', 'sort_order' => 9],
                ['name' => 'جهاز مدينة ٦ أكتوبر', 'icon' => 'city-oct', 'sort_order' => 10],
                ['name' => 'وجميع الهيئات والمؤسسات الحكومية الأخرى', 'icon' => 'government', 'sort_order' => 11],
            ];

            foreach ($partners as $partner) {
                Partner::query()->create($partner + [
                    'is_published' => true,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        // Keep seeded content; intentional no-op.
    }
};
