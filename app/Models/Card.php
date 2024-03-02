<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['number'];
    protected $hidden = ['deleted_at', 'updated_at', 'id', 'account_id', 'created_at'];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }
}
