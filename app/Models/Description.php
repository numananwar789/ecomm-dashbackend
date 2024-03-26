<?php

namespace App\Models;

use App\Models\Product;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Description extends Model {
    use HasFactory;
    protected $table = 'product_description';
    protected $primaryKey = 'description_id';
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'type',
        'quantity',
        'price',
    ];

    protected $with = ['products'];

    public function products() {
        return $this -> belongsTo( Product::class, 'product_id', 'product_id' );
    }
}
