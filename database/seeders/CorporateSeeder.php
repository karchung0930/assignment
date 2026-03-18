<?php

namespace Database\Seeders;

use App\Models\Corporate;
use Illuminate\Database\Seeder;

class CorporateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = ['Corporation A', 'Corporation B'];

        foreach ($names as $name) {
            Corporate::create([
                'name'     => $name,
                'country'  => 'MY',
                'currency' => 'MYR',
            ]);
        }
    }
}
