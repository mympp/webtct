import axios from 'axios';

axios.defaults.headers['Content-Type'] = 'application/x-www-form-urlencoded';
axios.defaults.timeout = 3000;

export default{
  baseUrl : '//api.ltecenet.com/index.php',

  get : function(parmas){
    return axios.get(this.baseUrl,{
      params : parmas,
    });
  },
};
