<?php
namespace App\Services;

use App\Interfaces\CategoryServiceInterface;
use App\Interfaces\CategoryRepositoryInterface;

class CategoryService implements CategoryServiceInterface 
{
    /**
     * category repository instance 
     * @var CategoryRepositoryInterface
     */
    protected $categoryRepository = null;

    /**
     * Create a new CategoryService instance.
     * @param  CategoryRepositoryInterface  $categoryRepository
     * @return void
    */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * get all categories and their sub categories.
     * @return  array
    */
    public function index(): array
    {
        return $this->categoryRepository->index()->toArray();
    }

    /**
     * get categories parents of a single category
     * @param string $name
     * @return array
     */
    public function getCategories(string $name): array
    {
        /** get Category id  */
        $id = $this->categoryRepository->getCategoryId($name);

        /* store categories in array */
        $categories = array();
        array_push($categories, $id);
        
        
        $parent = $this->categoryRepository->getParent($id); 
        while ($parent->isNotEmpty()) {
            array_push($categories, $parent[0]['id']);
            $parent = $this->categoryRepository->getParent($parent[0]->id);
        }
        return $categories;
    }

    /**
     * get products of a single category
     * @param int $id
     * @return array 
     */
    public function getProducts(int $id): array
    {
        return $this->categoryRepository->getProducts($id)->toArray();
    }
}
