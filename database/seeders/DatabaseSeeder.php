<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            TransactionStatusSeeder::class,
            CorporateSeeder::class,
            UserSeeder::class,
            WalletSeeder::class,
            CategorySeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
