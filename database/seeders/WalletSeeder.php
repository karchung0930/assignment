<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $amounts = [
            'hr_a@example.com'     => 0.00,
            'hr_b@example.com'     => 0.00,
            'member_a@example.com' => 8500.00,
            'member_b@example.com' => 3200.00,
            'member_c@example.com' => 12000.00,
            'member_d@example.com' => 650.00,
        ];

        User::with('corporate')->get()->each(fn($user) => Wallet::create([
            'user_id'  => $user->id,
            'amount'   => $amounts[$user->email] ?? 0.00,
            'currency' => $user->corporate->currency,
        ]));
    }
}
