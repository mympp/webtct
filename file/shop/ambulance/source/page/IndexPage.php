<?php
namespace source\page;

use source\db\Db;

class IndexPage extends BasePage
{
    public function index()
    {
        $companyDataDb = Db::Table('tc_company_data');
        $content = $companyDataDb->where(['userid' => $this->userid])->one();

        $malls = $this->getMalls(0,14);
        $topMall = current($malls);
        $secondMall = next($malls);

        $topMallPic = [];
        $secondMallPic = [];
        for($i = 0 ;$i < 6;$i++){
            $topMallPic[] = next($malls);
            $secondMallPic[] = next($malls);
        }

        return $this->render('index',[
            'introduce' => $content['content'],
            'topMall' => $topMall,
            'topMallPic' => $topMallPic,
            'secondMall' => $secondMall,
            'secondMallPic' => $secondMallPic,
            'bottomMalls' => $this->getMalls(2916,3,'itemid desc'),
            'middleMalls' => $this->getMalls(2922,3,'itemid desc')
        ]);
    }

    public function test(){
        var_dump($this->getMalls(0,14));
        /*
        $articles = Db::Table('tc_news')->field('itemid')->where(['status' => 3])->all();
        $urls = [];
        foreach($articles as $item){
            $urls[] = 'http://wap.tecenet.com/share/show-'.$item['itemid'].'.html';
            if(count($urls) > 1999){
                $this->push($urls);
                $urls = [];
            }
            $this->push($urls);
        }
           */
    }


    public function render($template ,$params = []){
        $params['isIndexPage'] = true;
        return parent::render($template,$params);
    }


    private function push($urls){
            $api = 'http://data.zz.baidu.com/urls?appid=1582200663323739&token=DsvmRmn9zNlcRjjk&type=batch';
            $ch = curl_init();
            $options =  array(
                CURLOPT_URL => $api,
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POSTFIELDS => implode("\n", $urls),
                CURLOPT_HTTPHEADER => array('Content-Type: text/plain'),
            );
            curl_setopt_array($ch, $options);
            var_dump(curl_exec($ch));
            echo '<br/>';
    }

}

