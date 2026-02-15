<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BOM extends Model
{
    protected $table = 'b_o_m_s'; // Specific table name if needed based on migration
    protected $fillable = ['product_id', 'material_id', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function material()
    {
        return $this->belongsTo(Material::class);
    }
}
