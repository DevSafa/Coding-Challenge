<?php

namespace App\Console\Commands;


use App\Interfaces\CliServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Collection;
use Illuminate\Http\UploadedFile;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Http\Exception;
use Illuminate\Support\Facades\Storage;


class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a product from command line';

    /**
     * a collection instance to store validated data
     * 
     * @var Illuminate\Support\Collection
     */
    protected $validData;

    /**
     * a collection instance to store errors 
     * 
     * @var App\Interfaces\CliServiceInterface
     */
    protected $errors;

    /**
     * The cliService instance.
     * 
     * @var App\Interfaces\CliServiceInterface
    */
	protected $cliService;

    /**
     * Create a new command instance.
     *
     * @param App\Interfaces\CliServiceInterface $cliService
     * 
     * @return void 
     */
    public function __construct(CliServiceInterface $cliService)
    {
        parent::__construct();
        $this->cliService = $cliService;
        $this->validData =collect();
        $this->errors =collect();

    }

    /**
     * push errors to collection 
     * 
     * @param string $fiels 
     * @param array  $errors
     * 
     * @return void
     */
    protected function addError(string $field , array $errors) : void
    {
        for($i = 0 ; $i < count($errors) ; $i++)
        {
            $this->errors->push($errors[$i]);
        }
    }

    /**
     * display collection of errors to the user
     * 
     * @return void 
     */
    protected function displayErrors() : void
    {
        for($i = 0 ; $i < count($this->errors) ; $i++)
        {
            $this->line("<bg=red>".$this->errors[$i]."</>");
        }
    }

    /**
     * validate different data entered by the user
     * 
     * @param string $field
     * 
     * @param string $value
     * 
     * @param  array $rules
     * 
     * @return void 
     */
    public function validate(string $field  , string $value = null,array $rules) : array
    {
        $validator = Validator::make(
            [ $field => $value],
            [ $field => $rules]
        );
        if($validator->fails())
            $this->addError($field,$validator->errors()->all());
        $this->validData->put($field,$value);
        return [];
    }

    /**
     * ask user for input data.
     * 
     * do validation
     * 
     * @return void
     */
    protected function askAndvalidateInput() : void 
    {
        $data = $this->ask('Product\'s name');
        $this->validate("name",$data,['required','string','unique:products']);
      
        
        $data = $this->ask('Describe your product ');
        $this->validate("description",$data,['required','string','max:1000']);
    
    
        $data = $this->ask('Product\'s Price ');
        $this->validate("price",$data,['required','numeric','gt:0']);
     
        
        $data = $this->ask('Product\'s Category');
        $this->validate("category",$data,['required','exists:categories,name']);
    

        $data = $this->ask('image url');
        $this->validate("url",$data,['required','url']);
    }
  

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->askAndvalidateInput();

        if (count($this->errors))
            return $this->displayErrors($this->errors);
        /** create an uploaded image  */
        $image = $this->cliService->getFile($this->validData['url']);
        $file = $this->cliService->getUploadFile($image, $this->validData['name']);
        $this->validData->put("image",$file);

        $this->validData->forget('url');
        $categories =  $this->cliService->getCategoryService()->getCategories($this->validData['category']);
		$product = $this->cliService->getProductService()->storeProduct($this->validData->put('categories',$categories));

    }

}