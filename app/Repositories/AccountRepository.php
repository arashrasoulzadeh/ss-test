<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository implements IAccountRepository
{
    public function getAccountBycardNumber(string $card_number): Account|null
    {
        $account = Account::whereHas('cards', function ($q) use ($card_number) {
            $q->where('number', $card_number);
        })->first();
        if (!is_null($account)) {
            return $account;
        }
        return null;
    }
}
