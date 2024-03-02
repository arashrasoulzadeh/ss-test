<?php

namespace App\Jobs;

use App\Notifications\DepositNotification;
use App\Notifications\WithdrawalNotification;
use App\Repositories\ICardRepository;
use App\Repositories\ITransactionRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Throwable;

class TransferJob
{

    /**
     * Create a new job instance.
     */
    public function __construct(public string $source, public string $destination, public int $amount)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $cardRepository = app()->make(ICardRepository::class);
            $transactionRepository = app()->make(ITransactionRepository::class);
            $sourceCard = $cardRepository->getCardByNumber($this->source);
            $destCard = $cardRepository->getCardByNumber($this->destination);
            $transaction_fee = 500;
            if ((!is_null($sourceCard)) && (!is_null($destCard))) {
                $sourceAccount = $sourceCard->account;
                $destAccount = $destCard->account;
                //checking here to avoid duplicate query in validation
                if ($sourceAccount->id == $destAccount->id) {
                    $this->throwValidation('source', ['cant be same account with destination!']);
                }
                if ($sourceAccount->ballance < $this->amount + $transaction_fee) {
                    $this->throwValidation('source', ['Insufficient ballance!']);
                }
                $sourceAccount->lockForUpdate();
                $destAccount->lockForUpdate();
                $sourceAccount->ballance -= $this->amount;
                $destAccount->ballance += $this->amount;
                $sourceAccount->ballance -= $transaction_fee;
                $transaction = $transactionRepository->createTransaction($sourceCard->id, $destCard->id, $this->amount, $transaction_fee);
                $sourceAccount->save();
                $destAccount->save();
                DB::commit();
                FacadesNotification::send($sourceAccount->user()->first(), new WithdrawalNotification($transaction));
                FacadesNotification::send($destAccount->user()->first(), new DepositNotification($transaction));

                return 'done!';
            }
            throw new Exception("invalid cards!");
        } catch (Exception | Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function throwValidation(string $key, array $message)
    {
        $error = \Illuminate\Validation\ValidationException::withMessages([
            $key => $message,
        ]);
        throw $error;
    }
}
