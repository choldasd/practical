<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
	
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
			'name' => 'required|max:191|unique:users',
			'email' => 'required|email|max:191|unique:users',
			'website' => 'url|max:191|unique:users',
			'password' => 'required|confirmed|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*_]).{6,}$/',
			'logo' => 'image|mimes:jpeg,png|max:2048|dimensions:min_width=100,min_height=100,max_width=300,max_height=300',
		];
    }
	
	/**
	* Custom message for validation
	*
	* @return array
	*/
	public function messages()
	{
		return [
			'name.required' => 'Name is required.',
			'name.unique' => 'Name field must be unique.',
			'name.max' => 'Name field maximum 191 character long.',
			'email.required' => 'Email is required.',
			'email.unique' => 'Email field must be unique.',
			'email.max' => 'Email field maximum 191 character long.',
			'website.unique' => 'Website field must be unique.',
			'website.max' => 'Website field maximum 191 character long.',			
			'password.required' => 'Password is required',
			'logo.image' => 'File must be of image.',
			'logo.mimes' => 'Logo must be with valid extension like jpeg,png.',
			'logo.max' => 'Logo must be maximum 2MB size.',
			'logo.dimensions' => 'Logo must be having minimum 200px and maximum 300px height and width.',
		];
	}
	
	
	
}
