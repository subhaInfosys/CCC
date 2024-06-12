<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'product_master_lists';
    protected $primaryKey = 'ProductID';

    protected $fillable = [
        'Types',
        'Brand',
        'Model',
        'Capacity',
        'Quantity',
        'created_at',
        'updated_at'
    ];
}
