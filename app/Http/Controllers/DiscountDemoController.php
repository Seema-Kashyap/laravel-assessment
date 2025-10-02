<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Acme\UserDiscounts\Models\Discount;
use Acme\UserDiscounts\Services\DiscountService;

class DiscountDemoController extends Controller
{
    public function assignDiscount(Request $request, DiscountService $service)
    {
        $user = User::findOrFail($request->input('user_id'));
        $discount = Discount::findOrFail($request->input('discount_id'));

        $service->assign($user, $discount);

        return response()->json(['message' => 'Discount assigned successfully']);
    }

    public function revokeDiscount(Request $request, DiscountService $service)
    {
        $user = User::findOrFail($request->input('user_id'));
        $discount = Discount::findOrFail($request->input('discount_id'));

        $service->revoke($user, $discount);

        return response()->json(['message' => 'Discount revoked successfully']);
    }

    public function applyDiscount(Request $request, DiscountService $service)
    {
        $user = User::findOrFail($request->input('user_id'));
        $amount = $request->input('amount', 1000);

        $finalAmount = $service->apply($user, $amount);

        return response()->json([
            'original_amount' => $amount,
            'final_amount' => $finalAmount
        ]);
    }
}
