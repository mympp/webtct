<template>
    <el-container class="wrap">
        <tcHeader></tcHeader>
        <tcMenu></tcMenu>
        <tcMain></tcMain>
    </el-container>
</template>

<script>
    import tcHeader from './layout/Header.vue';
    import tcMenu from './layout/Menu.vue';
    import tcMain from './layout/Main.vue';
    export default {
        components: {
            tcHeader,
            tcMenu,
            tcMain
        }
    }
</script>


