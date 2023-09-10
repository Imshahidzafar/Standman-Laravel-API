<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemCurrency extends Model
{
	protected $table="system_currencies";
    protected $primaryKey = 'system_currencies_id';
    public $timestamps = false;

    public function country()
    {	 
    	return $this->hasOne(SystemCountry::class,'code','code');
    }
}