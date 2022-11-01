<template>
  <div  class="container">
    <div>
      <Modale v-if="showPopUp"  class="creation" :showPopUp="showPopUp" :show="show" :id="id" />
    </div>
    <div v-show="creation" @click="show" class="btn btn-success">Create new Product</div>


    <div class="container-fluid bg-trasparent my-4 p-3" style="position: relative">
      <div class="row row-cols-1 row-cols-xs-2 row-cols-sm-2 row-cols-lg-4 g-3">
        <div class="col hp" v-for="product in this.products">
          <div class="card h-100 shadow-sm">
            <img v-bind:src="'storage/images/'+ product.image"  class="card-img-top">
            <div class="label-top">
              <div class="text">{{ product.name}}</div>
            </div>
            <div class="card-body">
              <div class="clearfix mb-3">
                <span class="float-start badge rounded-pill bg-success">{{ product.price}}$</span>
              </div>
              <h5 class="card-title">
                <div class="text">{{ product.description}}</div>
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>

</template>


<script>

import Modale from './ModaleComponent.vue';

export default {

  name: "products",
  created() {

  },

  props: {
    products: {
      type: Array
    },
    creation : {
      type : Boolean
    },
    id : {
      type :Number
    }
  

  },
  methods: {
    fetchData() {

    },
    show() {
      this.showPopUp = !this.showPopUp;
    },

  },
  data() {
    return {
      showPopUp: false,
    }
  },
  components: {
    Modale
  }
}
</script>



<style lang="scss" scoped>
.container-fluid {
  max-width: 1000px;
}

.card h5 {
  overflow: hidden;
  height: 40px;
  font-weight: 300;
  font-size: 1rem;
}

.card h5 a {
  color: black;
  text-decoration: none;
}

.card-img-top {
  width: 100%;
  min-height: 250px;
  max-height: 250px;
  object-fit: contain;
  padding: 30px;
}



.card:hover {
  transform: scale(1.02);
  box-shadow: 0 10px 20px rgba(0, 0, 0, .12), 0 4px 8px rgba(0, 0, 0, .06);
}

/* Centered text */
.label-top {
  position: absolute;

  top: 8px;
  right: 8px;
  padding: 5px 10px 5px 10px;
  font-size: .7rem;
  font-weight: 600;
  border-radius: 3px;
  size: 30px;
  text-transform: uppercase;
}

.container {
  position: relative;

}

.container-fluid {
  position: absolute;
}

.creation {
  z-index: 9;
}
</style>