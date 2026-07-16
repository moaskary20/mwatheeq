<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\Setting;
use App\Models\User;
use App\Models\Goal;
use App\Models\WhyPoint;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@mwatheeq.test'],
            [
                'name' => 'مدير النظام',
                'password' => Hash::make('password'),
            ],
        );

        $settings = [
            'site_tagline' => 'موثوقية · وضوح · التزام',
            'hero_title' => 'نصوغ المواثيق التي تبني الثقة',
            'hero_subtitle' => 'مواثيق منصة متخصصة في صياغة العقود والاتفاقيات والوثائق القانونية باحترافية عالية، لنحمي مصالحكم ونرسّخ علاقات عمل واضحة.',
            'about_title' => 'من نحن',
            'about_body' => 'تأسست مواثيق لتقدّم حلولاً متكاملة في إعداد وصياغة الوثائق القانونية والتجارية. نجمع بين الدقة القانونية واللغة الواضحة، لنحوّل الاتفاقيات المعقّدة إلى مواثيق مفهومة وقابلة للتنفيذ.',
            'vision' => 'أن نكون المرجع الأول في صياغة المواثيق والاتفاقيات الموثوقة في المنطقة.',
            'mission' => 'تمكين الأفراد والمؤسسات من توثيق علاقاتهم التجارية والقانونية بمعايير احترافية وشفافة.',
            'phone' => '01287070112',
            'email' => 'info@mwatheeq.test',
            'whatsapp' => '01272269000',
            'facebook_url' => 'https://facebook.com/mwatheeq',
            'instagram_url' => 'https://instagram.com/mwatheeq',
            'address' => '٩ شارع د. برجي، بجوار مستشفى الأهلي التخصصي، كفر عبدو، الإسكندرية',
            'address_en' => '9 Dr. Burji Street, next to Al Ahly Specialized Hospital, Kafr Abdo, Alexandria',
            'map_query' => '9 Dr. Burji Street, next to Al Ahly Specialized Hospital, Kafr Abdo, Alexandria',
            'footer_text' => 'المواثيق للخدمات الحكومية — شريككم الموثوق في الإجراءات الحكومية.',
            'goals_subtitle' => 'نحن ملتزمون بتحقيق أهدافنا من خلال فريق عمل محترف وملتزم.',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }

        $services = [
            [
                'title' => 'المسح والرفع المساحي',
                'slug' => 'surveying',
                'summary' => 'تحديد المواقع الجغرافية وقياس المساحات والأحجام بدقة عالية.',
                'description' => '<p>نقوم بتحديد المواقع الجغرافية وقياس المساحات والأحجام بدقة عالية وفقاً للمعايير الفنية المعتمدة.</p>',
                'icon' => 'heroicon-o-map',
                'image' => 'services/surveying.jpg',
                'sort_order' => 1,
            ],
            [
                'title' => 'تسجيل العقارات',
                'slug' => 'real-estate-registration',
                'summary' => 'تسجيل العقارات والحصول على صكوك الملكية بسهولة وسرعة.',
                'description' => '<p>نساعدكم في تسجيل العقارات واستخراج صكوك الملكية بإجراءات ميسّرة وسريعة.</p>',
                'icon' => 'heroicon-o-home-modern',
                'image' => 'services/real-estate.jpg',
                'sort_order' => 2,
            ],
            [
                'title' => 'استخراج رخص البناء',
                'slug' => 'building-permits',
                'summary' => 'استخراج رخص البناء وتقديم الاستشارات حول متطلبات البناء.',
                'description' => '<p>ننهي إجراءات استخراج رخص البناء ونقدّم الاستشارات اللازمة حول متطلبات البناء والأنظمة ذات الصلة.</p>',
                'icon' => 'heroicon-o-building-office-2',
                'image' => 'services/building.jpg',
                'sort_order' => 3,
            ],
            [
                'title' => 'استخراج رخص المصانع',
                'slug' => 'factory-licenses',
                'summary' => 'استخراج رخص المصانع وتقديم الاستشارات حول متطلبات المصانع.',
                'description' => '<p>نساعد في الحصول على رخص المصانع وتقديم الاستشارات المتعلقة بمتطلبات المنشآت الصناعية.</p>',
                'icon' => 'heroicon-o-cog-6-tooth',
                'image' => 'services/factory.jpg',
                'sort_order' => 4,
            ],
            [
                'title' => 'استخراج الرخص التجارية',
                'slug' => 'commercial-licenses',
                'summary' => 'استخراج الرخص التجارية وتقديم الاستشارات حول متطلبات المحلات التجارية.',
                'description' => '<p>نسهّل استخراج الرخص التجارية ونقدّم المشورة حول متطلبات المحلات والمنشآت التجارية.</p>',
                'icon' => 'heroicon-o-shopping-bag',
                'image' => 'services/commercial.jpg',
                'sort_order' => 5,
            ],
        ];

        Service::query()->whereNotIn('slug', collect($services)->pluck('slug'))->delete();

        foreach ($services as $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                $service + ['is_published' => true],
            );
        }

        $goals = [
            [
                'title' => 'الخدمات الحكومية',
                'summary' => 'تقديم خدمات حكومية متميزة وذات جودة عالية',
                'sort_order' => 1,
            ],
            [
                'title' => 'تعزيز صورة الشركة',
                'summary' => 'تعزيز صورة الشركة كشريك موثوق ومتميز في الخدمات الحكومية',
                'sort_order' => 2,
            ],
            [
                'title' => 'تحسين تجربة العملاء',
                'summary' => 'تحسين تجربة العملاء مع الخدمات الحكومية',
                'sort_order' => 3,
            ],
            [
                'title' => 'تسهيل الإجراءات',
                'summary' => 'تسهيل الإجراءات الحكومية لعملائنا',
                'sort_order' => 4,
            ],
        ];

        Goal::query()->whereNotIn('title', collect($goals)->pluck('title'))->delete();

        foreach ($goals as $goal) {
            Goal::query()->updateOrCreate(
                ['title' => $goal['title']],
                $goal + ['is_published' => true],
            );
        }

        $whyPoints = [
            'خبرة واسعة في الخدمات الحكومية.',
            'فريق عمل محترف وملتزم.',
            'خدمات متميزة وعالية الجودة.',
            'السرعة والكفاءة في تقديم الخدمات.',
            'الالتزام بالمواعيد والتواريخ.',
        ];

        WhyPoint::query()->whereNotIn('title', $whyPoints)->delete();

        foreach ($whyPoints as $index => $title) {
            WhyPoint::query()->updateOrCreate(
                ['title' => $title],
                [
                    'sort_order' => $index + 1,
                    'is_published' => true,
                ],
            );
        }

        $slides = [
            [
                'title' => 'المواثيق للخدمات الحكومية',
                'subtitle' => 'ننجز معاملاتكم الحكومية باحترافية ودقة عالية',
                'image' => 'slides/hero-01.jpg',
                'button_text' => 'تواصل معنا',
                'button_url' => '#contact',
                'sort_order' => 1,
            ],
            [
                'title' => 'المسح والرفع المساحي',
                'subtitle' => 'تحديد المواقع وقياس المساحات بدقة ميدانية معتمدة',
                'image' => 'slides/hero-02.jpg',
                'button_text' => 'خدماتنا',
                'button_url' => '#services',
                'sort_order' => 2,
            ],
            [
                'title' => 'رخص البناء والمشاريع',
                'subtitle' => 'استشارات وإجراءات للحصول على الرخص بسهولة',
                'image' => 'slides/hero-03.jpg',
                'button_text' => 'استعرض الخدمات',
                'button_url' => '#services',
                'sort_order' => 3,
            ],
            [
                'title' => 'تسجيل العقارات',
                'subtitle' => 'تسجيل العقارات واستخراج الصكوك بسرعة وأمان',
                'image' => 'slides/hero-04.jpg',
                'button_text' => 'لماذا تختارنا',
                'button_url' => '#why',
                'sort_order' => 4,
            ],
            [
                'title' => 'فريق محترف ملتزم',
                'subtitle' => 'خبرة واسعة والتزام كامل بالمواعيد وجودة الخدمة',
                'image' => 'slides/hero-05.jpg',
                'button_text' => 'اتصل بنا',
                'button_url' => '#contact',
                'sort_order' => 5,
            ],
        ];

        \App\Models\Slide::query()->whereNotIn('image', collect($slides)->pluck('image'))->delete();

        foreach ($slides as $slide) {
            \App\Models\Slide::query()->updateOrCreate(
                ['image' => $slide['image']],
                $slide + ['is_published' => true],
            );
        }

        $posts = [
            [
                'title' => 'دليل تسجيل العقارات في الإسكندرية',
                'slug' => 'real-estate-registration-guide',
                'excerpt' => 'خطوات عملية لتسجيل العقار واستخراج صك الملكية بأقل وقت وجهد.',
                'body' => '<p>تسجيل العقار خطوة أساسية لحماية حقوق الملكية. نقدّم في هذا المقال نظرة عملية على المستندات المطلوبة والمراحل الأساسية للإجراء.</p><h3>المستندات الأساسية</h3><ul><li>عقد الملكية أو مستند الحيازة</li><li>بطاقة الرقم القومي</li><li>إيصالات الرسوم المطلوبة</li></ul><p>فريق المواثيق يرافقكم من تجهيز الملف حتى استلام الصك.</p>',
                'sort_order' => 1,
            ],
            [
                'title' => 'كيف تستخرج رخصة بناء بدون تأخير؟',
                'slug' => 'building-permit-tips',
                'excerpt' => 'نصائح لتجنب الأخطاء الشائعة عند تقديم طلب رخصة البناء.',
                'body' => '<p>التأخير في رخص البناء غالباً ما يكون بسبب نقص أو تضارب في المستندات الفنية. التخطيط المسبق يقلّل زمن الإنجاز بشكل ملحوظ.</p><h3>نصائح سريعة</h3><ul><li>راجع الرسومات الهندسية قبل التقديم</li><li>تأكد من مطابقة البيانات مع عقد الملكية</li><li>تابع حالة الطلب بشكل دوري</li></ul>',
                'sort_order' => 2,
            ],
            [
                'title' => 'أهمية المسح والرفع المساحي قبل الشراء',
                'slug' => 'surveying-before-purchase',
                'excerpt' => 'لماذا يُعد الرفع المساحي خطوة ضرورية قبل إتمام صفقة عقارية؟',
                'body' => '<p>الرفع المساحي يحدد حدود العقار ومساحته بدقة، ويحميك من النزاعات المستقبلية حول الحدود أو التعديات.</p><p>ننصح بإجراء مسح معتمد قبل إتمام أي شراء أو تقسيم أو تسجيل.</p>',
                'sort_order' => 3,
            ],
        ];

        foreach ($posts as $post) {
            \App\Models\BlogPost::query()->updateOrCreate(
                ['slug' => $post['slug']],
                $post + [
                    'is_published' => true,
                    'published_at' => now()->subDays($post['sort_order']),
                ],
            );
        }
    }
}
