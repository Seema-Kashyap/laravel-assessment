<?php

namespace Acme\UserDiscounts\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use Acme\UserDiscounts\Models\{Discount, UserDiscount, DiscountAudit};
use Acme\UserDiscounts\Events\{DiscountAssigned, DiscountRevoked, DiscountApplied};

class DiscountService
{
    public function assign(User $user, Discount $discount)
    {
        return DB::transaction(function () use ($user, $discount) {
            $ud = UserDiscount::firstOrCreate([
                'user_id' => $user->id,
                'discount_id' => $discount->id,
            ]);

            DiscountAudit::create([
                'user_id' => $user->id,
                'discount_id' => $discount->id,
                'action' => 'assigned',
            ]);

            event(new DiscountAssigned($user, $discount));

            return $ud;
        });
    }

    public function revoke(User $user, Discount $discount)
    {
        UserDiscount::where('user_id', $user->id)
            ->where('discount_id', $discount->id)
            ->delete();

        DiscountAudit::create([
            'user_id' => $user->id,
            'discount_id' => $discount->id,
            'action' => 'revoked',
        ]);

        event(new DiscountRevoked($user, $discount));
    }

    public function apply(User $user, float $amount): float
    {
        $discounts = UserDiscount::where('user_id', $user->id)->with('discount')->get();
        $totalPercentage = 0;

        foreach ($discounts as $ud) {
            $d = $ud->discount;

            if (!$d->active || ($d->expires_at && $d->expires_at->isPast())) continue;
            if ($ud->usage_count >= $ud->usage_limit) continue;

            $apply = min($d->percentage, config('user-discounts.max_cap'));
            $totalPercentage += $apply;

            $ud->increment('usage_count');

            DiscountAudit::create([
                'user_id' => $user->id,
                'discount_id' => $d->id,
                'action' => 'applied',
            ]);

            event(new DiscountApplied($user, $d));
        }

        return round($amount - ($amount * $totalPercentage / 100), config('user-discounts.rounding'));
    }
}
