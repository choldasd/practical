<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Image;
use File;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	
	public function upload_image($image_file,$id,$folder_path,$type){
		$response = array("status"=>false,"data"=>"");
		$dest_path = public_path().ADMIN_IMAGE. $folder_path."/".$id."/";
		if(!File::exists($dest_path)) {
			// path does not exist
			$is_created = File::makeDirectory($dest_path, $mode = 0777, true, true);
			$is_created = File::makeDirectory($dest_path."200", $mode = 0777, true, true);
		}else{
			// path exist
			$is_deleted = File::deleteDirectory($dest_path, true);
			$is_created = File::makeDirectory($dest_path, $mode = 0777, true, true);
			$is_created = File::makeDirectory($dest_path."200", $mode = 0777, true, true);
		
		}
		
		if($is_created){
			//$image->getClientOriginalExtension();
			$original_name = $image_file->getClientOriginalName();
			$new_image_name = time().$original_name;
			
			$intervation_image = Image::make($image_file->getRealPath());
			$ok = $image_file->move($dest_path, $new_image_name);
			
			//default thumb image
			$is_thumb_created = $this->thumb_200x200($intervation_image,$dest_path,$new_image_name) ;
			
			//make particular thumb image			
			if($type == "categories"){
				
			}
			
			
			if($is_thumb_created){
				$response = array("status"=>true,"data"=>$new_image_name);
			}else{
				$response = array("status"=>false,"data"=>"");
			}
		}
		return  $response;
	}
	
		
	public function upload_product_image($image_file,$id,$folder_path,$type,$num){
		$response = array("status"=>false,"data"=>"");
		$dest_path = public_path().ADMIN_IMAGE. $folder_path."/".$id."/".$num."/";
		if(!File::exists($dest_path)) {
			// path does not exist
			$is_created = File::makeDirectory($dest_path, $mode = 0777, true, true);
			$is_created = File::makeDirectory($dest_path."200", $mode = 0777, true, true);
		}else{
			// path exist
			$is_deleted = File::deleteDirectory($dest_path, true);
			$is_created = File::makeDirectory($dest_path, $mode = 0777, true, true);
			$is_created = File::makeDirectory($dest_path."200", $mode = 0777, true, true);
		
		}
		
		if($is_created){
			//$image->getClientOriginalExtension();
			$original_name = $image_file->getClientOriginalName();
			$new_image_name = time().$original_name;
			
			$intervation_image = Image::make($image_file->getRealPath());
			$ok = $image_file->move($dest_path, $new_image_name);
			
			//default thumb image
			$is_thumb_created = $this->thumb_200x200($intervation_image,$dest_path,$new_image_name) ;
			
			//make particular thumb image
			if($is_thumb_created){
				$response = array("status"=>true,"data"=>$new_image_name);
			}else{
				$response = array("status"=>false,"data"=>"");
			}
		}
		return  $response;
	}
	
	public function thumb_200x200($image,$dest_path,$new_image_name) {
		$dest_path = $dest_path."200/";
		$is_created = $image->resize(200, 200, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		})->save($dest_path.$new_image_name);
	
		if($is_created){
			return $is_created;
		}else{
			return false;
		}
	}
	
}
