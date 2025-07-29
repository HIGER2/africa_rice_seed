<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'requester_id', 'seed_class','date','date_delivery', 'total_quantity', 'total_cost'
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
