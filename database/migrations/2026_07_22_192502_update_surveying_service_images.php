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

        DB::table('services')->where('slug', 'surveying-maps')->update([
            'image' => 'image/012.jpeg',
            'updated_at' => now(),
        ]);

        DB::table('services')->where('slug', 'surveying-digital')->update([
            'image' => 'image/01012.jpeg',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        DB::table('services')->where('slug', 'surveying-maps')->update([
            'image' => 'image/services/surveying.jpg',
            'updated_at' => now(),
        ]);

        DB::table('services')->where('slug', 'surveying-digital')->update([
            'image' => 'image/services/surveying.jpg',
            'updated_at' => now(),
        ]);
    }
};
