<template>
	<div class="bloc-modale" v-if="showPopUp">
		<div class="overlay" @click="show"></div>
		<div class="card">
			<div class="modale card create-form-wrapper d-flex justify-content-center" >
				<form @submit.prevent="processForm" class="create-form">

					<h5 class="title">Create Product</h5>
					<div>
						<input type="text" class="form-control rounded border-white mb-3 form-input"
							placeholder="Product name" required v-model="name">

					</div>
					<div>
						<input type="number" class="form-control rounded border-white mb-3 form-input"
							placeholder="price" required v-model="price">
					</div>
					<div>
						<textarea class="form-control rounded border-white mb-3 form-text-area" rows="5" cols="30"
							placeholder="Description" required v-model="description"></textarea>
					</div>
					<div>

						<input class="form-control rounded border-white mb-3" type="file" ref="file"
							v-on:change="handleFileUpload">
					</div>
					<div v-if="errors" v-for="errorArray in errors">
						<span class="text-danger">{{ errorArray[0] }} </span>
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
import axios from 'axios';

export default {

	name: 'Modale',
	props: ['showPopUp', 'show', 'id'],

	data() {
		return {
			name: 'dds',
			description: '',
			price: '',
			image: null,
			errors: '',

		}
	},
	methods: {

		handleFileUpload(e) {
			this.image = e.target.files[0];

		},
		processForm() {

			let formData = new FormData();
			formData.append("image", this.image);
			formData.append("name", this.name);
			formData.append("description", this.description);
			formData.append("price", this.price);
			formData.append("category", this.id);
			axios.post('/create', formData)
			.then(res => {
				console.log(res.data);
			}).catch(error => {
				this.errors = error.response.data;
			})
			this.showPopUp  = this.showPopUp;
			this.$emit('show');
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


//https://blog.quickadminpanel.com/laravel-api-how-to-upload-file-from-vue-js/