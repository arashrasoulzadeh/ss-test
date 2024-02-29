<?php

namespace App\Repositories;

use App\Models\Transaction;

class TransactionRepository implements ITransactionRepository
{
    public function createTransaction(int $source_id, int $dest_id, int $amount, int $fee): Transaction
    {
        return Transaction::create([
            'source_card_id' => $source_id,
            'dest_card_id' => $dest_id,
            'amount' => $amount,
            'fee' => $fee
        ]);
    }
}
