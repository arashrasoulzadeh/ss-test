<?php

namespace App\Repositories;

use App\Models\Transaction;

interface ITransactionRepository
{
    public function createTransaction(int $source_id, int $dest_id, int $amount, int $fee): Transaction;
    public function top3Users(int $minute);

    public function getTransactionsByUserId(int $user_id, int $time_limit);
}
