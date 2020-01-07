<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'full_name','company_id','email','phone'
    ];      
	
	public function user(){
		return $this->belongsTo("App\User","company_id");
	}
	
	
}
