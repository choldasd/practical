<?php

namespace App\Http\Controllers\Admin;
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
use App\Model\Admin;
use App\Notifications\NewCompany;

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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $response = array("status"=>false,"data"=>"","msg"=>"Oops! Something went wrong!");
		if($request->isMethod("get")){
			$search_para = $request->except("_");
			$page = 1;
			$search_arr = array();
			if(isset($search_para["page"])){ 
				if($search_para["page"] > 1){
					$page = $search_para["page"];
					//$i = ($page-1)*$this->per_page+1;
				}
			}
			$companyList =  User::select('*');
			if(isset($search_para["keyword"])){
				$keyword = trim($_GET["keyword"]);
				$search_arr["keyword"] = $keyword;
				$companyList = $companyList->whereRaw("name like '%$keyword%' OR email like '%$keyword%' OR website like '%$keyword%'");
			}
			
			if(isset($search_para["sort_type"]) && isset($search_para["sort_by"])){
				$companyList = $companyList->orderBy($search_para["sort_type"],$search_para["sort_by"]);
				$search_arr["sort_type"] = $search_para["sort_type"];
				$search_arr["sort_by"] = $search_para["sort_by"];
			}
			
			$companyList = $companyList->paginate($this->per_page);
			
			//$companyList->get();
			//dd($companyList);
			if($request->ajax()){
				$search = view("admin.companies.search",compact("companyList","search_para"))->render(); 
				//dd($search);
				if(!empty($search)){
					$response = array("status"=>true,"data"=>$search,"msg"=>"List retrieved succcessfully.");
				}else{
					$response = array("status"=>true,"data"=>"No record found.","msg"=>"Unable to retrieved list.");
				}
				return response()->json($response);
			}
		
			return view('admin.companies.index',compact("page"));
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admin.companies.create");
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
					unset($input['password_confirmation']);
					
					$companyDetail = User::create($input);
				
					//upload image if exist
					$isLogoUpdated = false;
					if(!empty($companyDetail)){
						
						//Email Notification
						/* $admin = Admin::first();
						$admin->notify(new NewCompany("A new company has entered on your application.")); */
							
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
		$response = array("status"=>false,"data"=>"","msg"=>"Oops! Something went wrong!");
		if($request->isMethod("get")){
			if($request->ajax()){
				if(!empty($id) && $id>0){
					$companyDetail = User::where("id",$id)->first();				
					$edit = view("admin.companies.edit",compact("companyDetail"))->render(); 
					//dd($edit);
					if(!empty($edit)){
						$response = array("status"=>true,"data"=>$edit,"msg"=>"Record retrieved succcessfully.");
					}else{
						$response = array("status"=>false,"data"=>"No record found.","msg"=>"Unable to retrieved record.");
					}
				}else{
					$response = array("status"=>false,"data"=>"No record found.","msg"=>"Invalid record.");
				}
			}
		}
        return response()->json($response);
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
						$response = array("status"=>true,"data"=>"success","redirect"=>route("companies.index"),"logo"=>$isLogoUpdated,"msg"=>"Record updated successfully.");
						
					}else{
						//fail
						$response = array("status"=>false,"data"=>"fail","redirect"=>"","logo"=>$isLogoUpdated,"msg"=>"Unable to update record.");
					}
				}
			}
		}
        return response()->json($response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $response = array("status"=>false,"data"=>"","msg"=>"Oops! Something went wrong.");	
		if(!empty($id) && $id>0){
			$companyDetail = User::find($id);
			$isDeleted = $companyDetail->delete();
			if($isDeleted){
				Storage::disk('public')->delete($id.'/'.$companyDetail->logo);
				Storage::disk('public')->deleteDirectory($id);
				$response = array("status"=>true,"data"=>"success","msg"=>"Record deleted successfully.");
			}else{
				$response = array("status"=>false,"data"=>"fail","msg"=>"Unable to delete record.");
			}
		}else{
			$response = array("status"=>false,"data"=>"fail","msg"=>"Select correct record.");
		}
        return response()->json($response);
    }
	
}
