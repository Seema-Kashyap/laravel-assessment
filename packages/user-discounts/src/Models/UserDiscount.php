<?php

namespace Acme\UserDiscounts\Models;

use Illuminate\Database\Eloquent\Model;

class UserDiscount extends Model
{
    protected $fillable = ['user_id', 'discount_id', 'usage_count', 'usage_limit'];

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }
}
