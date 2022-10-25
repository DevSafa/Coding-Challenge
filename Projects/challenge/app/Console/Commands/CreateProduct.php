<?php

namespace App\Console\Commands;

use App\Repositories\Product\ProductRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

// php artisan make:command CreateProduct --command=create:product
class CreateProduct extends Command
{
  
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a  product through CLI artisan';

    /**
     * Create a new command instance.
     *
     * @return void
     */


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->ask('Product\'s Name ');
        $description = $this->ask('Describe your product ');
        $price = $this->ask('Product\'s Price ');
        $category = $this->ask('Product\'s Category');

        $validator = Validator::make([
            'name' => $name,
            'description' => $description,
            'price' => $price,
            'category' =>$category
        ], [
            'name'			=> 'required|string|unique:products',
            'description'	=> 'required|string|max:1000',
            'price'			=> 'required|numeric',
            'category'		=> 'required|exists:categories,id',
        ]);

        if($validator->fails())
            $this->info("error");
        else
            ProductRepository::createProductCli($name, $description,$price,$category);
        return 0;
    }
}
