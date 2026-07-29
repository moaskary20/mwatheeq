<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        $defaults = [
            'seo_google_tag_id' => '',
            'seo_google_ads_id' => '',
            'seo_facebook_pixel_id' => '',
            'seo_facebook_domain_verification' => '',
            'seo_yandex_verification' => '',
            'seo_schema_phone' => '',
            'seo_schema_email' => '',
            'seo_schema_address' => '',
            'seo_schema_city' => 'الإسكندرية',
            'seo_schema_region' => 'الإسكندرية',
            'seo_schema_postal_code' => '',
            'seo_schema_country' => 'EG',
            'seo_schema_lat' => '',
            'seo_schema_lng' => '',
            'seo_schema_same_as' => '',
            'seo_hreflang_ar' => '',
            'seo_hreflang_en' => '',
            'seo_hreflang_x_default' => '',
            'seo_sitemap_url' => '',
            'seo_theme_color' => '#3154ad',
            'seo_custom_head' => '',
        ];

        foreach ($defaults as $key => $value) {
            if (blank(Setting::get($key))) {
                Setting::set($key, $value);
            }
        }

        $robots = Setting::get('seo_robots_txt');
        if (filled($robots) && ! str_contains($robots, 'Sitemap:')) {
            Setting::set('seo_robots_txt', rtrim($robots)."\nSitemap: ".url('/sitemap.xml')."\n");
        }
    }

    public function down(): void
    {
        // Keep settings.
    }
};
