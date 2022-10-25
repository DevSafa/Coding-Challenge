<template>
	<div class="container">
		<div class="category">
			<h1>Categories</h1>
			<categoryItemComponent v-for="(item, index) in categoryTree" 
							:key   = "index" 
							:name  = "item.name" 
							:space = "0"
							:data  = "item.children" 
							:id    = "item.id" 
							v-on:callChange="changeFromChild" />
		</div>
		<div class="Products">
			
			<h1>Products</h1>
			<h5 >{{ this.category_name }}</h5>
			<div class="custom-control custom-checkbox" v-show="this.products.length != 0">
				<input type="checkbox" class="custom-control-input" v-on:change="sortByPrice($event)">
				<label class="custom-control-label" for="customCheck1">sort By Price</label>
			</div>
			<div>
				<productComponent 	:products	= this.products
									:creation	= "this.create"
									:id			= "this.id"/>
			</div>
		</div>
	</div>
</template>


<script>
import axios from 'axios';
import categoryItemComponent from './CategoryItemComponent.vue'
import productComponent from './ProductComponent.vue'


	export default {
	name: "categories",
	data() {
		return {
			categoryTree: [],
			products: [],
			temp : [],
			create : false,
			category_name : ''
		}
	},
	created() {
		this.fetchData();
		this.id = 0;
	},
	
	methods: {

		fetchData() 
		{
			axios.get("/categories")
				.then(res => {
					this.categoryTree = res.data;
				})
			axios.get("/products")
				.then(res => {
					this.products = res.data;
				})
			this.create = false;
		},
		sortByPrice($event)
		{
			console.log("sortyByPrice");

			if($event.target.checked)
			{
				this.temp = this.products;
				this.products = this.products.slice().sort(function(a, b) {
        				return a.price - b.price;
      			});
			}
			else
				this.products = this.temp;
		},

		changeFromChild(id,name) 
		{
			this.category_name = name;
			axios.get(`/category/products/${id}`)
				.then(res => {
					this.create = true;
					this.id  = id;
					this.products = res.data;
				})
		},
    },

	components: 
	{
		categoryItemComponent,
		productComponent,
	}
}
</script>


<style lang="scss" scoped>
h5 {
	color:rgb(211, 174, 174) 
}

</style>

