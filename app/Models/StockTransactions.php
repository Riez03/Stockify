<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockTransactions extends Model
{
    use HasFactory;

    protected $table = 'stock_transcations';

    protected $fillable = [
        'product_id',
        'user_id',
        'type',
        'quantity',
        'date',
        'status',
        'notes',
    ];

    public function products() : BelongsTo {
        return $this->belongsTo(Products::class);
    }

    public function users() : BelongsTo {
        return $this->belongsTo(User::class);
    }
}
