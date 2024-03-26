<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model {
    use HasFactory;
    protected $table = 'stock';
    protected $primaryKey = 'stock_id';
    public $timestamps = false;
    protected $fillable = [
        'stock_received',
        'stock_returned',
        'stock_in_hand',
        'stock_price',
        'stock_price',
        'date',
    ];
}
