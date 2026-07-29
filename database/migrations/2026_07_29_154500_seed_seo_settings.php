<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'seo_focus_keyword' => 'خدمات حكومية',
            'seo_meta_title' => 'المواثيق للخدمات الحكومية',
            'seo_meta_description' => 'ننجز معاملاتكم الحكومية باحترافية ودقة عالية: رفع مساحي، تراخيص، تسجيل عقاري، وموافقات رسمية.',
            'seo_meta_keywords' => 'خدمات حكومية, رفع مساحي, تراخيص بناء, شهر عقاري, موافقات عسكرية, الإسكندرية',
            'seo_canonical_url' => '',
            'seo_robots' => 'index,follow',
            'seo_author' => 'المواثيق للخدمات الحكومية',
            'seo_og_title' => 'المواثيق للخدمات الحكومية',
            'seo_og_description' => 'شريككم الموثوق لإنجاز معاملات الجهات الحكومية بكفاءة واحترافية.',
            'seo_og_image' => '',
            'seo_og_type' => 'website',
            'seo_og_site_name' => 'مواثيق',
            'seo_twitter_card' => 'summary_large_image',
            'seo_twitter_title' => '',
            'seo_twitter_description' => '',
            'seo_twitter_image' => '',
            'seo_google_verification' => '',
            'seo_bing_verification' => '',
            'seo_google_analytics_id' => '',
            'seo_google_tag_manager_id' => '',
            'seo_schema_org_name' => 'المواثيق للخدمات الحكومية',
            'seo_schema_org_logo' => '',
            'seo_schema_org_type' => 'ProfessionalService',
            'seo_robots_txt' => "User-agent: *\nAllow: /\nDisallow: /admin\nDisallow: /login\nDisallow: /register\n",
            'seo_noindex_site' => '0',
        ];

        foreach ($defaults as $key => $value) {
            if (blank(Setting::get($key))) {
                Setting::set($key, $value);
            }
        }
    }

    public function down(): void
    {
        // Keep SEO settings.
    }
};
