<?php

namespace app\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepository;
use Illuminate\Http\Request;
use PHPUnit\Framework\InvalidDataProviderException;

class TransactionsController extends Controller
{
    private $repository;

    public function __construct(TransactionRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function postTransaction(Request $request) 
    {        
     
        $this->validate($request, [
            'provider' => 'required|in:users,retailers',
            'payee_id' => 'required',
            'amount' => 'required|numeric'
        ]);
 
        $fields = $request->only(['provider', 'payee_id', 'amount']);
        
        try {
            $result = $this->repository->handle($fields);
            return response()->json($result);
        }  catch (InvalidDataProviderException $exception) {
            return response()->json(['errors' => ['main' => $exception->getMessage()]], 422);
        }

    }
}
