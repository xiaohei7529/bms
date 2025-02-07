<template>
    <div>
        <el-main>
            <h1>1111111111111</h1>
            <span v-text="this.$route.params.id"></span>
        </el-main>
    </div>
</template>

<script>
export default {
    data: {
    },
    created() {
        this.bookDetailsShow(this.$route.params.id)
    },
    mounted() {

    },
    watch: {

    },
    methods: {
        bookDetailsShow(id){
            console.log(id)
        }
    }
}

</script>
