<script setup>

</script>

<template>
    <nav class="nav navbar navbar-light">
        <div class="container">
            <RouterLink to="/companies">Companies</RouterLink>
            <RouterLink to="/countries">Countries</RouterLink>
            <RouterLink to="/leaders">Leaders</RouterLink>
            <RouterLink to="/about">About</RouterLink>
        </div>
    </nav>
    <div class="container-fluid">
        <h1>Gold Mine App - Just Another Test =]</h1>

        <main>
            <RouterView />
        </main>
    </div>
</template>
