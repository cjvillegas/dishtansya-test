<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Mass assignable fields
     *
     * @var array
     */
    protected $fillable = [
        'product_id',
        'quantity',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
