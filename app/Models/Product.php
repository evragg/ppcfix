<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'code', 'description', 'system_type', 'concept_image'];

    public function wbsNodes()
    {
        return $this->hasMany(WBSNode::class);
    }
}
