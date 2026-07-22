<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        $services = [
            [
                'title' => 'الرفع المساحي (الخرائط)',
                'slug' => 'surveying-maps',
                'summary' => 'إعداد الخرائط المساحية وتحديد المواقع والمساحات بدقة عالية.',
                'description' => '<p>نقدّم خدمات الرفع المساحي وإعداد الخرائط لتحديد المواقع والمساحات وفق المعايير الفنية المعتمدة.</p>',
                'icon' => 'heroicon-o-map',
                'image' => 'image/services/surveying.jpg',
                'sort_order' => 1,
            ],
            [
                'title' => 'الرفع المساحي (الرقمي)',
                'slug' => 'surveying-digital',
                'summary' => 'رفع مساحي رقمي بأحدث التقنيات لبيانات دقيقة وقابلة للاستخدام.',
                'description' => '<p>نوفّر الرفع المساحي الرقمي باستخدام أحدث التقنيات لضمان دقة البيانات وسهولة استخدامها في الإجراءات الحكومية.</p>',
                'icon' => 'heroicon-o-cpu-chip',
                'image' => 'image/services/surveying.jpg',
                'sort_order' => 2,
            ],
            [
                'title' => 'تقنين أراضي وضع اليد',
                'slug' => 'land-legalization',
                'summary' => 'متابعة إجراءات تقنين أراضي وضع اليد واستكمال المتطلبات النظامية.',
                'description' => '<p>نساعدكم في إجراءات تقنين أراضي وضع اليد واستكمال المتطلبات والمستندات اللازمة أمام الجهات المختصة.</p>',
                'icon' => 'heroicon-o-map-pin',
                'image' => 'image/services/real-estate.jpg',
                'sort_order' => 3,
            ],
            [
                'title' => 'استخراج الموافقات العسكرية',
                'slug' => 'military-approvals',
                'summary' => 'استخراج الموافقات العسكرية المطلوبة للمعاملات والمشاريع.',
                'description' => '<p>ننجز إجراءات استخراج الموافقات العسكرية المرتبطة بالمعاملات والمشاريع وفق المسارات النظامية المعتمدة.</p>',
                'icon' => 'heroicon-o-shield-check',
                'image' => 'image/services/factory.jpg',
                'sort_order' => 4,
            ],
            [
                'title' => 'تسجيل الشهر العقاري',
                'slug' => 'real-estate-registration',
                'summary' => 'تسجيل العقارات في الشهر العقاري واستخراج الوثائق الرسمية.',
                'description' => '<p>نرافقكم في تسجيل العقارات بالشهر العقاري واستكمال الإجراءات حتى استخراج الوثائق الرسمية.</p>',
                'icon' => 'heroicon-o-home-modern',
                'image' => 'image/services/real-estate.jpg',
                'sort_order' => 5,
            ],
            [
                'title' => 'استخراج تراخيص البناء والهدم',
                'slug' => 'building-demolition-permits',
                'summary' => 'استخراج تراخيص البناء والهدم ومتابعة المتطلبات الفنية والإدارية.',
                'description' => '<p>ننهي إجراءات استخراج تراخيص البناء والهدم ونقدّم الدعم اللازم لاستيفاء المتطلبات الفنية والإدارية.</p>',
                'icon' => 'heroicon-o-building-office-2',
                'image' => 'image/services/building.jpg',
                'sort_order' => 6,
            ],
            [
                'title' => 'تراخيص المصانع والحلول المتكاملة القانونية للشركات',
                'slug' => 'factory-corporate-licenses',
                'summary' => 'تراخيص المصانع وحلول قانونية متكاملة للشركات والمنشآت.',
                'description' => '<p>نقدّم خدمات تراخيص المصانع والحلول القانونية المتكاملة للشركات بما يضمن الامتثال وسرعة الإنجاز.</p>',
                'icon' => 'heroicon-o-cog-6-tooth',
                'image' => 'image/services/factory.jpg',
                'sort_order' => 7,
            ],
            [
                'title' => 'تراخيص المحلات التجارية والخدمية',
                'slug' => 'commercial-service-licenses',
                'summary' => 'استخراج تراخيص المحلات التجارية والخدمية بسهولة ووضوح.',
                'description' => '<p>نسهّل استخراج تراخيص المحلات التجارية والخدمية واستكمال المتطلبات أمام الجهات المختصة.</p>',
                'icon' => 'heroicon-o-shopping-bag',
                'image' => 'image/services/commercial.jpg',
                'sort_order' => 8,
            ],
        ];

        $slugs = collect($services)->pluck('slug')->all();

        DB::table('services')->whereNotIn('slug', $slugs)->delete();

        $now = now();

        foreach ($services as $service) {
            $payload = $service + [
                'is_published' => true,
                'updated_at' => $now,
            ];

            $existing = DB::table('services')->where('slug', $service['slug'])->first();

            if ($existing) {
                DB::table('services')->where('id', $existing->id)->update($payload);
            } else {
                DB::table('services')->insert($payload + [
                    'created_at' => $now,
                ]);
            }
        }

        if (Schema::hasTable('settings')) {
            $instagram = 'https://www.instagram.com/almwatheeq?igsh=YnlpeTZ3M3I1OWto';
            $existingSetting = DB::table('settings')->where('key', 'instagram_url')->first();

            if ($existingSetting) {
                DB::table('settings')->where('key', 'instagram_url')->update([
                    'value' => $instagram,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('settings')->insert([
                    'key' => 'instagram_url',
                    'value' => $instagram,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        //
    }
};
