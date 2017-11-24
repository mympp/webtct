//封装接口参数请求

import md5 from 'md5';
import axios from 'axios';

axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded';
axios.defaults.timeout = 3000;

export default {
    baseUrl: '//api.ltecenet.com/index.php',

    /**
     * 用户登录
     * @param username 帐号
     * @param password 未进行加密处理的密码
     * @returns {AxiosPromise<any>}
     */
    adminLogin: function (username, password) {
        return axios.get(this.baseUrl, {
            params: {
                r: 'mallArticle/login/login',
                username: username,
                password: md5(password),
            },
        });
    },

    /**
     *  分类列表
     * @param parentid 父级分类id,最上级为0
     * @returns {AxiosPromise<any>}
     */
    getCateList: function (parentid) {
        return axios.get(this.baseUrl, {
            params: {
                r: 'mallArticle/category/list',
                parentid: parentid,
            }
        });
    },

    /**
     * 添加文章分类
     * @param params 分类内容属性
     * @returns {AxiosPromise<any>}
     */
    addCategory: function (params) {
        params.r = 'mallArticle/category/add';
        return axios.get(this.baseUrl, {
            params: params
        })
    },
};
