<?php
    namespace App\Repositories\Category;

    class CategoryRepository implements CategoryRepositoryInterface {
        /** querying to database using Eloquent ORM  Models relations 
         * and predefined methods
         */
        
        /** get All Categories */
        public function categories()
        {
            
        }

        /** get all parent Categories */
        public function parents()
        {
            
        }

        /** get all childs categories of a specific parent  */
        public function childs($id)
        {
            
        }

        /** get parent of a specific category  */
        public function parent($id)
        {
            
        }

        /** get all products of a category  */
        public function products($id)
        {
           
        }
    }
?>