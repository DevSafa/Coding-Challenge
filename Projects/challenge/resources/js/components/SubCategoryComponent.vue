<template>
    <div class="category-item">
        <div class="name"
        @click="showcategory()"
            :style="{
                paddingLeft: space * 30 + 10 + 'px',
            }"
        >
        <div>
            <button type="button" class="btn btn-outline-dark">{{name}}</button>
        </div>

        <div v-if="data">
             <i class="material-icons expand ">expand_more</i>
        </div>
           
        </div>
     <div class="item-container"
        v-show="showChildren"
    >
             <category-item
            v-for="(item, index) in data"
                :key="index"
                :name="item.name"
                :space=" space + 1 "
                :data="item.children"
            />
        </div>
    </div>
</template>

<script>

    export default {
        name : "category-item",
        data: () => ({
            showChildren:false,
            expanded: false,
            categories : []
        }),
        props : {
            name : {
                type: String,
                required : true
            },
            // space will be user to compute teh offset of children items
            space : {
                type : Number,
                required : true
            },
            data : {
                type : Array
            }
        },
        methods :{
            showcategory() {
                this.showChildren = !this.showChildren;
            },
        
        }
    }
</script>

<style lang="scss" scoped>
    .category-item {
        position : relative;
        .name  {
            width : 100%;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            white-space:nowrap;
            user-select: none;
            height: 50px;
            padding:  0 20px;
            box-sizing: border-box;

            
        }
     
    }
  
</style>