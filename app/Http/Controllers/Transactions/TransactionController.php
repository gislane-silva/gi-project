<?php

namespace App\Http\Controllers\Transactions;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transactions\TransactionCreateRequest;
use App\Models\User;
use App\Repositories\Transactions\TransactionRepository;
use Exception;

class TransactionController extends Controller
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var TransactionRepository
     */
    private $transactionRepository;

    /**
     * TransactionController constructor.
     * @param User $user
     * @param TransactionRepository $transactionRepository
     */
    public function __construct(User $user, TransactionRepository $transactionRepository)
    {
        $this->user                  = $user;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * @param TransactionCreateRequest $request
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function store(TransactionCreateRequest $request)
    {
        try {
            $data = $request->validated();
            $payerId = $data['payer'];

            // Verifica se é pagador do tipo lojista
            if ($this->user->isShopkeeper($payerId)) {

                return response()->json(['message' => 'Lojistas não podem realizar transferências'], 400);
            }

            $result = $this->transactionRepository->create($data);
            if ($result === true) {

                return response()->json(['message' => 'Transferência realizada com sucesso'], 200);
            }

            return response()->json(['message' => $result], 400);
        } catch (Exception $ex) {

            return response()->json(['message' => 'Ocorreu um erro ao tentar realizar a transferência'], 500);
        }
    }
}
