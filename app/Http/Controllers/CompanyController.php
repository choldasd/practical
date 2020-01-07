<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Validator;
use Auth;
use Image;
use App\User;

class CompanyController extends Controller
{
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()	
    {
		$this->per_page = 10;
    }
	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("company.create");
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = array("status"=>false,"data"=>"","msg"=>"Oops! Something went wrong.");
		if(!empty($request)){
			// write rule for validation
			$rules['name'] = 'required|max:100|unique:users';
			$rules['email'] = 'required|unique:users|email';
			$rules['website'] = 'url|max:100|unique:users';
			$rules['password'] = 'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*_]).{6,}$/';
			$rules['logo'] = 'image|mimes:jpeg,png|max:2048|dimensions:min_width=100,min_height=100,max_width=300,max_height=300';
					
			$input = $request->all();
			$validation = Validator::make($input, $rules);
			if ($validation->fails()) {
				$errors = $validation->errors(); 
				$response = array("status"=>false,"data"=>$errors->toArray(),"msg"=>"Something went wrong with your input. Please check for validation.");
				return response()->json($response);
			}else{
				if(!empty($input) && count($input)>0){
					$input['password'] = Hash::make($input['password']);
					$companyDetail = User::create($input);
				
					//upload image if exist
					$isLogoUpdated = false;
					if(!empty($companyDetail)){
						
						if(isset($input["logo"])){
							$logo_file = $input["logo"];
							$logo_file_error = $logo_file->getError();
							if(isset($logo_file_error) && $logo_file_error == 0){
								
								//$extension = $logo_file->getClientOriginalExtension();
								$logoname = $logo_file->getClientOriginalName();
								Storage::disk('public')->put($companyDetail->id."/".$logoname, File::get($logo_file));

								$isLogoUpdated = $companyDetail->update(array("logo"=>$logoname));
							}
						}
						
						
						$response = array("status"=>true,"data"=>"success","redirect"=>route("companies.index"),"logo"=>$isLogoUpdated,"msg"=>"Record created successfully.");
						
					}else{
						//fail
						$response = array("status"=>false,"data"=>"fail","redirect"=>"","logo"=>$isLogoUpdated,"msg"=>"Unable to create record.");
						
					}
				}
			}
		}
        return response()->json($response);
    }
	
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,Request $request)
    {
		$companyDetail = User::where("id",$id)->first();
		return view("companies.edit",compact("companyDetail"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $company_id)
    {
        $response = array("status"=>false,"data"=>"","msg"=>"Oops! Something went wrong.");
		if(!empty($request)){
			$input = $request->all();
			
			// write rule for validation
			$rules['name'] = 'required|max:191|unique:users,id,'.$company_id;
			$rules['email'] = 'required|email|unique:users,id,'.$company_id;
			$rules['website'] = 'url|max:191|unique:users,id,'.$company_id;	
			
			if(isset($input['logo'])){
				$rules['logo'] = 'image|mimes:jpeg,png|max:2048|dimensions:min_width=100,min_height=100,max_width=300,max_height=300';
				$logo_file = $input["logo"];
			}
			if(isset($input['password'])){
				$rules['password'] = 'confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*_]).{6,}$/';
				
			}else{
				unset($input['password']);
				unset($input['password_confirmation']);
			}
			unset($input['logo']);
			
			$validation = Validator::make($input, $rules);
			if ($validation->fails()) {
				$errors = $validation->errors(); 
				$response = array("status"=>false,"data"=>$errors->toArray(),"msg"=>"Something went wrong with your input. Please check for validation.");
				return response()->json($response);
			}else{
				if(!empty($input) && count($input)>0){
					//edit company
					if(isset($input['password'])){
						$input['password'] = Hash::make($input['password']);
						unset($input['password_confirmation']);
					}
					//dd($input);
					$company = User::find($company_id);
					$isUpdated = $company->update($input);
					if($isUpdated){
						$companyDetail = $company;
					}
						
					//upload logo if exist
					$isLogoUpdated = false;
					if(!empty($companyDetail)){
						if(isset($logo_file)){
							$logo_file_error = $logo_file->getError();
							if(isset($logo_file_error) && $logo_file_error == 0){
								//remove old file
								if(!empty($companyDetail->logo)){
									Storage::disk('public')->delete($companyDetail->id.'/'.$companyDetail->logo);
								}
								//upload new file
								$logoname = $logo_file->getClientOriginalName();
								Storage::disk('public')->put($companyDetail->id."/".$logoname, File::get($logo_file));

								$isLogoUpdated = $companyDetail->update(array("logo"=>$logoname));
							}
						}
						$response = array("status"=>true,"data"=>"success","redirect"=>route("company.edit",Auth::user()->id),"logo"=>$isLogoUpdated,"msg"=>"Record updated successfully.");
						
					}else{
						//fail
						$response = array("status"=>false,"data"=>"fail","redirect"=>"","logo"=>$isLogoUpdated,"msg"=>"Unable to update record.");
					}
				}
			}
		}
        return response()->json($response);
    }

}
