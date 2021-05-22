<?php

namespace App\Repositories\Users;

use App\Models\User;
use App\Models\Wallets\Wallet;
use Exception;
use Illuminate\Support\Facades\DB;

class UserRepository
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param $data
     * @return bool|string
     */
    public function create($data)
    {
        DB::beginTransaction();
        try {

            // Verifica se já existe algum usuário com o cpf_cnpj informado
            if ($this->findUserByCpfCnpj($data['cpf_cnpj'])) {
                return 'Já existe um usuário com o CPF/CNPJ informado';
            }

            // Verifica se já existe algum usuário com o cpf_cnpj informado
            if ($this->findUserByEmail($data['email'])) {
                return 'Já existe um usuário com o e-mail informado';
            }

            // Cria o usuário
            $user = $this->user->query()->create($data);

            if ($user) {
                // Se houver sucesso ao criar o usuário, cria a carteira do usuário
                $wallet = app()->make(Wallet::class);
                $result = $wallet->query()->create([
                                                       'user_id' => $user->id,
                                                   ]);

                if ($result) {

                    DB::commit();
                    return true;
                }
            }

            throw new Exception('Ocorreu um erro ao tentar criar o usuário');
        } catch (Exception $ex) {

            DB::rollBack();
            return 'Ocorreu um erro ao tentar criar o usuário';
        }
    }

    /**
     * @param $cpfCnpj
     * @return false|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findUserByCpfCnpj($cpfCnpj)
    {
        $cpfCnpj = preg_replace('/[^0-9]/', '', $cpfCnpj);
        $user    = $this->user->query()->where('cpf_cnpj', $cpfCnpj)->first();

        if ($user) {
            return $user;
        }

        return false;
    }

    /**
     * @param $email
     * @return false|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object
     */
    public function findUserByEmail($email)
    {
        $user = $this->user->query()->where('email', $email)->first();

        if ($user) {
            return $user;
        }

        return false;
    }
}
