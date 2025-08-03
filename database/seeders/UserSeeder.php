<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Superadmin
        User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@sirintik.test',
            'password' => Hash::make('password'),
            'role' => 'superadmin',
            'is_active' => true,
        ]);

        // Create Admin Bidang
        User::create([
            'name' => 'Admin Bidang Tanaman Pangan',
            'email' => 'admin.pangan@sirintik.test',
            'password' => Hash::make('password'),
            'role' => 'admin_bidang',
            'bidang' => 'Tanaman Pangan',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Admin Bidang Hortikultura',
            'email' => 'admin.horti@sirintik.test',
            'password' => Hash::make('password'),
            'role' => 'admin_bidang',
            'bidang' => 'Hortikultura',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Admin Bidang Perkebunan',
            'email' => 'admin.kebun@sirintik.test',
            'password' => Hash::make('password'),
            'role' => 'admin_bidang',
            'bidang' => 'Perkebunan',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Admin Bidang Peternakan',
            'email' => 'admin.ternak@sirintik.test',
            'password' => Hash::make('password'),
            'role' => 'admin_bidang',
            'bidang' => 'Peternakan',
            'is_active' => true,
        ]);

        // Create Admin Kecamatan
        $districts = [
            'Bandung Utara', 'Bandung Selatan', 'Cimahi', 'Sumedang', 'Garut',
            'Tasikmalaya', 'Ciamis', 'Banjar', 'Pangandaran', 'Cianjur'
        ];

        foreach ($districts as $district) {
            User::create([
                'name' => "Admin Kecamatan {$district}",
                'email' => strtolower(str_replace(' ', '.', $district)) . '@sirintik.test',
                'password' => Hash::make('password'),
                'role' => 'admin_kecamatan',
                'district' => $district,
                'is_active' => true,
            ]);
        }
    }
}