<?php

use App\Models\Category;

it('charges flat fee when cost exceeds threshold', function () {
    $category = new Category([
        'fee_rate'      => 0.05,
        'fee_fixed'     => 50,
        'fee_threshold' => 1000,
    ]);

    expect($category->calculateFee(1500))->toBe(50.0);
});

it('charges percentage fee when cost is below threshold', function () {
    $category = new Category([
        'fee_rate'      => 0.05,
        'fee_fixed'     => 50,
        'fee_threshold' => 1000,
    ]);

    expect($category->calculateFee(200))->toBe(10.0);
});

it('always charges percentage when threshold is null', function () {
    $category = new Category([
        'fee_rate'      => 0.05,
        'fee_fixed'     => 50,
        'fee_threshold' => null,
    ]);

    expect($category->calculateFee(9999))->toBe(499.95);
});

it('charges percentage when cost equals threshold exactly', function () {
    $category = new Category([
        'fee_rate'      => 0.05,
        'fee_fixed'     => 50,
        'fee_threshold' => 1000,
    ]);

    expect($category->calculateFee(1000))->toBe(50.0);
});