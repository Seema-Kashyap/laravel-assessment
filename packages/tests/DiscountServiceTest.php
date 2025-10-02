<?php

namespace Acme\UserDiscounts\Tests;

use Tests\TestCase;
use App\Models\User;
use Acme\UserDiscounts\Models\Discount;
use Acme\UserDiscounts\Services\DiscountService;

class DiscountServiceTest extends TestCase
{
    public function test_discount_application_with_cap()
    {
        $user = User::factory()->create();
        $discount = Discount::create(['name' => 'Test', 'percentage' => 60, 'active' => true]);

        $service = new DiscountService();
        $service->assign($user, $discount);

        $finalAmount = $service->apply($user, 1000);

        $this->assertEquals(500, $finalAmount); // capped at 50%
    }
}
