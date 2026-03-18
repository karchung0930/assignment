<?php

namespace Database\Seeders;

use App\Models\TransactionStatus;
use Illuminate\Database\Seeder;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect(['Pending', 'Completed', 'Failed'])->each(
            fn($status) => TransactionStatus::create(['name' => $status])
        );
    }
}
