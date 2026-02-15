<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stakeholder extends Model
{
    protected $fillable = ['name', 'role', 'matrix_position'];

    public static function getMatrixPositions()
    {
        return [
            'Low Power - Low Interest' => 'Monitor (Minimum Effort)',
            'Low Power - High Interest' => 'Keep Informed',
            'High Power - Low Interest' => 'Keep Satisfied',
            'High Power - High Interest' => 'Manage Closely (Key Players)',
        ];
    }
}
