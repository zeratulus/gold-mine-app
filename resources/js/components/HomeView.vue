<script>
export default {
    methods: {
        goToAbout() {
            this.$router.push('/about')
        },
    },
}
</script>

<template>
    <h2>Home View</h2>
    <button @click="goToAbout" class="btn btn-primary">404 Page... about route doesn't exists</button>
</template>
<style scoped>

</style>
