<script>
import Navbar from '@/Components/Navbar.vue';
import Footer from '@/Components/Footer.vue';
import { Head } from '@inertiajs/vue3';
export default {
    components: { Navbar, Footer, Head },
    props :{
        title : String,
    }
}
</script>
<template>
    <div>
        <Head :title="this.title"/>
        <Navbar />
        <slot />
    </div>
</template>


<style>
*{
    margin: 0px;
    padding: 0px;
}
</style>