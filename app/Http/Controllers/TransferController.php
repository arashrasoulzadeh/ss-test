<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Jobs\TransferJob;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function transfer(TransferRequest $request)
    {
        $result = dispatch_sync(
            new
                TransferJob(...$request->only(['source', 'destination', 'amount']))
        );
        return ['status' => $result];
    }
}
