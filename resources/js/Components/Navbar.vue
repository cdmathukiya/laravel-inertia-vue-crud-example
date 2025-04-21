<script>
import { Link } from '@inertiajs/vue3';
export default {
    components : { Link}
}
</script>

<template>
    <nav class="navbar">
        <Link :href="route('movies')" class="active">Home</Link>
        <Link :href="route('movies')">About</Link>
        <Link :href="route('movies')">Contact</Link>
    </nav>
</template>

<style scoped>
.navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #333;
    padding: 10px 20px;
}

.navbar a {
    color: white;
    text-decoration: none;
    margin: 0 15px;
    font-size: 18px;
    transition: color 0.3s ease;
}

.navbar a:hover {
    color: #00bcd4;
}

.navbar a.active {
    font-weight: bold;
    color: #00bcd4;
}
</style>