<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\Criterion;
use App\Models\Alternative;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin',
            'email' => 'admin@kontess.test',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Juri Users
        User::create([
            'name' => 'Juri 1',
            'email' => 'juri1@kontess.test',
            'password' => Hash::make('password'),
            'role' => 'juri',
        ]);

        User::create([
            'name' => 'Juri 2',
            'email' => 'juri2@kontess.test',
            'password' => Hash::make('password'),
            'role' => 'juri',
        ]);

        User::create([
            'name' => 'Juri 3',
            'email' => 'juri3@kontess.test',
            'password' => Hash::make('password'),
            'role' => 'juri',
        ]);

        // Create Sample Categories
        $category1 = Category::create([
            'name' => 'Penampilan Fisik',
            'description' => 'Kriteria penilaian berdasarkan penampilan fisik unggas',
        ]);

        $category2 = Category::create([
            'name' => 'Kesehatan',
            'description' => 'Kriteria penilaian berdasarkan kondisi kesehatan unggas',
        ]);

        // Create Sample Criteria
        Criterion::create([
            'category_id' => $category1->id,
            'name' => 'Bentuk Tubuh',
            'description' => 'Penilaian bentuk tubuh unggas',
            'weight' => 25.00,
            'type' => 'benefit',
        ]);

        Criterion::create([
            'category_id' => $category1->id,
            'name' => 'Warna Bulu',
            'description' => 'Penilaian warna dan kualitas bulu',
            'weight' => 20.00,
            'type' => 'benefit',
        ]);

        Criterion::create([
            'category_id' => $category2->id,
            'name' => 'Kondisi Kesehatan',
            'description' => 'Penilaian kondisi kesehatan umum',
            'weight' => 30.00,
            'type' => 'benefit',
        ]);

        Criterion::create([
            'category_id' => $category2->id,
            'name' => 'Aktivitas',
            'description' => 'Penilaian tingkat aktivitas unggas',
            'weight' => 25.00,
            'type' => 'benefit',
        ]);

        // Create Sample Alternatives
        Alternative::create([
            'name' => 'Unggas A',
            'code' => 'UGA001',
            'description' => 'Alternatif unggas pertama',
        ]);

        Alternative::create([
            'name' => 'Unggas B',
            'code' => 'UGB002',
            'description' => 'Alternatif unggas kedua',
        ]);

        Alternative::create([
            'name' => 'Unggas C',
            'code' => 'UGC003',
            'description' => 'Alternatif unggas ketiga',
        ]);
    }
}
