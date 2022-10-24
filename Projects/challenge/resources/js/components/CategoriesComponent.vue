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
			<productComponent 	:products	= this.products
								:creation	= "this.create"
								:id			= "this.id"/>
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

