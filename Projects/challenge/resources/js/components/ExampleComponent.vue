<template>
    <div class="mx-auto w-100 mt-5"> 
        <div class="row">
            <div class="col-12 p-2">
                <div class="w-100 align-items-center py-1">
                    <h5 class="text-center"> Categories</h5>
                </div>
            </div>
            <div class="p-2 col-4" v-for="category in this.categories">
                    <div class="w-100 align-items-center py-1" @click="clickCategory(category.id)">
                        <button type="button" class="btn btn-success">{{ category.name}}</button>
                    </div>
            </div>     
             <div class="row mt-5">
                   <div class="p-2 col-4" v-for="category in this.subCategory" @click="clickSubCategory(category.id)">
                       <button type="button" class="btn btn-info">{{ category.name}}</button> 
                    </div> 

            </div> 
            <div class="col-6 p-2 " v-for="product in this.products" > 
                    <div class="card" style="width: 18rem;">
                        <img src ="" class="card-img-top" >
                        <div class="card-body">
                        <h5 class="card-title"><strong>Name : </strong> : {{ product.name}}</h5>
                        <h5 class="card-title"><strong>Price : </strong>{{ product.price}}</h5>
                        <p class="card-text">description{{ product.description}}</p>
                        </div>
                    </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                categories : [],
                subCategory : []
            }
        },
        created()
        {
            this.fetchCategories();
        },
        methods : {
            fetchCategories(){
                axios.get('/categories')
                .then(res =>{
                    this.categories = res.data;
                })
                
            }
        },
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
