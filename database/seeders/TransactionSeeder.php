<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Corporate;
use App\Models\Role;
use App\Models\Transaction;
use App\Models\TransactionStatus;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $corporate  = Corporate::first();
        $completed  = TransactionStatus::where('name', 'Completed')->first();
        $memberRole = Role::where('name', 'Member')->first();
        $gp         = Category::where('name', 'GP')->first();
        $specialist = Category::where('name', 'Specialist')->first();
        $members    = User::where('role_id', $memberRole->id)->get();

        $samples = [
            ['category' => $gp, 'cost' => 200.00],
            ['category' => $gp, 'cost' => 500.00],
            ['category' => $specialist, 'cost' => 800.00],
            ['category' => $specialist, 'cost' => 1500.00],
        ];

        foreach ($members as $member) {
            foreach ($samples as $sample) {
                $category = $sample['category'];
                $cost     = $sample['cost'];
                $fee      = $category->calculateFee($cost);
                $total    = $cost + $fee;

                $wallet = Wallet::where('user_id', $member->id)->first();

                if ($wallet->amount < $total) {
                    continue;
                }

                Transaction::create([
                    'corporate_id'          => $corporate->id,
                    'user_id'               => $member->id,
                    'category_id'           => $category->id,
                    'transaction_status_id' => $completed->id,
                    'cost'                  => $cost,
                    'transaction_fee'       => $fee,
                    'currency'              => $corporate->currency,
                ]);

                $wallet->decrement('amount', $total);
            }
        }
    }
}
