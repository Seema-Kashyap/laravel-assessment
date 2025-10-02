<?php

namespace Acme\UserDiscounts\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = ['name', 'percentage', 'active', 'expires_at'];
    protected $casts = ['active' => 'boolean', 'expires_at' => 'datetime'];
}
