<?php

namespace App\Repositories\Wallets;

use App\Models\Wallets\Wallet;

class WalletRepository
{
    /**
     * @var Wallet
     */
    private $wallet;

    /**
     * WalletRepository constructor.
     * @param Wallet $wallet
     */
    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
    }

    /**
     * @param $userId
     * @param $value
     * @param $action
     * @return bool
     */
    public function updateAmount($userId, $value, $action)
    {
        $wallet = $this->wallet->query()->where('user_id', $userId)->first();

        // Preventiva para certificar que o usuário tenha uma carteira criada
        if (!$wallet) {
            $wallet = $this->wallet->query()->create([
                                               'user_id' => $userId,
                                           ]);
        }

        $amount = $wallet->amount;
        if ($action == 'subtract') {
            $amountUpdated = doubleval($amount - $value);
        } else if ($action == 'add') {
            $amountUpdated = doubleval($amount + $value);
        }

        if ($wallet->update(['amount' => $amountUpdated ?? $amount])) {
            return true;
        }

        return false;
    }
}
