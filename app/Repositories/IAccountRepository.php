<?php

namespace App\Repositories;

use App\Models\Account;

interface IAccountRepository
{
    public function getAccountBycardNumber(string $card_number): Account|null;
}
