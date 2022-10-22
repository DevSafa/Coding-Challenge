<?php
    namespace App\Repositories\Category;

use App\Models\Category;

    class CategoryRepository implements CategoryRepositoryInterface {
  
        private function binChildren($categories)
        {
            foreach ($categories as $category)
            {
                // maybe need to use eager loader  instead of thaaatt   ?????????? 
               $category->children = $category->children()->get();
                if($category->children->isNotEmpty()) {
                    self::binChildren($category->children);
                }
            }
        }

        /** get All Categories */
        public function categories()
        {
        
            $categories = Category::get();
            $parentCategories = $categories->whereNull('parent_id');
            self::binChildren($parentCategories);
            return $parentCategories;

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