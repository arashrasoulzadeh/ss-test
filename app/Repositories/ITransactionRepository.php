<?php

namespace App\Repositories;

use App\Models\Transaction;

interface ITransactionRepository
{
    public function createTransaction(int $source_id, int $dest_id, int $amount, int $fee): Transaction;
}
