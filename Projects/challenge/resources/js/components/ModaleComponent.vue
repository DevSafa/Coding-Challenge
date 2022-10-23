<template>
    <div class="bloc-modale" v-if="revele">
            <div class="overlay" @click="toggleModale"></div>
            <div class="card">
                <div class="modale card create-form-wrapper d-flex justify-content-center">
                    <form  @submit.prevent="processForm" class="create-form">

                        <h5 class="title">Create Product</h5>
                        <div>
                            <input type="text" class="form-control rounded border-white mb-3 form-input"
                                placeholder="Product name" required v-model="infos.name">

                        </div>
                        <div>
                            <input type="number" class="form-control rounded border-white mb-3 form-input"
                                placeholder="price" required v-model="infos.price">
                        </div>
                        <div>
                            <textarea class="form-control rounded border-white mb-3 form-text-area" rows="5" cols="30"
                                placeholder="Description" required  v-model="infos.description"></textarea>
                        </div>
                        <div>
                            <input class="form-control rounded border-white mb-3" type="file" required  ref="file">
                        </div>
                        <div class="submit-button-wrapper">
                            <input type="submit" value="Create">
                        </div>

                    </form>
                </div>
            </div>
    </div>
</template>

<script>
export default {
    name: 'Modale',
    props: ['revele', 'toggleModale','id'],
    data: () => ({
        infos : {
                    name : "",
                    price : 0,
                    description : "",
                    image : "",
                    id : 0
                }
    }),
    methods : {
        processForm() {
            axios.post('/create' , {
                infos : {
                    name : this.infos.name,
                    price : this.infos.price,
                    description : this.infos.description,
                    image : this.$refs.file.files[0],
                    id : this.id
                }
            }).then(res =>{
                console.log(res.data);
            })
        }
    }
}
</script>

<style scoped>
.bloc-modale {
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    display: flex;
    justify-content: center;
    align-items: center;
}
.overlay {
    background: rgba(0, 0, 0, 0.5);
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}
.btn-modale {
    position: absolute;
    top: 10px;
    right: 10px;
}
/* body {
  background-color: #f5e0e5 !important;
  font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
} */
.create-form-wrapper {
    padding: 100px 0;
}
.create-form {
    padding: 30px 40px;
    background-color: #ffffff;
    border-radius: 12px;
    max-width: 400px;
}
.create-form textarea {
    resize: none;
}
.create-form .form-input,
.form-text-area {
    background-color: #f0f4f5;
    height: 50px;
    padding-left: 16px;
}
.create-form .form-text-area {
    background-color: #f0f4f5;
    height: auto;
    padding-left: 16px;
}
.create-form .form-control::placeholder {
    color: #aeb4b9;
    font-weight: 500;
    opacity: 1;
}
.create-form .form-control:-ms-input-placeholder {
    color: #aeb4b9;
    font-weight: 500;
}
.create-form .form-control::-ms-input-placeholder {
    color: #aeb4b9;
    font-weight: 500;
}
.create-form .form-control:focus {
    border-color: #f33fb0;
    box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.07), 0 0 8px #f33fb0;
}
.create-form .title {
    text-align: center;
    font-size: 24px;
    font-weight: 500;
}
.create-form .description {
    /* color: #aeb4b9; */
    font-size: 14px;
    text-align: center;
}
.create-form .submit-button-wrapper {
    text-align: center;
}
.create-form .submit-button-wrapper input {
    border: none;
    border-radius: 4px;
    background-color: #f23292;
    color: white;
    text-transform: uppercase;
    padding: 10px 60px;
    font-weight: 500;
    letter-spacing: 2px;
}
.create-form .submit-button-wrapper input:hover {
    background-color: #d30069;
}
</style>