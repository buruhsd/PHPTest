<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'creditcard_type',
        'creditcard_number',
        'creditcard_name',
        'creditcard_expired',
        'creditcard_cvv',
    ];
}
