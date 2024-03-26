<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model {
    use HasFactory;
    protected $table = 'payment_record';
    protected $primaryKey = 'payment_id';
    public $timestamps = false;
    protected $fillable = [
        'credit',
        'debit',
        'date',
    ];
}
