<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'requester_id', 'seed_class', 'total_quantity', 'total_cost_usd'
    ];

    public function requester()
    {
        return $this->belongsTo(Requester::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
