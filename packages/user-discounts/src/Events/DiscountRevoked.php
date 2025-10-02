<?php

namespace Acme\UserDiscounts\Events;

use Illuminate\Queue\SerializesModels;
use Acme\UserDiscounts\Models\Discount;
use App\Models\User;

class DiscountRevoked
{
    use SerializesModels;

    public function __construct(public User $user, public Discount $discount) {}
}
