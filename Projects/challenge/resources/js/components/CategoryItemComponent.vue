<template>
	<div class="category-item">
		<div class="name" @click="showCategory()"  :style="{ paddingLeft: space * 30 + 10 + 'px'}">
			<div>
				<button type="button" class="btn-style btn btn-outline-dark">{{ name }}</button>
			</div>
		</div>
		<div class="item-container" v-show="showChildren">
			<category-item v-for="(item, index) in data" 
									:key   =  "index" 
									:name  =  "item.name" 
									:space =  "space + 1"
									:data  =  "item.children" 
									:id    =  "item.id"  
									v-on:callChange = "changeFromChild" />
		</div>
	</div>
</template>

<script>

export default {
    name: "category-item",
    data () {
		return {
			showChildren: false,
			categories: [],
    
		}   
    },

    props: {
        id: {
            type: Number,
			required: true
        },
        name: {
            type: String,
            required: true
        },
        space: {
            type: Number,
            required: true
        },
        data: {
            type: Array,
			required: true
        },
    },

    methods: {
        changeFromChild(id, n) 
		{
            this.$emit('callChange', id,n);
        },
        showCategory() 
		{
			this.showChildren = !this.showChildren;
			this.$emit('callChange', this.id, this.name);
		}
    },
}
</script>




<style lang="scss" scoped>
.name :focus{
        background-color:rgb(211, 174, 174) 
    }
.category-item {
    position: relative;

    .name {
        width: 100%;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        white-space: nowrap;
        user-select: none;
        height: 50px;
        padding: 0 20px;
        box-sizing: border-box;
    }
}
</style>