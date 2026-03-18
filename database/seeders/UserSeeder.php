<?php

namespace Database\Seeders;

use App\Models\Corporate;
use App\Models\Role;
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
        $corporateA = Corporate::where('name', 'Corporation A')->first();
        $corporateB = Corporate::where('name', 'Corporation B')->first();
        $hrRole     = Role::where('name', 'HR')->first();
        $memberRole = Role::where('name', 'Member')->first();

        collect([
            ['name' => 'HR A', 'email' => 'hr_a@example.com'],
        ])->each(fn($data) => User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make('password'),
            'role_id'      => $hrRole->id,
            'corporate_id' => $corporateA->id,
        ]));

        collect([
            ['name' => 'Member A', 'email' => 'member_a@example.com'],
            ['name' => 'Member B', 'email' => 'member_b@example.com'],
        ])->each(fn($data) => User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make('password'),
            'role_id'      => $memberRole->id,
            'corporate_id' => $corporateA->id,
        ]));

        collect([
            ['name' => 'HR B', 'email' => 'hr_b@example.com'],
        ])->each(fn($data) => User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make('password'),
            'role_id'      => $hrRole->id,
            'corporate_id' => $corporateB->id,
        ]));

        collect([
            ['name' => 'Member C', 'email' => 'member_c@example.com'],
            ['name' => 'Member D', 'email' => 'member_d@example.com'],
        ])->each(fn($data) => User::create([
            'name'         => $data['name'],
            'email'        => $data['email'],
            'password'     => Hash::make('password'),
            'role_id'      => $memberRole->id,
            'corporate_id' => $corporateB->id,
        ]));
    }
}
