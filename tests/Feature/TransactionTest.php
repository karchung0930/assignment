<?php

use App\Models\Category;
use App\Models\Corporate;
use App\Models\Role;
use App\Models\TransactionStatus;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function createMember(float $walletAmount): User
{
    Role::firstOrCreate(['name' => 'Member']);
    Role::firstOrCreate(['name' => 'HR']);

    $corporate = Corporate::create([
        'name'     => 'Test Corp',
        'country'  => 'MY',
        'currency' => 'MYR',
    ]);

    $member = User::factory()->member()->create([
        'corporate_id' => $corporate->id,
    ]);

    Wallet::create([
        'user_id'  => $member->id,
        'amount'   => $walletAmount,
        'currency' => 'MYR',
    ]);

    return $member->load(['wallet', 'corporate', 'role']);
}

it('rejects transaction when balance is insufficient', function () {
    $member   = createMember(walletAmount: 50);
    $category = Category::create([
        'name'          => 'GP',
        'fee_rate'      => 0.10,
        'fee_fixed'     => null,
        'fee_threshold' => null,
    ]);

    TransactionStatus::create(['name' => 'Completed']);

    $response = $this->actingAs($member)->post('/transaction/create', [
        'category' => $category->id,
        'cost'     => 100,
    ]);

    $response->assertSessionHasErrors('cost');
});

it('prevents member from accessing HR page', function () {
    Role::firstOrCreate(['name' => 'Member']);
    Role::firstOrCreate(['name' => 'HR']);

    $corporate = Corporate::create([
        'name'     => 'Test Corp',
        'country'  => 'MY',
        'currency' => 'MYR',
    ]);

    $member = User::factory()->member()->create([
        'corporate_id' => $corporate->id,
    ]);

    $this->actingAs($member)
        ->get('/members/list-spending')
        ->assertStatus(403);
});