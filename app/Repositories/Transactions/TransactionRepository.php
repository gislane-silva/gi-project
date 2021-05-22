<?php

namespace App\Repositories\Transactions;

use App\Models\Transactions\Transaction;
use App\Models\Wallets\Wallet;
use App\Repositories\Wallets\WalletRepository;
use App\Services\Transactions\TransactionService;
use Exception;
use Illuminate\Support\Facades\DB;

class TransactionRepository
{
    /**
     * @var Transaction
     */
    private $transaction;
    /**
     * @var Wallet
     */
    private $wallet;
    /**
     * @var WalletRepository
     */
    private $walletRepository;
    /**
     * @var TransactionService
     */
    private $transactionService;

    /**
     * TransactionRepository constructor.
     * @param Transaction $transaction
     * @param Wallet $wallet
     * @param WalletRepository $walletRepository
     * @param TransactionService $transactionService
     */
    public function __construct(Transaction $transaction, Wallet $wallet, WalletRepository $walletRepository, TransactionService $transactionService)
    {
        $this->transaction        = $transaction;
        $this->wallet             = $wallet;
        $this->walletRepository   = $walletRepository;
        $this->transactionService = $transactionService;
    }

    /**
     * @param $data
     * @return bool|string
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {
            $response = $this->verifyCanCreate($data);
            if ($response === true) {
                $payerId = $data['payer'];
                $payeeId = $data['payee'];
                $value   = $data['value'];

                // Cria a transação
                $this->transaction->query()->create($data);

                // Atualiza o saldo na carteira do pagador
                $this->walletRepository->updateAmount($payerId, $value, 'subtract');

                // Atualiza o saldo na carteira do beneficiário
                $this->walletRepository->updateAmount($payeeId, $value, 'add');

                // Verifica a resposta do serviço autorizador externo
                if (!$this->transactionService->transactionIsAuthorized()) {
                    DB::rollBack();
                    return 'Transferência não autorizada pelo serviço externo';
                }

                DB::commit();
                return true;
            }

            return $response;
        } catch (Exception $ex) {
            DB::rollBack();
            return 'Ocorreu um erro ao tentar realizar a transferência';
        }
    }

    /**
     * @param $data
     * @return bool
     */
    public function verifyCanCreate($data)
    {
        $userId            = $data['payer'];
        $transactionAmount = $data['value'];

        $error = false;

        // Verifica se o saldo do usuário é insuficiente
        if (!$this->wallet->hasBalance($userId, $transactionAmount)) {
            $error = 'Saldo insuficiente';
        }

        // Verifica se a transferência está sendo para si mesmo
        if ($data['payer'] === $data['payee']) {
            $error = 'Não é possível realizar transferência para si mesmo';
        }

        // Se não houver erro retorna true
        if ($error === false) {
            return true;
        }

        return $error;
    }
}
