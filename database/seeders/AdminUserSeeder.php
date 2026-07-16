<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::query()
            ->whereIn('email', ['admin@mwatheeq.com', 'admin@mwatheeq.test'])
            ->first();

        if ($admin) {
            $admin->update([
                'name' => 'مدير النظام',
                'email' => 'admin@mwatheeq.com',
                'password' => Hash::make('password'),
                'is_admin' => true,
            ]);

            return;
        }

        User::query()->create([
            'name' => 'مدير النظام',
            'email' => 'admin@mwatheeq.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
        ]);
    }
}
