<script>
import FrontLayout from '@/Layouts/FrontLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';
import Create from '@/Pages/Movie/Create.vue';
import axios from 'axios';

export default {
    components: { FrontLayout, Link, Create },
    emits: ['modalToggle'],
    props: {
        movies: Object,
    },
    data() {
        return {
            title: 'Movie Page',
            modalToggle: false,
            movie: {},
            form: useForm({}),
        }
    },
    methods: {
        async editForm(route) {
            const res = await axios.get(route);
            this.movie = res.data;
            this.modalToggle = true;
        },
        closeModal() {
            this.modalToggle = !this.modalToggle;
            this.movie = {};
        },
        deleteData(e) {
            let url = e.target.getAttribute('url');
            if (confirm('Are you sure you want to delete?')) {
                this.form.delete(url, {
                    onError :(error) => {
                        console.log(error);
                    }
                });
            }
        }
    }
}
</script>

<template>
    <FrontLayout :title="title">
        <div class="table-list">
            <div class="head">
                <h1>Movie List</h1>
                <button @click="modalToggle = true">Create</button>
            </div>
            <div v-if="$page.props.flash.message" class="alert">
                {{ $page.props.flash.message }}
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Director</th>
                        <th>Release Date</th>
                        <th>Number</th>
                        <th>Price</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(movie, index) in movies" :key="index">
                        <td>{{ movie.name }}</td>
                        <td>{{ movie.director }}</td>
                        <td>{{ movie.release_date }}</td>
                        <td>{{ movie.number }}</td>
                        <td>{{ movie.price }}</td>
                        <td>
                            <img v-if="movie.image" :src="`storage/movie/${movie.image}`" alt=""
                                style="max-width: 120px; height: auto;">
                        </td>
                        <td>{{ movie.description ? movie.description : 'default' }}</td>
                        <td>{{ movie.status ? 'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-button"
                                    @click="editForm(route('movie.edit', movie.id))">Edit</button>
                                <button :url="route('movie.delete', movie.id)" class="delete-button"
                                    @click="deleteData($event)">Delete</button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <Create v-if="modalToggle" @modalToggle="closeModal()" :movie="movie" />
    </FrontLayout>
</template>

<style scoped>
.table-list {
    font-family: Arial, sans-serif;
    text-align: center;
    margin: 10px 10px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th,
td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    background-color: #f4f4f4;
}

tr:hover {
    background-color: #f9f9f9;
}

.action-buttons {
    display: flex;
    gap: 10px;
}

.action-buttons a,
.action-buttons button {
    padding: 5px 10px;
    border: none;
    cursor: pointer;
    border-radius: 4px;
}

.table-list .head {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}

.table-list .head button {
    font-size: larger;
}

.edit-button {
    background-color: #4CAF50;
    color: white;
}

.delete-button {
    background-color: #f44336;
    color: white;
}

.edit-button:hover {
    background-color: #45a049;
}

.delete-button:hover {
    background-color: #e53935;
}
</style>