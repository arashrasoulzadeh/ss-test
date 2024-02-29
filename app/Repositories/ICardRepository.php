<?php

namespace App\Repositories;

use App\Models\Card;

interface ICardRepository
{
    public function getCardByNumber(string $card_number): Card|null;
}
