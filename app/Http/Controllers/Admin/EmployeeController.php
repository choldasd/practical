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
use App\Model\Employee;

class EmployeeController extends Controller
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
				}
			}
			$employeeList =  Employee::select('*');
			if(isset($search_para["keyword"]) && !empty($search_para["keyword"])){
				$keyword = trim($_GET["keyword"]);
				$search_arr["keyword"] = $keyword;
				$employeeList = $employeeList->whereRaw("full_name like '%$keyword%' OR email like '%$keyword%' OR phone like '%$keyword%'");
			}
			//dd($search_para["company_id"]);
			if(isset($search_para["company_id"]) && !empty($search_para["company_id"])){
				$company_id = trim($_GET["company_id"]);
				$search_arr["company_id"] = $company_id;
				$employeeList = $employeeList->where("company_id",$company_id);
			}
			
			if(isset($search_para["sort_type"]) && isset($search_para["sort_by"])){
				$employeeList = $employeeList->orderBy($search_para["sort_type"],$search_para["sort_by"]);
				$search_arr["sort_type"] = $search_para["sort_type"];
				$search_arr["sort_by"] = $search_para["sort_by"];
			}
			
			$employeeList = $employeeList->with('user')->paginate($this->per_page);
			
			$companyList = User::get();
			//$employeeList->get();
			//dd($employeeList);
			if($request->ajax()){
				$search = view("admin.employees.search",compact("employeeList","companyList","search_para"))->render(); 
				//dd($search);
				if(!empty($search)){
					$response = array("status"=>true,"data"=>$search,"msg"=>"List retrieved succcessfully.");
				}else{
					$response = array("status"=>true,"data"=>"No record found.","msg"=>"Unable to retrieved list.");
				}
				return response()->json($response);
			}
		
			return view('admin.employees.index',compact("companyList","page"));
		}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$companyList = User::get();
        return view("admin.employees.create",compact("companyList"));
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
			$rules['full_name'] = 'required|unique:employees';
			$rules['email'] = 'required|max:191|unique:employees|email';
			$rules['phone'] = 'required|digits_between:10,11';
			$rules['company_id'] = 'required';
			
			$input = $request->all();
			$validation = Validator::make($input, $rules);
			if ($validation->fails()) {
				$errors = $validation->errors(); 
				$response = array("status"=>false,"data"=>$errors->toArray(),"msg"=>"Something went wrong with your input. Please check for validation.");
				return response()->json($response);
			}else{
				if(!empty($input) && count($input)>0){
					$employeeDetail = Employee::create($input);
				
					if(!empty($employeeDetail)){
						$response = array("status"=>true,"data"=>"success","redirect"=>route("employees.index"),"msg"=>"Record created successfully.");
					}else{
						//fail
						$response = array("status"=>false,"data"=>"fail","redirect"=>"","msg"=>"Unable to create record.");
					}
				}
			}
		}
        return response()->json($response);
    }
	

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
					$employeeDetail = Employee::where("id",$id)->first();
					$companyList = User::get();					
					$edit = view("admin.employees.edit",compact("employeeDetail","companyList"))->render(); 
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
    public function update(Request $request, $employee_id)
    {
        $response = array("status"=>false,"data"=>"","msg"=>"Oops! Something went wrong.");
		if(!empty($request)){
			$input = $request->all();
			
			// write rule for validation
			$rules['full_name'] = 'required|unique:employees,id,'.$employee_id;
			$rules['email'] = 'required|email|max:191|unique:employees,id,'.$employee_id;
			$rules['phone'] = 'required|digits_between:10,11';
			$rules['company_id'] = 'required';
			
			$validation = Validator::make($input, $rules);
			if ($validation->fails()) {
				$errors = $validation->errors(); 
				$response = array("status"=>false,"data"=>$errors->toArray(),"msg"=>"Something went wrong with your input. Please check for validation.");
				return response()->json($response);
			}else{
				if(!empty($input) && count($input)>0){
					//edit employee
					$employee = Employee::find($employee_id);					
					$isUpdated = $employee->update($input);
					
					if($isUpdated){
						$response = array("status"=>true,"data"=>"success","redirect"=>route("employees.index"),"msg"=>"Record updated successfully.");
					}else{
						//fail
						$response = array("status"=>false,"data"=>"fail","redirect"=>"","msg"=>"Unable to update record.");
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
			$employeeDetail = Employee::find($id);
			$isDeleted = $employeeDetail->delete();
			if($isDeleted){
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
