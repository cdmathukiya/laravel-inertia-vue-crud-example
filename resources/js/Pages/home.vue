<script setup>
    import {ref} from 'vue'
    const counter = ref(0)
    setInterval(() => counter.value++, 1000)
</script>
<template>
    <h1>Welcome to My Laravel + inertia + Vuejs Demo</h1>

    <p>Hello You are here since: <strong>{{ counter }} second</strong></p>
</template>

<style scoped>

</style>
