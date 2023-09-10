<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsersCustomersWallet extends Model
{
	protected $table="users_customers_wallets";

    protected $fillable = ['users_customers_id','system_currencies_id','wallet_amount'];
    protected $primaryKey = 'users_customers_wallets_id';
    public $timestamps = false;

    public function currency()
    {	
    	return $this->hasOne(SystemCurrency::class,'system_currencies_id','system_currencies_id')->with('country');
    }
}