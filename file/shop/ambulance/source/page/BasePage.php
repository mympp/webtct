<?php
namespace source\page;

use source\config\Config;
use source\db\Db;

class BasePage
{
    private $_twigParams = [];
    private $_typeCate = [];
    public $userid ;
    public $username;

    public function __construct()
    {
        $userParams = Config::getInstance()->getParams('user');
        $this->userid = $userParams['userid'];
        $this->username = $userParams['username'];
    }

    private function getTwigParams(){
        if(empty($this->_twigParams)){
            $this->_twigParams = Config::getInstance()->getParams('twig');
        }
        return $this->_twigParams;
    }

    protected function getType(){
        if(empty($this->_typeCate)){
            $item = 'mall-'.$this->userid;
            $this->_typeCate = Db::Table('tc_type')->where(['item' => $item])->all();
        }

        return $this->_typeCate;
    }

    public function render($template , $params = [])
    {
        $loader = new \Twig_Loader_Filesystem(BaseRoot . $this->getTwigParams()['templatePath']);
        $twig = new \Twig_Environment($loader,[
            //'cache' => BaseRoot . $this->getTwigParams()['cachePath']
            'debug' => true,
        ]);

        $params['pageModel'] = $this;
        return $twig->render($template.'.html' , $params);
    }

    public function getMalls($mycatid = 0 ,$pagesize = 100 , $order = 'itemid asc'){
        $mallDb = Db::Table('tc_mall');

        $condition['status'] = 3;
        $condition['username'] = $this->username;
        if(!empty($mycatid)){
            $condition['mycatid'] = $mycatid;
        }

        $malls = $mallDb->where($condition)->limit(0,$pagesize)->order($order)->select();
        if(!$malls) return [];

        $result = [];
        $mallsId = '';
        foreach($malls as $mall){
            $mallsId[] = $mall['itemid'];
            $result[$mall['itemid']] = $mall;
        }

        $mallDataDb = Db::Table('tc_mall_data');
        $mallsContent = $mallDataDb->where(['itemid' => implode(',',$mallsId)] , 'in')->limit(0,$pagesize)->select();

        foreach($mallsContent as $content){
            $result[$content['itemid']]['content'] = $content['content'];
        }
        return $result;
    }

    public function getMenu(){
        return $this->render('menu',[
           'typeItem' => $this->getType(),
        ]);
    }

}
?>

