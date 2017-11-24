<template>
  <el-main>
    <!--page-header-->
    <div class="page-header clearfix">
      <h1 class="page-header-title pull-left">文章分类</h1>
      <el-button class="page-header-btn pull-right" icon="el-icon-circle-plus" @click="addCateDialogVisible = true">
        创建分类
      </el-button>
      <el-button class="page-header-btn pull-right" icon="el-icon-back" @click="backToLastCate">
        上一级分类
      </el-button>
      <el-tag class="page-header-btn pull-right" style="height:40px;line-height:40px;">当前分类 ： {{ lastCate }}</el-tag>

      <el-dialog title="创建分类" :visible.sync="addCateDialogVisible">
        <el-form :model="addCateForm" label-width="140px">
          <el-form-item label="分类名称">
            <el-input v-model="addCateForm.catname"></el-input>
          </el-form-item>

          <el-form-item label="是否顶级分类">
            <el-switch v-model="addCateForm.isTop"></el-switch>
          </el-form-item>

          <el-form-item label="上级分类" v-if="!addCateForm.isTop">
            <el-select v-model="addCateForm.parentid" placeholder="请选择上级分类">
              <el-option
                v-for="item in categoryData"
                :key="item.catid"
                :label="item.catname"
                :value="item.catid">
              </el-option>
            </el-select>
          </el-form-item>

          <el-form-item label="分类介绍">
            <el-input v-model="addCateForm.description"></el-input>
          </el-form-item>

          <el-form-item label="关联的关键词地址">
            <el-input v-model="addCateForm.keywordLink"></el-input>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="addCateDialogVisible = false">取 消</el-button>
          <el-button type="primary" @click="submitNewCate()">确 定</el-button>
        </div>
      </el-dialog>
    </div>
    <!--page-header end-->

    <!--page-content-->
    <div class="page-content">

      <el-table
        v-loading = "isLoading"
        ref="multipleTable"
        :data="categoryData"
        style="width: 100%"
        @selection-change="handleSelectionChange"
      >
        <el-table-column type="selection" width="55"></el-table-column>
        <el-table-column prop="catid" label="编号"></el-table-column>
        <el-table-column prop="catname" label="分类名称"></el-table-column>
        <el-table-column prop="childNum" label="子分类数目"></el-table-column>
        <el-table-column label="操作" width="310px">
          <template slot-scope="scope">
            <el-button type="primary" icon="el-icon-edit" plain round size="mini">编辑</el-button>
            <el-button @click="subCate(scope.row.catid)" type="primary" plain round size="mini"
                       icon="el-icon-view">查看子分类
            </el-button>
            <el-button type="danger" plain round size="mini" icon="el-icon-delete"
                       @click.native.prevent="deleteCate(scope.row.catid)">
              删除
            </el-button>
          </template>
        </el-table-column>
      </el-table>

      <!--
      <div class="table-box-foot clearfix">
        <div class="table-box-foot-btn pull-left">
          <el-button type="danger" size="small" icon="el-icon-delete" plain>批量删除</el-button>
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
      -->

    </div>
  </el-main>
</template>

<style scoped>
  .table-box-foot {
    margin-top: 20px;
  }
</style>

<script>
  import CategoryApi from '@/assets/api/categoryApi.js';

  //搭建分类列表内容
  const buildCateList = function(vueObj , parentid ){
    vueObj.isLoading = true;
    vueObj.lastCateId = parentid;
    if(parentid != 0){
      CategoryApi.one(parentid).then( (response) => {
        vueObj.lastCate = JSON.parse(response.data).data.catname;
      });
    }

    CategoryApi.list(parentid).then(response => {
      vueObj.categoryData = JSON.parse(response.data).data;
      console.log(response);
      vueObj.isLoading = false;
    }).catch(() => {
      vueObj.$message({'message': '加载失败'});
      vueObj.isLoading = false;
    });
  };

  export default {
    data() {
      return {
        categoryData: [],
        //默认每页数据量
        pagesize: 10,
        //当前页码
        currentPage: 1,
        //查询的页码
        start: 1,
        //默认数据总数
        totalCount: 1000,

        //添加分类
        addCateForm: {
          name: '',
          isTop: false,
          cid: ''
        },

        addCateDialogVisible: false,
        isLoading : false,
        lastCateId : 0,
        lastCate : '最上级分类',
      }
    },
    created() {
      console.log(this.$route.params);

      let parentid = 0;
      if (this.$route.params.parentid != undefined) parentid = this.$route.params.parentid;

      buildCateList(this,parentid);
    },
    methods: {
      handleSelectionChange(val) {
        this.multipleSelection = val;
      },
      //每页显示数据量变更
      handleSizeChange: function (val) {
        this.pagesize = val;
      },
      //页码变更
      handleCurrentChange: function (val) {
        this.currentPage = val;
      },

      //二级分类
      testRouter: function (id) {
        this.$router.push({
          path: '/category/list/' + id + ''
        })
        console.log(this.$route.params);

      },

      // 添加分类提交数据
      submitNewCate: function () {
        CategoryApi.add(this.addCateForm).then((response) => {
          let urlResult = JSON.parse(response.data);
          if (urlResult.code == 1) {
            this.addCateDialogVisible = false;
            buildCateList(this,0);
            this.$message({message: '添加成功',});

          } else {
            this.$message({message: '添加失败:' + urlResult.result, type: 'warning'});
          }
        });
      },

      //删除分类
      deleteCate(catid){
        this.$confirm('确定要删除该分类?', '警告', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          CategoryApi.delete(catid).then( (response) => {
            let urlResult = JSON.parse(response.data);
            if(urlResult.code == 1){
              buildCateList(this,0);
              this.$message({message : '删除成功'});
            }else{
              this.$message({message : '删除失败,' + urlResult.result});
            }
          });
        }).catch(() => {

        });
      },

      //指定分类查看
      subCate(catid){
        buildCateList(this,catid);
      },

      //返回上一级分类
      backToLastCate(){
        buildCateList(this,0);
        this.lastCate = '最上级分类';
      },

    }
  }

</script>
