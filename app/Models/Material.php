<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    protected $fillable = ['name', 'code', 'unit', 'cost_per_unit'];

    public function boms()
    {
        return $this->hasMany(BOM::class);
    }
}
