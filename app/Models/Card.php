<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['number'];
    protected $with = ['account'];

    public function account()
    {
        return $this->hasOne(Account::class, 'id', 'account_id');
    }
}
