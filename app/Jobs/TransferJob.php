<?php

namespace App\Jobs;

use App\Repositories\IAccountRepository;
use App\Repositories\ICardRepository;
use App\Repositories\ITransactionRepository;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException as ValidationValidationException;
use PhpParser\Node\Expr\Throw_;
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
            $transaction_fee = 2;
            if ((!is_null($sourceCard)) && (!is_null($destCard))) {
                $sourceAccount = $sourceCard->account;
                $destAccount = $destCard->account;
                //checking here to avoid duplicate query in validation
                if ($sourceAccount->id == $destAccount->id) {
                    $this->throwValidation('source', ['cant be same account with destination!']);
                }
                if ($sourceAccount->ballance < $this->amount + $transaction_fee) {
                    $this->throwValidation('source', ['Insufficent ballance!']);
                }
                $sourceAccount->lockForUpdate();
                $destAccount->lockForUpdate();
                $sourceAccount->ballance -= $this->amount;
                $destAccount->ballance += $this->amount;
                $sourceAccount->ballance -= $transaction_fee;
                $transactionRepository->createTransaction($sourceCard->id, $destCard->id, $this->amount, $transaction_fee);
                $sourceAccount->save();
                $destAccount->save();
            }
            DB::commit();
            return 'done!';
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
