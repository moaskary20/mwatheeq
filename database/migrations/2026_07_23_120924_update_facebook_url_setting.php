<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $facebookUrl = 'https://www.facebook.com/share/1EF78b1EHW/';
        $now = now();
        $existing = DB::table('settings')->where('key', 'facebook_url')->first();

        if ($existing) {
            DB::table('settings')->where('key', 'facebook_url')->update([
                'value' => $facebookUrl,
                'updated_at' => $now,
            ]);
        } else {
            DB::table('settings')->insert([
                'key' => 'facebook_url',
                'value' => $facebookUrl,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        DB::table('settings')->where('key', 'facebook_url')->update([
            'value' => 'https://www.facebook.com/Elmawatheq',
            'updated_at' => now(),
        ]);
    }
};
