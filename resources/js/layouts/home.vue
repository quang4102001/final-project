<template>
    <div>
        <HeaderHome/>
        <router-view></router-view>
    </div>
</template>

<script setup>
    import HeaderHome from '../components/HeaderHome.vue'

    components: {
        HeaderHome
    }
</script>