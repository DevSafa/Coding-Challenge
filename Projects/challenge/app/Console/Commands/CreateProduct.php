<?php

namespace App\Console\Commands;

use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\ProductRepositoryInterface;
use Illuminate\Console\Command;
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
    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        parent::__construct();
        $this->productRepositoryInterface = $productRepositoryInterface;
    }

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

        $this->productRepositoryInterface->storeCli($name, $description, $price , $category);
        
        return 0;
    }
}
