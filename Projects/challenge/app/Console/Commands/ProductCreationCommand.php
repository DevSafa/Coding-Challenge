<?php

namespace App\Console\Commands;

use App\Exceptions\InvalidContentImageException;
use App\Interfaces\Services\ProductCreationServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductCreationCommand extends Command
{
    /**
     * @var App\Interfaces\Services\ProductCreationServiceInterface
     */
    protected $productCreationService = null;

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
    protected $description = 'create a product';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(
        ProductCreationServiceInterface $productCreationService
    ) {
        parent::__construct();
        $this->productCreationService = $productCreationService;
    }

    /**
     * ask user for input and collect data
     *
     * @return Illuminate\Support\Collection
     */
    protected function askInput(): Collection
    {
        $dataToValidate = collect();

        $this->displayMessage(
            'Product creation will take some time because 
             of reading url content',
            "yellow"
        );

        $data = $this->ask('Product\'s name');
        $dataToValidate->put("name", $data);

        $data = $this->ask('Describe your product');
        $dataToValidate->put("description", $data);

        $data = $this->ask('Product\'s Price');
        $dataToValidate->put("price", $data);

        $data = $this->ask('Product\'s Category');
        $dataToValidate->put("category", $data);

        $data = $this->ask('image url');
        $dataToValidate->put("url", $data);

        return $dataToValidate;
    }

    /**
     * display errors of validaton in console
     *
     * @param array $errors
     *
     * @return void
     */
    protected function displayErrors(array $errors): void
    {
        foreach ($errors as $error) {
            $this->displayMessage($error[0], "red");
        }
    }

    /**
     * display message in console
     *
     * @param string $msg
     *
     * @param string $color
     *
     * @return void
     */
    protected function displayMessage(string $msg, string $color): void
    {
        $this->line("<fg=".$color.">".$msg."</>");
    }

    /**
     * get image content and get uploaded file
     * using ProductCreationService
     *
     * @param Illuminate\Support\Collection
     *
     * @return void
     */
    protected function uploadImage(Collection $data): void
    {
        $image = $this->productCreationService->getFile($data['url']);

        $file = $this->productCreationService->getUploadFile(
            $image,
            $data['name']
        );

        $data->put("image", $file);
    }

    /**
     * store product using ProductCreationService
     *
     * @param Illuminate\Support\Collection
     *
     * @return void
     */
    protected function storeProduct(Collection $data): void
    {
        $data->forget('url');
        $this->productCreationService->storeProduct($data->toArray());
    }
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $data = $this->askInput();

        try {
            $this->productCreationService->validateData(
                $data->toArray(),
                true
            );

            $this->uploadImage($data);
            $this->storeProduct($data);
            $this->displayMessage("Product created", "green");
        } catch(Throwable $e) {
            $this->displayMessage("Failed to create Product!!!", "red");
            if ($e instanceof ValidationException) {
                $this->displayErrors($e->errors());
            } elseif ($e instanceof InvalidContentImageException) {
                $this->displayMessage($e->getMessage(), "red");
            } else {
                $this->displayMessage("server error", "red");
            }
        }
        return 0;
    }
}
