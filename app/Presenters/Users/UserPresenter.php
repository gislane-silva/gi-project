<?php

namespace App\Presenters\Users;

use Laracasts\Presenter\Presenter;

class UserPresenter extends Presenter
{
    private $user_type_enum = [
        1 => 'user', // usuário
        2 => 'shopkeeper', // lojista
    ];

    public function getUserTypeEnum($value)
    {
        if (is_numeric($value)) {
            return $this->user_type_enum[$value];
        }

        return array_search($value, $this->user_type_enum);
    }
}
