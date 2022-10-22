<?php
namespace App\Repositories\Category;


interface CategoryRepositoryInterface
{
    /** get All Categories */
    public function categories();

    /** get all parent Categories */
    public function parents();

    /** get all childs categories of a specific parent  */
    public function children($id);

    /** get parent of a specific category  */
    public function parent($id);

    /** get all products of a category  */
    public function products($id);
}

?>