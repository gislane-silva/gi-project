<?php

namespace App\Models\Wallets;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'user_id',
        'amount',
    ];

    /**
     * @param $userId
     * @param $value
     * @return bool
     */
    public function hasBalance($userId, $value)
    {
        $amount = $this->query()->where('user_id', $userId)->value('amount');
        if ($value > $amount) {
            return false;
        }

        return true;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
