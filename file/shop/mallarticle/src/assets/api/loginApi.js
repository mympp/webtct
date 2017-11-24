import baseApi from './baseApi';

/**
 * 用户登录
 * @param username 帐号
 * @param password 未进行加密处理的密码
 * @returns {AxiosPromise<any>}
 */
baseApi.login = function($username,$password){
  return this.get({
    r : 'mallArticle/login/login',
    username : username,
    password : md5(password),
  });
};

export default baseApi;
