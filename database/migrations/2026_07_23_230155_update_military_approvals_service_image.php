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

        DB::table('services')->where('slug', 'military-approvals')->update([
            'image' => 'image/0002.jpeg',
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        if (! Schema::hasTable('services')) {
            return;
        }

        DB::table('services')->where('slug', 'military-approvals')->update([
            'image' => 'image/services/factory.jpg',
            'updated_at' => now(),
        ]);
    }
};
