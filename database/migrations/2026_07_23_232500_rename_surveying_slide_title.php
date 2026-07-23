<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('slides')) {
            return;
        }

        DB::table('slides')
            ->where('title', 'المسح والرفع المساحي')
            ->update([
                'title' => 'الرفع المساحي',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('slides')) {
            return;
        }

        DB::table('slides')
            ->where('title', 'الرفع المساحي')
            ->where('image', 'image/slides/hero-02.jpg')
            ->update([
                'title' => 'المسح والرفع المساحي',
                'updated_at' => now(),
            ]);
    }
};
