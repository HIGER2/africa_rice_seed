<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id', 'variety_id', 'quantity', 
        'cost_per_kg', 'subtotal','requester_id','name'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function variety()
    {
        return $this->belongsTo(Variety::class);
    }
}
