<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'title',
        'description',
        'price',
        'category',
        'image',
        'latitude',
        'longitude',
        'seller_id',
        'created_at'
    ];

    protected $useTimestamps = false;
}