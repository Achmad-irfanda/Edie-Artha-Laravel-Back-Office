<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionProduct extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function items()
    {
        return $this->hasMany(TransactionProductItem::class, 'transaction_product_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_id', 'id');
    }
}
