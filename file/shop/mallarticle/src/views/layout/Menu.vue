<template>
    <el-aside width="240px">
        <el-menu default-active="1" class="el-menu-vertical-demo">
            <el-submenu index="1">
                <template slot="title">
                    <i class="el-icon-edit-outline"></i>
                    <span>文章管理</span>
                </template>
                <el-menu-item index="1-1">
                    <router-link :to="{path:'/article/add'}">添加文章</router-link>
                </el-menu-item>
                <el-menu-item index="1-2">
                    <router-link :to="{path:'/article/list'}">文章列表</router-link>
                </el-menu-item>
                <el-menu-item index="1-3">
                    <router-link :to="{path:'/category/list'}">文章分类</router-link>
                </el-menu-item>
            </el-submenu>

            <el-submenu index="2">
                <template slot="title">
                    <i class="el-icon-document"></i>
                    <span>产品管理</span>
                </template>
                <el-menu-item index="2-1">产品列表</el-menu-item>
            </el-submenu>

            <el-submenu index="3">
                <template slot="title">
                    <i class="el-icon-setting"></i>
                    <span>推送设置</span>
                </template>
                <el-menu-item index="3-1">上传设置</el-menu-item>
                <el-menu-item index="3-2">待发布文章</el-menu-item>
            </el-submenu>

        </el-menu>
    </el-aside>
</template>


