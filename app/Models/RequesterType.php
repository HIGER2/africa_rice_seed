<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequesterType extends Model
{
    protected $fillable = ['label'];

    public function requesters()
    {
        return $this->hasMany(Requester::class);
    }
}
