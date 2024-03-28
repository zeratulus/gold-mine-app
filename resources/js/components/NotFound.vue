<script>
export default {
    methods: {
        goHome() {
            this.$router.push('/')
        },
    },
}
</script>

<template>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; margin-top: -100px;">
        <div class="w-50">
            <h2 class="text-center">404 Page that you are looking for Not Found</h2>
            <h3 class="text-center" style="font-size: 72px;">💩</h3>
            <div class="d-flex justify-content-center">
                <button @click="goHome" class="btn btn-primary">Go Home</button>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
