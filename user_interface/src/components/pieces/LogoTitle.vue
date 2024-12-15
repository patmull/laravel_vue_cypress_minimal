<template>
    <div>
        <img class="mx-auto h-10 w-auto"
             src="https://www.adaptivewfs.com/wp-content/uploads/2020/07/logo-placeholder-image.png"
             alt="Way4Solution Logo" />
        <h2 class="mt-10 text-center text-2xl font-bold leading-9 tracking-tight text-gray-900">{{ title }}</h2>
    </div>
</template>

<script>
export default {
    name: 'LogoTitle',
    props: {
        title: {
            type: String,
            required: true
        }
    }
}

</script>

<style scoped>

</style>
