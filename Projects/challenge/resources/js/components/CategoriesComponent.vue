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
			<div class="custom-control custom-checkbox" v-show="this.create">
				<input type="checkbox" class="custom-control-input" v-on:change="sort($event)">
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
	name: "category",
	data() {
		return {
			categoryTree: [],
			products: [],
			temp : [],
			create : false,
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
		sort($event)
		{
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
		
		changeFromChild(id) 
		{
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

