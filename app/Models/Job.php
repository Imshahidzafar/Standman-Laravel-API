<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
	protected $table="jobs";

    protected $fillable = ['users_customers_id','name','image','service_charges','description','image','location','longitude','lattitude','start_date','start_time','end_time','tax','total_price','payment_gateways_name','payment_status','status','date_added','date_modified'];
    protected $primaryKey = 'jobs_id';
    public $timestamps = false;

}