<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentProduct extends Model
{
    /** @use HasFactory<\Database\Factories\EloquentProductFactory> */
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity'
    ];
}
