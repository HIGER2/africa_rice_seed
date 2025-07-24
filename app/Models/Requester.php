<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Requester extends Model
{
    use Notifiable;

    protected $fillable = [
        'full_name', 'phone', 'email', 'address', 
        'requester_type_id', 'custom_requester_type'
    ];

    public function requesterType()
    {
        return $this->belongsTo(RequesterType::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
