<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = ['source_card_id', 'dest_card_id', 'amount', 'fee'];
    protected $hidden = ['dest_card_id', 'source_card_id', 'updated_at'];

    public function source()
    {
        return $this->belongsTo(Card::class, 'source_card_id', 'id');
    }
    public function dest()
    {
        return $this->belongsTo(Card::class, 'dest_card_id', 'id');
    }
}
