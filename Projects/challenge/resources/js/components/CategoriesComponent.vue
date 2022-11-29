<template>
	<div class="container">
		<div class="categories">
			<h6>categories</h6>
			<categoryItemComponent v-for="(item, index) in categoryTree" 
							:key   = "index" 
							:name  = "item.name" 
							:space = "0"
							:data  = "item.children" 
							:id    = "item.id" 
							v-on:callChange="changeFromChild" />
		</div>
		<div class="Products">
			<h5 ><span>Products  :</span> {{ this.categoryName }}</h5>
			<div class="custom-control custom-checkbox" v-show="this.products.length != 0" >
				<input type="checkbox" class="custom-control-input" v-on:change="sortByPrice($event)">
				<label class="custom-control-label" for="customCheck1">sort By Price</label>
			</div>
			<div>
				<productComponent 	:products	 = this.products
									:creation	 = "this.create"
									:categoryName = "this.categoryName"/>
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
			categoryName : 'All Products'

		}
	},
	created() {
		this.fetchData();
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
					this.temp = this.products;
				})
			this.create = false;
		},

		sortByPrice($event)
		{
			if($event.target.checked)
			{
				this.products = this.products.slice().sort(function(a, b) {
						return a.price - b.price;
				});
			}
			else 
				this.products = this.temp;

		},

		changeFromChild(id,name) 
		{
			this.categoryName = name;
			axios.get(`/filter/${id}`)
				.then(res => {
					this.create = true;
					this.products = res.data;
					this.temp = this.products
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
	color:rgb(211, 174, 174) ;
}
span {
	color:rgb(170, 78, 78) ;

}
h6 {
	color:rgb(170, 78, 78) ;
}

.categories{
    float: left;
	width : 30%;
}  
.Products {
    float: left;
	width : 70%;
}
</style>

