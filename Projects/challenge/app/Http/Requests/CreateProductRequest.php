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
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected $stopOnFirstFailure = true;
    public function rules()
    {
        return [
        
                'name' => 'required|string|unique:products',
                'description' => 'required|string|max:1000',
                // 'price' => 'required|numeric',
                // 'category' => 'required|exists:categories,name',
                // //image :The file under validation must be an image (jpeg, png, bmp, or gif)
                // 'image' => 'required|image|unique:products'
        ];
    }


}
