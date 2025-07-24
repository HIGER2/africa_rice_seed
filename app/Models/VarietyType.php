<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VarietyType extends Model
{
     protected $fillable = ['name'];

    public function varieties()
    {
        return $this->hasMany(Variety::class);
    }
}
