<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WBSNode extends Model
{
    protected $fillable = ['product_id', 'name', 'description', 'parent_id', 'cost_estimate'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function parent()
    {
        return $this->belongsTo(WBSNode::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(WBSNode::class, 'parent_id');
    }
}
