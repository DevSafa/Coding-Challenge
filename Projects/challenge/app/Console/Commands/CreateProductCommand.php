<?php
namespace App\Console\Commands;

use App\Console\Validation\CliValidation;
use App\Interfaces\CliServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;

class CreateProductCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'product:create';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Create a product from command line';

    /**
     * The cliService instance.
     * 
     * @var App\Interfaces\CliServiceInterface
    */
	protected $cliService = null;

    /**
     * The cliService instance.
     * @var App\Interfaces\CliServiceInterface
    */
	protected $cliValidation = null;

    /**
     * Create a new command instance.
     * @param App\Interfaces\CliServiceInterface $cliService
     * @return void 
     */
    public function __construct(CliServiceInterface $cliService)
    {
        parent::__construct();
        $this->cliService = $cliService;
        $this->cliValidation = new CliValidation();
    }

    /**
     * display collection of errors to the user
     * @return void 
     */
    protected function displayErrors(Collection $errors): void
    {
        foreach ($errors as $error) {
            $this->line("<bg=red>".$error."</>");
        }
    }

    /**
     * ask user for input data.
     * do validation
     * @return void
     */
    protected function askAndvalidateInput(): void 
    {   
        $dataToValidate = collect();
        $this->line("<fg=yellow>Product creation will take some time...</>");

        $data = $this->ask('Product\'s name');
        $dataToValidate->put("name",$data);
        
        $data = $this->ask('Describe your product');
        $dataToValidate->put("description",$data);

        $data = $this->ask('Product\'s Price');
        $dataToValidate->put("price",$data);

        $data = $this->ask('Product\'s Category');
        $dataToValidate->put("category",$data);

        $data = $this->ask('image url');
        $dataToValidate->put("url",$data);

        $this->cliValidation->check($dataToValidate);
    }
  
    /**
     * Execute the console command.
     * @return void
     */
    public function handle(): void 
    {
        $this->askAndvalidateInput();

        $errors = $this->cliValidation->getErrors();
        $validData = $this->cliValidation->getValidData();

        if (count($errors)) {
            $this->displayErrors($errors);
            $this->line("<fg=red>Failed to create Product</>");
        }
        else {

      
            $image = $this->cliService->getFile($validData['url']);
            if ($image === null)
                $this->line("<fg=red>Failed to create Product</>");
            else {
                $file = $this->cliService->getUploadFile($image, $validData['name']);
                $validData->put("image",$file);

                $validData->forget('url');
                $categories = $this->cliService->getCategoryService()
                                            ->getCategories($validData['category']);

                $this->cliService->getProductService()
                                            ->storeProduct(
                                                $validData->put('categories',$categories)
                                            );
                $this->line("<fg=green>Product created</>");
            }
        }
    }
}
