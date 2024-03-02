<?php

namespace App\Repositories;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
    public function top3Users(int $minute)
    {
        $now = Carbon::now();
        $minutesAgo = $now->subMinutes($minute);

        $userIds = DB::table(function ($query) use ($minutesAgo) {
            $query->select('uid', 'name', 'email', DB::raw('count(*) as t'))
                ->from(function ($query) {
                    $query->select('name', 'email', 'users.id as uid', 'accounts.id as aid')
                        ->from('users')
                        ->join('accounts', 'accounts.user_id', '=', 'users.id')
                        ->join('cards', 'cards.account_id', '=', 'accounts.id')
                        ->select('name', 'email', 'users.id as uid', 'accounts.id as aid', 'cards.id as cid', 'number');
                }, 'ac')
                ->join('transactions', function ($join) use ($minutesAgo) {
                    $join->on('transactions.source_card_id', '=', 'ac.cid')
                        ->orWhere(function ($query) use ($minutesAgo) {
                            $query->on('transactions.dest_card_id', '=', 'ac.cid');
                        })
                        ->where('transactions.created_at', '>=', $minutesAgo);
                })
                ->groupBy('uid')
                ->orderByDesc('t')
                ->limit(3);
        }, 'acu')->get();
        return $userIds;
    }

    public function getTransactionsByUserId(int $user_id, int $time_limit)
    {
        $tenMinutesAgo = Carbon::now()->subMinutes(10);
        $transactions = Transaction::join('cards as c', function ($join) {
            $join->join('accounts as a', 'a.id', '=', 'c.account_id')
                ->join('users as u', 'u.id', '=', 'a.user_id');
        })
            ->join('transactions as t', function ($join) use ($tenMinutesAgo) {
                $join->on('t.source_card_id', '=', 'c.id')
                    ->orWhere('t.dest_card_id', '=', 'c.id')
                    ->where('t.created_at', '>=', $tenMinutesAgo);
            })
            ->select('t.*')
            ->limit(10)
            ->orderBy('t.id', 'desc')
            ->with(['source', 'dest'])
            ->get();
        return $transactions;
    }
}
