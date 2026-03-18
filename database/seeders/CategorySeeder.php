<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create([
            'name' => 'GP',
            'fee_rate' => 0.10,
            'fee_fixed' => null,
            'fee_threshold' => null,
        ]);

        Category::create([
            'name' => 'Specialist',
            'fee_rate' => 0.15,
            'fee_fixed' => 100.00,
            'fee_threshold' => 1000.00,
        ]);
    }
}
