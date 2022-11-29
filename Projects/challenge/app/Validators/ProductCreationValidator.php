<?php

namespace App\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\MessageBag;

class ProductCreationValidator
{
    /**
     * @var Illuminate\Support\Facades\Validator
     */
    protected $validator = null;

    /**
     * create a new ProductCreation instance
     *
     * @param array $values
     * @param bool  $cli
     *
     * @return void
     */
    public function __construct(array $values, bool $cli)
    {
        if ($cli === true) {
            $this->validator = Validator::make(
                $values,
                $this->rulesCli(),
                $this->messages()
            );
        } else {
            $this->validator = Validator::make(
                $values,
                $this->rulesWeb(),
                $this->messages()
            );
        }
    }

    /**
     * specify the general rules for validation
     * cli and web
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'name'			=> 'required|string|unique:products',
            'description'	=> 'required|string|max:1000',
            'price'			=> 'required|numeric|gt:0',
            'category'		=> 'required|exists:categories,name',
        ];
    }

    /**
     * cli rules
     *
     * @return array
     */
    protected function rulesCli(): array
    {
        return array_merge($this->rules(), ['url' =>'required|url']);
    }

    /**
     * web rules
     *
     * @return array
     */
    public function rulesWeb(): array
    {
        return array_merge($this->rules(), ['image'=> 'required|image']);
    }

    /**
     * overwrite message error of category.exists rule
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            "category.exists" => "category name doesn't exist"
        ];
    }

    /**
     * check if validation fails
     *
     * @return bool
     */
    public function check(): bool
    {
        return $this->validator->fails();
    }

    /**
     * get error messages
     *
     * @return array
     */
    public function errors(): MessageBag
    {
        return $this->validator->errors();
    }
}
