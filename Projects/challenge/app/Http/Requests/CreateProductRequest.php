<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() : array
    {
        return [
            'name'			=> 'required|string|unique:products',
			'description'	=> 'required|string|max:1000',
			'price'			=> 'required|numeric',
			'category'		=> 'required|exists:categories,name',
			'image'			=> 'required|image'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages() : array
    {
        return [
            'required' => 'The :attribute is required',
        ];
    }
}
