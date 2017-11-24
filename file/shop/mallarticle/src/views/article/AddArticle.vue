<template xmlns="">
  <el-main>
    <!--page-header-->
    <div class="page-header clearfix">
      <h1 class="page-header-title pull-left">发布文章</h1>

    </div>
    <!--page-header end-->

    <!--page-content-->
    <div class="page-content">
      <el-form ref="form" :model="form" :rules="rules" label-width="100px">
        <el-form-item label="文章标题" prop="name">
          <el-input v-model="form.name" placeholder="请输入文章标题"></el-input>
        </el-form-item>

        <el-form-item label="所属栏目" prop="category">
          <el-select ref="firstCate" placeholder="请选择文章分类" v-model="form.category" @change="changeFirstCate">
              <el-option v-for="cate in form.firstCate" :label="cate.catname" :value="cate.catid"></el-option>
          </el-select>
        </el-form-item>

        <el-form-item label="文章摘要" prop="summary">
          <el-input v-model="form.summary" placeholder="请输入文章摘要" type="textarea" :rows="3"></el-input>
        </el-form-item>

        <el-form-item label="关键词" prop="keywords">
          <el-tag
            :key="tag"
            v-for="tag in form.keywords"
            closable
            :disable-transitions="false"
            @close="kwHandleClose(tag)">
            {{tag}}
          </el-tag>
          <el-input
            class="input-new-tag"
            v-if="kwAddInputVisible"
            v-model="kwAddInputValue"
            ref="saveKwInput"
            size="small"
            @keyup.enter.native="kwHandleInputConfirm"
            @blur="kwHandleInputConfirm"
          >
          </el-input>
          <el-button v-else class="button-new-tag" size="small" @click="kwShowAddInput">+ 添加关键词</el-button>
        </el-form-item>

        <el-form-item label="发布时间" prop="time">
          <el-date-picker v-model="form.time" type="datetime" placeholder="请选择发布日期时间"></el-date-picker>
        </el-form-item>

        <el-form-item label="作者" prop="author">
          <el-col :span="8">
            <el-input v-model="form.author" placeholder="请输入文章作者"></el-input>
          </el-col>
        </el-form-item>

        <el-form-item label="来源" prop="source">
          <el-col :span="8">
            <el-input v-model="form.source" placeholder="请输入文章来源"></el-input>
          </el-col>
        </el-form-item>

        <el-form-item label="标签" prop="tags">
          <el-tag
            :key="tag"
            v-for="tag in form.tags"
            closable
            :disable-transitions="false"
            @close="tagHandleClose(tag)">
            {{tag}}
          </el-tag>
          <el-input
            class="input-new-tag"
            v-if="tagAddInputVisible"
            v-model="tagAddInputValue"
            ref="saveTagInput"
            size="small"
            @keyup.enter.native="tagHandleInputConfirm"
            @blur="tagHandleInputConfirm"
          >
          </el-input>
          <el-button v-else class="button-new-tag" size="small" @click="tagShowAddInput">+ 添加标签</el-button>
        </el-form-item>

        <el-form-item label="推送至首页">
          <el-switch v-model="form.isTop"></el-switch>
        </el-form-item>

        <el-form-item label="文章正文" prop="content">
          <UE ref="ue" :config="ueConfig" :defaultMsg="ueDefaultMsg.content"></UE>
        </el-form-item>

        <el-form-item label="关联产品">
          <el-row :gutter="0">
            <el-col :span="8">
              <el-input placeholder="请输入搜索产品关键字" v-model="relateKeyword" class="input-with-select">
                <el-button slot="append" icon="el-icon-search" @click="searchRelateProduct"></el-button>
              </el-input>
              <el-dialog title="搜索结果" :visible.sync="relateDialogVisible">
                <el-table
                  ref="relateDialogSelect"
                  :data="relateSearchResult"
                  tooltip-effect="dark"
                  style="width: 100%"
                  @selection-change="relateSelectionChange">
                  <el-table-column type="selection" width="55"></el-table-column>
                  <el-table-column prop="id" label="ID" width="70"></el-table-column>
                  <el-table-column prop="name" label="产品名称" width="350" show-overflow-tooltip></el-table-column>
                  <el-table-column prop="company" label="供应商" show-overflow-tooltip></el-table-column>
                </el-table>
                <div slot="footer">
                  <el-button @click="relateDialogVisible = false">取 消</el-button>
                  <el-button type="primary" @click="relateDialogSubmit">确 定</el-button>
                </div>
              </el-dialog>
            </el-col>
          </el-row>
          <el-row>
            <el-col :span="24">
              <div class="form-col-header"><h3 class="form-col-header-name">已关联产品</h3></div>
            </el-col>
            <el-col :span="24">
              <el-table
                :data="form.relateProduct"
                border
                style="width: 100%">
                <el-table-column
                  prop="name"
                  label="产品名称">
                </el-table-column>
                <el-table-column
                  prop="company"
                  label="供应商">
                </el-table-column>
                <el-table-column label="操作" width="176px">
                  <template slot-scope="scope">
                    <router-link :to="{path:'/show-'+scope.row.id+'.html'}" target="_blank">
                      <el-button type="primary" plain round size="mini" icon="el-icon-view">查看</el-button>
                    </router-link>
                    <el-button type="danger" plain round size="mini" icon="el-icon-delete"
                               @click.native.prevent="deleteRow(scope.$index, form.relateProduct)">删除
                    </el-button>
                  </template>
                </el-table-column>
              </el-table>
            </el-col>
          </el-row>
        </el-form-item>

        <el-form-item>
          <el-button type="primary" @click="submitForm('form')">立即提交</el-button>
          <el-button @click="resetForm('form')">重置</el-button>
        </el-form-item>

      </el-form>
    </div>
    <!--page-content end-->

  </el-main>
</template>

<style scoped>
  .el-form-item {
    padding-top: 10px;
  }

  .el-tag + .el-tag, .el-tag + .el-button {
    margin-left: 10px;
  }

  .button-new-tag {
    height: 32px;
    line-height: 30px;
    padding-top: 0;
    padding-bottom: 0;
    color: #888;
  }

  .input-new-tag {
    width: 124px;
    vertical-align: bottom;
  }

  .el-form-item .edui-default .edui-editor {
    border: 1px solid #d8dce5;
  }

  .el-form-item .el-dialog__body {
    padding: 0 15px 15px 15px;
  }

  .el-table__body-wrapper {
    overflow: hidden;
  }

  .form-col-header {
    margin: 20px 0 10px 0;
    position: relative;
    text-align: center;
  }

  .form-col-header:before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    margin-top: -1px;
    width: 100%;
    height: 1px;
    background-color: #eaeaea;

  }

  .form-col-header-name {
    display: inline-block;
    position: relative;
    padding: 0 20px;
    background-color: #fff;
    color: #888;

  }

  .el-table__header-wrapper {
    line-height: 1;
  }
</style>

<script>
  import UE from '@/components/ueditor.vue';
  import CategoryApi from '@/assets/api/categoryApi.js';

  export default {
    data() {
      // 自定义验证文章正文
      var checkContent = (rule, value, callback) => {
        let ArticleContent = this.$refs.ue.getUEContent();
        if (!ArticleContent) {
          return callback(new Error('文章内容不能为空'));
        } else {
          callback();
        }
      };
      return {
        ueConfig: {
          initialFrameWidth: null,
          initialFrameHeight: 350
        },
        ueDefaultMsg: {
          content: ''
        },
        form: {
          name: '',
          category: 0,
          firstCate : [],
          secondCate : [],
          summary: '',
          time: '',
          author: '',
          source: '',
          isTop: false,
          keywords: [],
          tags: [],
          relateProduct: []
        },
        rules: {
          name: [
            {required: true, message: '请填写文章标题', trigger: 'blur'}
          ],
          category: [
            {required: true, message: '请选择文章所属栏目', trigger: 'change'}
          ],
          summary: [
            {required: true, message: '请填写文章摘要', trigger: 'blur'}
          ],
          time: [
            {type: 'date', required: true, message: '请选择发布时间', trigger: 'blur'}
          ],
          author: [
            {required: true, message: '请填写文章作者', trigger: 'blur'}
          ],
          source: [
            {required: true, message: '请填写文章来源 ', trigger: 'blur'}
          ],
          keywords: [
            {type: 'array', required: true, message: '请至少填写一个关键词', trigger: 'blur'}
          ],
          tags: [
            {type: 'array', required: true, message: '请至少填写一个标签', trigger: 'blur'}
          ],
          content: [
            {validator: checkContent, trigger: 'blur'}
          ]
        },

        kwAddInputVisible: false,
        kwAddInputValue: '',
        tagAddInputVisible: false,
        tagAddInputValue: '',
        relateKeyword: '',
        relateDialogVisible: false,
        relateSearchResult: [{
          id: '1',
          name: '超脉冲等离子刀',
          company: '深圳国邦正大投资有限公司'
        }, {
          id: '2',
          name: '高频电刀',
          company: '北京康威电子技术有限公司'
        }, {
          id: '3',
          name: 'MFM-CMS 中央监护系统',
          company: '深圳市理邦精密仪器股份有限公司'
        }, {
          id: '4',
          name: '超声多普勒胎儿监护仪',
          company: '上海恒舜天实业有限公司'
        }, {
          id: '5',
          name: '迈瑞病人监护仪BeneView T5',
          company: '迈瑞医疗'
        }, {
          id: '6',
          name: '电子阴道镜',
          company: '深圳市理邦精密仪器股份有限公司'
        }
        ],
        relateDialogSelect: []
      }
    },
    created() {
      CategoryApi.select(0).then((response) => {
        this.form.firstCate = JSON.parse(response.data).data;
      });
    },
    methods: {
      // 关键字删除
      kwHandleClose(tag) {
        this.form.keywords.splice(this.form.keywords.indexOf(tag), 1);
      },
      // 关键字新增
      kwShowAddInput() {
        this.kwAddInputVisible = true;
        this.$nextTick(_ => {
          this.$refs.saveKwInput.$refs.input.focus();
        });
      },
      // 关键字新增提交
      kwHandleInputConfirm() {
        let kwAddInputValue = this.kwAddInputValue;
        if (kwAddInputValue) {
          this.form.keywords.push(kwAddInputValue);
        }
        this.kwAddInputVisible = false;
        this.kwAddInputValue = '';
      },
      // 标签删除
      tagHandleClose(tag) {
        this.form.tags.splice(this.form.tags.indexOf(tag), 1);
      },
      // 标签新增
      tagShowAddInput() {
        this.tagAddInputVisible = true;
        this.$nextTick(_ => {
          this.$refs.saveTagInput.$refs.input.focus();
        });
      },
      // 标签新增提交
      tagHandleInputConfirm() {
        let tagAddInputValue = this.tagAddInputValue;
        if (tagAddInputValue) {
          this.form.tags.push(tagAddInputValue);
        }
        this.tagAddInputVisible = false;
        this.tagAddInputValue = '';
      },
      //搜索相关产品
      searchRelateProduct() {
        let keyword = this.relateKeyword;
        if (keyword) {
          console.log("请求数据");
          this.relateDialogVisible = true;
        }
      },
      //勾选相关产品
      relateSelectionChange(val) {
        this.relateDialogSelect = val;
      },
      //相关产品渲染
      relateDialogSubmit() {
        var addRelate = this.relateDialogSelect;
        for (var i = 0; i < addRelate.length; i++) {
          this.form.relateProduct.push(addRelate[i]);
        }
        this.$refs.relateDialogSelect.clearSelection();

      },
      // 刪除行信息
      deleteRow(index, rows) {
        rows.splice(index, 1);
      },
      //提交表单
      submitForm(formName) {
        this.$refs[formName].validate((valid) => {
          if (valid) {
            console.log("submit form")
          } else {
            console.log('error submit!!');
            return false;
          }
        });
      },
      ///重置表单
      resetForm(formName) {
        this.$refs[formName].resetFields();

      },
      //选择一级分类
      changeFirstCate(){
        let catid = this.$refs.firstCate.value;
        if(catid != 0){
          CategoryApi.select(catid).then((response) => {
            this.form.secondCate = JSON.parse(response.data).data;
          });
        }
      }
    },

    components: {
      'UE': UE
    }
  }
</script>

