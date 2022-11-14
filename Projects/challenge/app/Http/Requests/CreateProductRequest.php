<?php

namespace App\Http\Requests;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection as SupportCollection;

class CreateProductRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
    */
    protected $stopOnFirstFailure = true;
    

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
			'description'	=> 'required|string|max:1000', // filled
			'price'			=> 'required|numeric|gt:0',
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

            "category.exists" => "category name doesn't exist"
        ];  
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator) : void 
    {
        /*   
            throw (new ValidationException($validator))
                    ->errorBag($this->errorBag);
        */

        throw new HttpResponseException(
            response()->json([
              'messages' => $validator->errors()->all()
            ], 400)
          ); 
                 
    }

    /**
     * here prepare data for Product service ('name' , 'description' , 'price' ,'image')
     *
     * @return Illuminate\Support\Collection
    */
    public function getDataForProductService() : SupportCollection
    {
        $validated = $this->safe()->except(['category']);
        return collect($validated);
    }


    /**
     * here prepare data for Category service ('category')
     *
     * @return Illuminate\Support\Collection
     */
    public function getDataForCategoryService() : string
    {
        $validated = $this->safe()->only(['category']);
        return $validated['category'];
    }
 }

