<?php

namespace App\Repositories;

use App\Models\Card;

class CardRepository implements ICardRepository
{
    public function getCardByNumber(string $card_number): Card|null
    {
        return Card::where('number', $card_number)->first();
    }
}
