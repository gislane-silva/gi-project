<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UserCreateRequest;
use App\Repositories\Users\UserRepository;
use Exception;

class UserController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
       $this->userRepository = $userRepository;
    }

    /**
     * @param UserCreateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserCreateRequest $request)
    {
        try {
            $data = $request->validated();

            $result = $this->userRepository->create($data);
            if ($result === true) {
                return response()->json(['message' => 'Usuário criado com sucesso'], 200);
            }

            return response()->json(['message' => $result], 400);

        } catch (Exception $ex) {
            return response()->json(['message' => $ex->getMessage()], 500);
        }
    }
}
