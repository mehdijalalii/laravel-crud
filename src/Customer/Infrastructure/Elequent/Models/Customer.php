<?php

namespace Src\Customer\Infrastructure\Elequent\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Src\Customer\Infrastructure\Elequent\Factories\CustomerFactory;
//use function app;

class Customer extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $fillable = [
        'first_name',
        'last_name',
        'date_of_birth',
        'email',
        'bank_account_number',
        'phone_number'
    ];


    protected static function newFactory()
    {
        return CustomerFactory::new();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->phone_number = removeNonDigitCharacters($user->phone_number);
        });

        static::updating(function ($user) {
            $user->phone_number = removeNonDigitCharacters($user->phone_number);
        });
    }

    public function getPhoneNumberAttribute($value)
    {
        if (!empty($value)) {
            return '+' . $value;
        }

        return $value;
    }
}
