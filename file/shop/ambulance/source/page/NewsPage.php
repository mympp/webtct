<?php
namespace source\page;

use source\db\Db;

class NewsPage extends BasePage
{
    public function nlist(){
        return $this->render('news-list',[
            'news'=> $this->getNews(),
            'typename' => '新闻中心',
            'htmlTitle' => '救护车|医疗车|体检车_新闻资讯_天成医疗车',
            'htmlKeywords' => "救护车新闻,医疗车新闻,体检车新闻",
            'htmlDescription' => "天成医疗车方案，为你您提供专业的救护车最新资讯！",
        ]);
    }

    public function news($request, $response, $args){
        $itemid = $request->getAttribute('itemid');
        if(empty($itemid)){
            header('Location:/');
            exit;
        }

        $news = Db::Table('tc_news')
            ->field('title,keyword,introduce')
            ->where(['status' => 3,'itemid' => $itemid,'username'=>$this->username])->one();

        if(empty($news)){
            header('Location:/');
            exit;
        }

        $content = Db::Table('tc_news_data')
            ->where(['itemid' => $itemid])->one();
        $news['content'] = isset($content['content']) ? $content['content'] : '';

        return $this->render('news',[
            'news' => $news,
            'typename' => '新闻中心',
            'htmlTitle' => $news['title'].'_新闻资讯_天成医疗车',
            'htmlKeywords' => $news['keyword'],
            'htmlDescription' => $news['introduce'],
        ]);
    }
}