<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Repositories\ITransactionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct(public ITransactionRepository $transactionRepository)
    {
    }
    public function latest()
    {
        $users =  $this->transactionRepository->top3Users(10);
        return array_map(function ($user) {
            $transactions = $this->transactionRepository->getTransactionsByUserId($user->uid, 10);
            return [
                'name' => $user->name,
                'email' => $user->email,
                'total' => $user->t,
                'last_10_transactions' => $transactions
            ];
        }, $users->toArray());
    }
}
