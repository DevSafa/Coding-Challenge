<template>
    <div class="container">
        <div class="category">
            <h1>Categories</h1>
            <categoryItem
                v-for="(item, index) in categoryTree"
                    :key="index"
                    :name="item.name"
                    :space="0"
                    :data="item.children"
            />
        </div>
        <div class="products">
            <h1>Products</h1>
        </div>
    </div>
  
 
</template>


<script>
import axios from 'axios';
import categoryItem from './SubCategoryComponent.vue'
    export default {
        name : "recursive-category",
        created() {
            this.fetchData();
        },
        methods : {
            fetchData(){
                axios.get("/categories")
                .then(res => {
                    this.categoryTree = res.data;
                })
            }
        },
        data () {
            return {
                categoryTree : []
            }
        },
        components : {
            categoryItem
        }
    }
</script>

