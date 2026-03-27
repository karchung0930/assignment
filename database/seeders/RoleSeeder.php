<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['Member', 'HR'])->each(
            fn($role) => Role::create(['name' => $role])
        );

        // php artisan db:seed --class=RoleSeeder

        // Role::firstOrCreate(['name' => 'Member']);
        // Role::firstOrCreate(['name' => 'HR']);
        // Role::firstOrCreate(['name' => 'Admin']);
    }
}
