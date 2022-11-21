<?php
namespace App\Console\Validation;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;

class CliValidation 
{
    /**
     * a collection instance to store validated data
     * @var Collection
     */
    protected $validData = null;

    /**
     * a collection instance to store errors 
     *@var Collection
     */
    protected $errors = null;

    /**
     * create an instance of CliValidation
     * @return void
     */
    public function __construct()
    {
        $this->validData = collect();
        $this->errors =collect();
    }

    /**
     * get validate data
     * @return Collection
     */
    public function getValidData(): Collection
    {
        return $this->validData;
    }

    /**
     * get errors
     * @return Collection
     */
    public function getErrors(): Collection
    {
        return $this->errors;
    }

    /**
     * validate different data entered by the user
     * 
     * @param string $field
     * @param string $value
     * @param  array $rules
     * @return void 
     */
    public function validate(
        string $field, 
        string $value = null, 
        array $rules
        ): array
    {
        $validator = Validator::make(
            [ $field => $value],
            [ $field => $rules]
        );
        if ($validator->fails())
            $this->addError($validator->errors()->all());
        $this->validData->put($field,$value);
        return [];
    }

    /**
     * push errors to Collection 
     * @param array errors 
     * @return void
     */
    public function addError(array $errors): void
    {
        foreach ($errors as $error) {
            $this->errors->push($error);
        }
    }

    /**
     * do  validation to $data
     * @param Collection $data
     * @return void
     */
    public function check(Collection $data): void
    {
        $this->validate("name", $data['name'], ['required','string','unique:products']);
        $this->validate("description", $data['description'], ['required','string','max:1000']);
        $this->validate("price", $data['price'], ['required','numeric','gt:0']);
        $this->validate("category", $data['category'], ['required','exists:categories,name']);
        $this->validate("url", $data['url'], ['required','url']);
    }
}
