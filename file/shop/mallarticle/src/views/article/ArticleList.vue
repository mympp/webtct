<template>
    <el-main>
        <!--page-header-->
        <div class="page-header clearfix">
            <h1 class="page-header-title pull-left">文章列表</h1>

        </div>
        <!--page-header end-->

        <!--page-content-->
        <div class="page-content">

            <!--selector-->
            <div class="selector-box">
                <el-form :inline="true" :model="selectorForm" size="small">
                    <el-form-item label="关键字">
                        <el-input v-model="selectorForm.keyword" placeholder="请输入文章关键字"></el-input>
                    </el-form-item>
                    <el-form-item label="所属栏目">
                        <el-cascader
                                :options="selectorForm.category"
                                :show-all-levels="false"
                                expand-trigger="hover"
                                placeholder="请选择文章所属栏目"
                        ></el-cascader>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary"  @click="submitForm()">查询</el-button>
                    </el-form-item>
                </el-form>
            </div>
            <!--selector end-->

            <!--table-box-->
            <div class="table-box">
                <el-table
                        :data="tableData"
                        tooltip-effect="dark"
                        style="width: 100%"
                        @selection-change="handleSelectionChange">
                    <el-table-column type="selection" width="55"> </el-table-column>
                    <el-table-column prop="id" label="ID" width="60"></el-table-column>
                    <el-table-column prop="title" label="文章标题" show-overflow-tooltip></el-table-column>
                    <el-table-column prop="category" label="所属分类" show-overflow-tooltip width="140px"></el-table-column>
                    <el-table-column prop="time" label="添加时间" align="center" width="140px"></el-table-column>
                    <el-table-column label="操作" align="center" width="276px">
                        <template slot-scope="scope">
                            <router-link :to="{path:'/show-'+scope.row.id+'.html'}" target="_blank">
                                <el-button type="primary" plain round size="mini" icon="el-icon-view">查看</el-button>
                            </router-link>
                            <router-link :to="{path:'/show-'+scope.row.id+'.html'}" target="_blank">
                                <el-button type="info" plain round size="mini" icon="el-icon-edit">编辑</el-button>
                            </router-link>
                            <el-button type="danger" plain round size="mini" icon="el-icon-delete" @click.native.prevent="deleteRow(scope.$index, form.relateProduct)">删除</el-button>
                        </template>
                    </el-table-column>
                </el-table>

                <div class="table-box-foot clearfix">
                    <div class="table-box-foot-btn pull-left">
                        <el-button type="danger" size="small" icon="el-icon-delete" plain>批量删除</el-button>
                        <el-button type="primary" size="small" icon="el-icon-upload2" plain>推送至首页</el-button>
                    </div>
                    <el-pagination
                            class="pull-right"
                            @size-change="handleSizeChange"
                            @current-change="handleCurrentChange"
                            :current-page="currentPage"
                            :page-sizes="[10, 20, 30, 40]"
                            :page-size="100"
                            layout="total, sizes, prev, pager, next, jumper"
                            :total="400"
                    >
                    </el-pagination>
                </div>

            </div>
            <!--table-box end-->
        </div>
        <!--page-content-->
    </el-main>
</template>
<style scoped>
    .selector-box{
        margin-top:10px;
        padding-bottom:20px;
        border-bottom:1px solid #eaeaea;
    }
    .table-box-foot-btn{
        margin-top:20px;
    }
    .table-box .el-pagination{
        padding:25px 0 0 0;
        text-align: right;
    }
</style>
<script>

    export default{
        data(){
            return {
                selectorForm: {
                    keyword:'',
                    category: [
                        {
                            value: 'v1',
                            label: '分类1',
                            children: [{
                                value: 'v1-1',
                                label: '分类1-1'
                            }, {
                                value: 'v1-2',
                                label: '分类1-2'
                            }]
                        },{
                            value: 'v2',
                            label: '分类2',
                            children: [{
                                value: 'v2-1',
                                label: '分类2-1'
                            }, {
                                value: 'v2-2',
                                label: '分类2-2'
                            }]
                        },{
                            value: 'v3',
                            label: '分类3',
                            children: [{
                                value: 'v3-1',
                                label: '分类3-1'
                            }, {
                                value: 'v3-2',
                                label: '分类3-2'
                            }, {
                                value: 'v3-3',
                                label: '分类3-3'
                            }]
                        }
                    ]
                },
                tableData: [
                    {
                        id:'1',
                        title: '超脉冲等离子刀',
                        category: '分类1',
                        time:'2017-11-20 11:22'
                    },{
                        id:'2',
                        title: '高频电刀',
                        category: '分类2',
                        time:'2017-11-20 11:11'
                    },{
                        id:'3',
                        title: 'MFM-CMS 中央监护系统',
                        category: '分类3',
                        time:'2017-11-10 11:22'
                    },{
                        id:'4',
                        title: '超声多普勒胎儿监护仪',
                        category: '分类2',
                        time:'2017-11-10 01:22'
                    },{
                        id:'5',
                        title: '迈瑞病人监护仪BeneView T5',
                        category: '分类2',
                        time:'2017-10-22 01:22'
                    },{
                        id:'6',
                        title: '电子阴道镜',
                        category: '分类1',
                        time:'2017-10-22 01:22'
                    },{
                        id:'7',
                        title: '高频电刀',
                        category: '分类2',
                        time:'2017-11-20 11:11'
                    },{
                        id:'8',
                        title: 'MFM-CMS 中央监护系统',
                        category: '分类3',
                        time:'2017-11-10 11:22'
                    },{
                        id:'9',
                        title: '超声多普勒胎儿监护仪',
                        category: '分类2',
                        time:'2017-11-10 01:22'
                    },{
                        id:'10',
                        title: '迈瑞病人监护仪BeneView T5',
                        category: '分类2',
                        time:'2017-10-22 01:22'
                    }
                ],

                //多选数组
                multipleSelection: [],
                //默认每页数据量
                pagesize: 10,
                //当前页码
                currentPage: 1,
                //查询的页码
                start: 1,
                //默认数据总数
                totalCount: 1000,
            }
        },
        methods:{
            //多选响应
            handleSelectionChange: function(val) {
                this.multipleSelection = val;
            },
            //多项删除
            deletenames: function(){
                if(this.multipleSelection.length==0)
                    return;
                var array = [];
                this.multipleSelection.forEach((item) => {
                    array.push(item.id);
                })
                this.$http.post('../delete',{"array":array},{emulateJSON: true}).then(function(res){
                    this.loadData(this.criteria, this.currentPage, this.pagesize);
                },function(){
                    console.log('failed');
                });
            },
            //每页显示数据量变更
            handleSizeChange: function(val) {
                this.pagesize = val;
//                this.loadData(this.criteria, this.currentPage, this.pagesize);
            },

            //页码变更
            handleCurrentChange: function(val) {
                this.currentPage = val;
//                this.loadData(this.criteria, this.currentPage, this.pagesize);
            },


            submitForm() {
                console.log("aaa");
            }
        },
        components: {}
    }
</script>
