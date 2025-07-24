<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variety extends Model
{
    protected $fillable = ['name', 'variety_type_id'];

    public function varietyType()
    {
        return $this->belongsTo(VarietyType::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
