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

        $values = [
            'address' => '٤١ شارع توت عنخ آمون، سموحة، عمارة الجوهرة، الإسكندرية',
            'address_en' => '41 Tutankhamun Street, Smouha, Al Jawhara Building, Alexandria',
            'map_query' => '41 Tutankhamun Street, Smouha, Al Jawhara Building, Alexandria',
        ];

        $now = now();

        foreach ($values as $key => $value) {
            $existing = DB::table('settings')->where('key', $key)->first();

            if ($existing) {
                DB::table('settings')->where('key', $key)->update([
                    'value' => $value,
                    'updated_at' => $now,
                ]);
            } else {
                DB::table('settings')->insert([
                    'key' => $key,
                    'value' => $value,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('settings')) {
            return;
        }

        $values = [
            'address' => '٩ شارع د. برجي، بجوار مستشفى الأهلي التخصصي، كفر عبدو، الإسكندرية',
            'address_en' => '9 Dr. Burji Street, next to Al Ahly Specialized Hospital, Kafr Abdo, Alexandria',
            'map_query' => '9 Dr. Burji Street, next to Al Ahly Specialized Hospital, Kafr Abdo, Alexandria',
        ];

        $now = now();

        foreach ($values as $key => $value) {
            DB::table('settings')->where('key', $key)->update([
                'value' => $value,
                'updated_at' => $now,
            ]);
        }
    }
};
