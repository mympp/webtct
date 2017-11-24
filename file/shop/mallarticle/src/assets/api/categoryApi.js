import baseApi from './baseApi';

/**
 *  分类列表
 * @param parentid 父级分类id,最上级为0
 * @returns {AxiosPromise<any>}
 */
baseApi.list = function(parentid){
  return this.get({
    r : 'mallArticle/category/list',
    parentid : parentid,
  });
};

/**
 * 添加文章分类
 * @param params 分类内容属性
 * @returns {AxiosPromise<any>}
 */
baseApi.add = function(params){
  let parentid = 0;
  let catname = '';
  let description = '';
  let keywordLink = '';

  if(params.parentid != undefined) parentid = params.parentid;
  if(params.catname != undefined) catname = params.catname;
  if(params.description != undefined) description = params.description;
  if(params.keywordLink != undefined) keywordLink = params.keywordLink;

  return this.get({
    r : 'mallArticle/category/add',
    parentid : parentid,
    catname : catname,
    description : description,
    keywordLink : keywordLink,
  });
};

/**
 *  分类选择框列表
 * @param parentid 父级分类id,最上级为0
 * @returns {AxiosPromise<any>}
 */
baseApi.select = function(parentid){
  return this.get({
    r : 'mallArticle/category/select',
    parentid : parentid,
  });
};

/**
 * 分类删除
 * @param catid 分类id
 * @returns {AxiosPromise<any>}
 */
baseApi.delete = function(catid){
  return this.get({
    r : 'mallArticle/category/delete',
    catid : catid,
  });
}

/**
 * 获取指定分类数据
 * @param catid
 */
baseApi.one = function(catid){
  return this.get({
    r : 'mallArticle/category/one',
    catid : catid,
  });
}

export default baseApi;
