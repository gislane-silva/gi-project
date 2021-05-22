<?php

namespace App\Models\Transactions;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'payer',
        'payee',
        'value',
    ];
}
