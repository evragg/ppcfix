<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductionSchedule extends Model
{
    protected $fillable = ['product_id', 'activity_name', 'start_date', 'end_date', 'status', 'is_critical_path'];

    protected $casts = [
        'is_critical_path' => 'boolean',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
