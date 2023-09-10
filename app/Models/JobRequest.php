<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
	protected $table="jobs_requests";

    protected $fillable = ['users_customers_id','jobs_id','status','date_added'];
    protected $primaryKey = 'jobs_requests_id';
    public $timestamps = false;

}