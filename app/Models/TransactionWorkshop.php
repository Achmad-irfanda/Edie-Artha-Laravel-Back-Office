<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransactionWorkshop extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function mekanik()
    {
        return $this->belongsTo(Mekanik::class, 'mekanik_id', 'id');
    }


    protected $guarded = ['id'];
}
