<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'category_id','subcategory_id','childcategory_id','name','base_price','discount_price','description','main_image','gallery_image','created_at','updated_at',
    ];
	
	//Relations
	public function category(){
		return $this->belongsTo("App\Models\Category");
	}
	
	public function subcategory(){
		return $this->belongsTo("App\Models\Category","subcategory_id");
	}
	
	public function childcategory(){
		return $this->belongsTo("App\Models\Category","childcategory_id");
	}
}
