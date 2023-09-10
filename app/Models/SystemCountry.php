<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemCountry extends Model
{
	protected $table="system_countries";
    protected $primaryKey = 'system_countries_id';
    public $timestamps = false; 
}