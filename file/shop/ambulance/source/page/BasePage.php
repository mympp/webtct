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

    private function getRecommend(){
        return Db::Table('tc_mall')->field('itemid,title,thumb')->where(['status' => 3 ,'username' => $this->username])
            ->order('itemid desc')->limit(0,6)->select();
    }

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
            $menus = Db::Table('tc_type')->where(['item' => $item])->all();
            foreach($menus as $type){
                $type['reTypename'] = str_replace('系列','',$type['typename']);
                $this->_typeCate[] = $type;
            }
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

    public function getNews($pagesize = 100,$page = 1,$order = 'itemid desc',$field = 'itemid,title,thumb,introduce'){
        $newsDb = Db::Table('tc_news');

        $condition['status'] = 3;
        $condition['username'] = $this->username;

        $start = ($page - 1)*$pagesize;
        $news = $newsDb->where($condition)->limit($start,$pagesize)->order($order)->select();

        return $news;
    }

    public function getMenu(){
        return $this->render('menu',[
           'typeItem' => $this->getType(),
            'newsItem' => [
                ['title' => '新闻中心','url' => '/nlist.html']
            ],
        ]);
    }

    public function getLeftNav(){
        return $this->render('product-left',[
            'category' => $this->getType(),
            'malls' => $this->getRecommend(),
        ]);
    }

}
?>

