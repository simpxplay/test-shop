<?php

namespace App\Models;

use App\Traits\ProductRelationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use ProductRelationTrait;

    protected $fillable = [
        'name',
        'price'
    ];
}
