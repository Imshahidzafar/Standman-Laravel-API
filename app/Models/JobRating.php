<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobRating extends Model
{
	protected $table="jobs_ratings";
	protected $fillable = [
		'users_customers_id',
		'employee_users_customers_id',
		'jobs_id',
		'rating',
		'comment',];
    protected $primaryKey = 'jobs_ratings_id';
    public $timestamps = false; 
}