<script>
import { useForm } from '@inertiajs/vue3';

export default {
    components: { useForm },
    props: {
        movie: Object,
    },
    data() {
        return {
            form: {
                name: this.movie.name || '',
                director: this.movie.director || '',
                release_date: this.movie.release_date || '',
                number: this.movie.number || '',
                price: this.movie.price || '',
                image: this.movie.image || '',
                description: this.movie.description || '',
                status: this.movie.status || 0,
            },
            imageUrl: this.movie.image ? `/storage/movie/${this.movie.image}` : '',
            tempImageFile: null,
            errors: {},
        }
    },
    methods: {
        previewImage(event) {
            const file = event.target.files[0];
            if (file && file.type.startsWith("image/")) {
                this.tempImageFile = file;
                this.imageUrl = URL.createObjectURL(file);
            }
        },
        submitForm(e) {
            let url = Object.keys(this.movie).length == 0 ? route('movie.save') : route('movie.update', this.movie.id);
            if (this.tempImageFile) {
                this.form.image = this.tempImageFile;
            }
            if (this.movie.id) {
                this.form._method = 'put';
            }
            this.form = useForm(this.form);
            this.form.post(url, {
                onSuccess: () => {
                    this.form.reset();
                    this.tempImageFile = null;
                    this.$emit('modalToggle');
                },
                onError: (error) => {
                    console.log(error);
                    this.errors = error;
                },
            });
        },
    },
}
</script>

<template>
    <div class="modal-overlay" id="modal">
        <div class="modal">
            <div class="modal-header">
                Create the movie
            </div>
            <div class="modal-body">
                <form @submit.prevent="submitForm($event)">
                    <label for="name">Name</label>
                    <input type="text" id="name" v-model="form.name" placeholder="Enter your name">
                    <div v-if="this.errors.name" class="error">{{ this.errors.name }}</div>

                    <label for="option">Director</label>
                    <select id="option" v-model="form.director">
                        <option disabled value="">Select Director</option>
                        <option value="director 1">Director 1</option>
                        <option value="director 2">Director 2</option>
                        <option value="director 3">Director 3</option>
                    </select>
                    <div v-if="this.errors.director" class="error">{{ this.errors.director }}</div>

                    <label for="release_date">Release Date</label>
                    <input type="date" id="release_date" v-model="form.release_date">
                    <div v-if="this.errors.release_date" class="error">{{ this.errors.release_date }}</div>

                    <label for="number">Number</label>
                    <input type="number" id="number" v-model="form.number" placeholder="Enter number">
                    <div v-if="this.errors.number" class="error">{{ this.errors.number }}</div>

                    <label for="price">Price</label>
                    <input type="number" id="price" v-model="form.price" placeholder="Enter price" step="0.01">
                    <div v-if="this.errors.price" class="error">{{ this.errors.price }}</div>

                    <label for="image">Image</label>
                    <input type="file" @change="previewImage" id="image">
                    <div v-if="imageUrl" class="preview-box">
                        <p>Image Preview:</p>
                        <img :src="imageUrl" alt="Preview" class="preview-image" />
                    </div>
                    <div v-if="this.errors.image" class="error">{{ this.errors.image }}</div>

                    <label for="Description">Description</label>
                    <textarea id="Description" v-model="form.description" rows="4"
                        placeholder="Enter your Description"></textarea>
                    <div v-if="this.errors.description" class="error">{{ this.errors.description }}</div>

                    <label>Status</label>
                    <div class="radio-group">
                        <label><input type="radio" v-model="form.status" value='1'> Active</label>
                        <label><input type="radio" v-model="form.status" value='0'> Inactive</label>
                        <div v-if="this.errors.status" class="error">{{ this.errors.status }}</div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="back-btn" @click="$emit('modalToggle')">Back</button>
                        <button type="submit" class="save-btn" :disabled="form.processing">
                            <span v-if="form.processing">Submiting..</span>
                            <span v-else>Save</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: flex-start;
    z-index: 9999;
    overflow-y: auto;
    padding: 16px;
}

/* Modal container */
.modal {
    background-color: #fff;
    border-radius: 8px;
    width: 90%;
    max-width: 400px;
    margin: 16px auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.9);
    }

    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Modal heading */
.modal-header {
    padding: 16px;
    border-bottom: 1px solid #ddd;
    font-size: 18px;
    font-weight: bold;
    text-align: center;
}

/* Modal body */
.modal-body {
    padding: 16px;
}

.modal-body form {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.modal-body form label {
    font-size: 14px;
    margin-bottom: 4px;
}

.modal-body form input,
.modal-body form textarea,
.modal-body form select {
    padding: 8px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.modal-body form .radio-group {
    display: flex;
    gap: 16px;
    align-items: center;
}

.modal-body form .radio-group label {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;
    cursor: pointer;
}

.modal-body form .radio-group input[type="radio"] {
    accent-color: #4caf50;
    width: 16px;
    height: 16px;
}

.modal-body form .error {
    color: red;
}

/* Modal footer */
.modal-footer {
    padding: 16px;
    border-top: 1px solid #ddd;
    display: flex;
    justify-content: space-between;
}

.modal-footer button {
    padding: 8px 16px;
    font-size: 14px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.modal-footer .save-btn {
    background-color: #4caf50;
    color: white;
}

.modal-footer .back-btn {
    background-color: #f44336;
    color: white;
}
</style>