<?php
    namespace App\Repositories\Category;

use App\Models\Category;

    class CategoryRepository implements CategoryRepositoryInterface {
  
        
        /** get All Categories */
        public function categories()
        {
            return Category::get();
        }

        /** get all parent Categories */
        public function parents()
        {
            return Category::where("parent_id", NULL)->get();
        }

        /** get all childs categories of a specific parent  */
        public function children($id)
        {
            return Category::find($id)->children()->get();
        }

        /** get parent of a specific category  */
        public function parent($id)
        {
            return Category::find($id)->parent()->get();
        }

        /** get all products of a category  */
        public function products($id)
        {
           return Category::find($id)->products()->get();
        }
    }
?>