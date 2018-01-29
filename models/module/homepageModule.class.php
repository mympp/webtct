<?php
namespace models\module;

use models\helpers\query\CompanyDataQuery;
use models\helpers\query\CompanyQuery;
use models\helpers\query\AreaQuery;
use models\helpers\query\CompanyValidateQuery;
use models\helpers\query\CompanySettingQuery;
use models\helpers\query\MallQuery;
use models\helpers\query\NewsQuery;
use models\helpers\query\MemberQuery;
use models\helpers\query\LinkQuery;
use models\helpers\query\TypeQuery;
use models\helpers\query\HonorQuery;

use models\config\config;

//厂商独立网站处理模型
class homepageModule extends baseModule
{
    const default_banner = 'skin/teceskin/homepage/images/tp-banner-ex.jpg';

    public $userid = '';
    public $username = '';
    public $linkurl = '';
    public $mallUrl = '';
    public $newsUrl = '';
    public $introduceUrl = '';
    public $creditUrl = '';
    public $contactUrl = '';
    public $companyInfo = [];
    public $honorUrl = '';
    public $friendLinkUrl = '';

    public $searchRewriteFuncName = '';

    function __construct()
    {
        $this->moduleid = 4;
        $this->modulename = '厂商';
        $this->linkurl = '';
    }

    private function isSetUser(){
        if(empty($this->userid) || empty($this->username)){
            return false;
        }else{
            return true;
        }
    }

    public function setSearchRewriteFunc($funcName){
        $this->searchRewriteFuncName = $funcName;
    }

    public function searchRewrite($selector)
    {
        if(!is_array($selector)){
            return '';
        }elseif(empty($this->searchRewriteFuncName)){
            return '';
        }elseif(!method_exists($this,$this->searchRewriteFuncName)){
            return '';
        }else{
            return call_user_func_array([$this,$this->searchRewriteFuncName],[$selector]);
        }
    }

    public function setUser($userid , $username){
        $this->userid = $userid;
        $this->username = $username;

        $this->linkurl = str_replace('www',$this->username,config::getConfig('baseUrl'));
        $this->mallUrl = $this->linkurl .'mall/';
        $this->newsUrl = $this->linkurl . 'news/';
        $this->introduceUrl = $this->linkurl .'introduce/';
        $this->creditUrl = $this->linkurl . 'credit/';
        $this->contactUrl = $this->linkurl .'contact/';
        $this->honorUrl = $this->linkurl .'honor/';
        $this->friendLinkUrl = $this->linkurl .'link/' ;
    }

    public function getBanner(){
        if(!$this->isSetUser()) return [];

        $companySettingQuery = new CompanySettingQuery();
        $banner = $companySettingQuery->getCompanyBanner($this->userid);
        if(!$banner){
            //没有数据返回默认横幅图片
            $baseUrl = config::getConfig('baseUrl');
            return [$baseUrl . self::default_banner];
        }else{
            return $banner;
        }
    }

    public function buildMallShowLinkurl($itemid){
        return $this->mallUrl . 'itemid-'.$itemid.'.shtml';
    }

    public function buildMallList($malls){
        $result = [];
        foreach($malls as $key => $mall){
            if(!empty($mall['itemid'])){
                $mall['linkurl'] = $this->buildMallShowLinkurl($mall['itemid']);
            }
            if(empty((int)$mall['price'])){
                $mall['price'] = '面议';
            }
            $result[] = $mall;
        }
        return $result;
    }

    public function getMalls($pagesize , $page ,$catid){
        if(!$this->isSetUser()) return [];

        $mallQuery = new MallQuery();
        $malls = $mallQuery->getNewMalls($pagesize,$catid,'itemid,title,thumb,catid,price',$this->username,$page);
        if($malls){
            return $this->buildMallList($malls);
        }else{
            return [];
        }
    }

    public function getAnnounce(){
        if(!$this->isSetUser()) return '';
        $companySettingQuery = new CompanySettingQuery();
        return $companySettingQuery->getCompanyAnnounce($this->userid);
    }

    public function getLogo(){
        if(!$this->isSetUser()) return '';
        $companySettingQuery = new CompanySettingQuery();
        return $companySettingQuery->getLogo($this->userid);
    }

    public function getCompanyInfo(){
        if(!$this->isSetUser()) return [];


        if(empty($this->companyInfo)){
            $companyQuery = new CompanyQuery();
            $info = $companyQuery->getCompanyInfo([
                'userid' => $this->userid,
                'username' => $this->username
            ]);
            if(empty($info)){
                return [];
            }
            //企业类型
            $this->companyInfo = $info;
            if(!empty($info['mode'])){
                $this->companyInfo['mode'] = explode(',',$info['mode']);
            }
            //所在地区
            $areaQuery = new AreaQuery();
            $this->companyInfo['area'] = $areaQuery->getNameWithParent($info['areaid']);
            //商家验证
            if((new CompanyValidateQuery())->getValidateStatus($this->userid) == CompanyValidateQuery::VALIDATED_STATUS){
                $this->companyInfo['isValidated'] = true;
            }else{
                $this->companyInfo['isValidated'] = false;
            }
            //是否VIP
            if($info['groupid'] == CompanyQuery::VIP_GROUPID){
                $this->companyInfo['isVip'] = true;
            }else{
                $this->companyInfo['isVip'] = false;
            }
        }
        return $this->companyInfo;
    }

    private function buildNewsShowLinkurl($itemid){
        return $this->newsUrl . 'itemid-'.$itemid.'.shtml';
    }

    public function buildNewsList($list){
        $result = [];
        foreach($list as $item){
            if(!empty($item['itemid'])){
                $item['linkurl'] = $this->buildNewsShowLinkurl($item['itemid']);
                $result[] = $item;
            }
        }
        return $result;
    }

    public function getNews($page = 1,$pagesize = 10 ,$field = '*'){
        if(!$this->isSetUser()) return [];

        $newsQuery = new NewsQuery();
        $lists = $newsQuery->getList(
            ['status' => NewsQuery::CHECKED_STATUS , 'username'=>$this->username],
            $page , $pagesize , $field);
        if($lists){
            return $this->buildNewsList($lists);
        }else{
            return [];
        }
    }

    public function getContent(){
        if(!$this->isSetUser()) return [];

        return (new CompanyDataQuery())->getContent($this->userid);
    }

    public function getMemberInfo(){
        if(!$this->isSetUser()) return [];

        $member = (new MemberQuery())->getMemberInfo(['userid' => $this->userid]);
        if(empty($member['gender'])){
            $member['gender'] = '女士';
        }else{
            $member['gender'] = '男士';
        }
        return $member;
    }

    public function getLinks(){
        if(!$this->isSetUser()) return [];

        return (new LinkQuery())->getLinksByUser($this->username , 1, 9,'title,linkurl');
    }

    public function getRecommendCompany(){
        if(!$this->isSetUser()) return [];

        $companyQuery = new CompanyQuery();
        $companyDb = $companyQuery->getDb(CompanyQuery::TABLE_NAME);
        return $companyDb->field('company,linkurl')
            ->where(['userid' => $this->userid],'<')->where(['company'=>''],'<>')
            ->limit(0,9)->order('userid desc')->select();
    }

    public function mallTypeRewrite(array $item = []){
        $typeStr = '';
        $pageStr = '';
        if(!empty($item['typeid'])){
            $typeStr = 'typeid-'.$item['typeid'];
        }
        if(!empty($item['page'])){
            if(!empty($typeStr)) $pageStr = '-';
            $pageStr .= 'page-'.$item['page'];
        }
        return $this->mallUrl .$typeStr.$pageStr.'.shtml';
    }

    public function buildMallTypeLink(array $type){
        $result = [];
        foreach($type as $t){
            $item = $t;
            if(!empty($t['typeid'])){
                $item['linkurl'] = $this->mallTypeRewrite($t);
            }
            if(empty($t['price']) || (int)$t['price'] == 0){
                $item['price'] = '面议';
            }
            $result[] = $item;
        }
        return $result;
    }

    public function getMallType(){
        if(!$this->isSetUser()) return [];

        $result = (new TypeQuery())->getMallType($this->userid);
        if($result){
            return $this->buildMallTypeLink($result);
        }else{
            return [];
        }
    }

    public function newsTypeRewrite(array $item){
        $typeStr = '';
        $pageStr = '';
        if(!empty($item['typeid'])){
            $typeStr = 'typeid-'.$item['typeid'];
        }
        if(!empty($item['page'])){
            if(!empty($typeStr)) $pageStr = '-';
            $pageStr .= 'page-'.$item['page'];
        }
        return $this->newsUrl .$typeStr.$pageStr.'.shtml';
    }

    public function getValidatedLicense(){
        return (new CompanyValidateQuery())->getData($this->userid,'business_license,product_license');
    }

    public function getHonor($page = 1,$pagesize = 10){
        return (new HonorQuery())->getHonor($this->username,$page,$pagesize);
    }


}

?>