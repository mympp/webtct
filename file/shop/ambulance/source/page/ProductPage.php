<?php
namespace source\page;

use source\db\Db;

class ProductPage extends BasePage
{
    private function getRecommend(){
        return Db::Table('tc_mall')->field('itemid,title,thumb')->where(['status' => 3 ,'username' => $this->username])
            ->order('itemid desc')->limit(0,6)->select();
    }

    public function plist($request, $response, $args)
    {
        $typeid = $request->getAttribute('typeid');
        if(empty($typeid)){
            $typeid = 0;
            $category = $this->getType();
            $typename = '';
        }else{
            $category = [];
            $type = Db::Table('tc_type')->where(['typeid'=>$typeid])->one();
            $typename = $type['typename'];
        }


        return $this->render('product-list',[
            'category' => $category,
            'Malls' => $this->getMalls($typeid),
            'typeid' => $typeid,
            'typename' => $typename,
        ]);
    }

    public function product($request, $response, $args)
    {
        $itemid = $request->getAttribute('itemid');
        if(empty($itemid)){
            header('Location:/');
            exit;
        }

        $mall = Db::Table('tc_mall')->where(['itemid' => $itemid,'status' => 3])->one();
        if(!$mall){
            header('Location:/');
            exit;
        }

        $content = Db::Table('tc_mall_data')->where(['itemid' => $itemid])->one();
        return $this->render('product-show',[
            'mall' => $mall,
            'content' => $content,
            'category' => $this->getType(),
            'malls' => $this->getMalls(),
        ]);
    }

    public function getLeftNav(){

        return $this->render('product-left',[
            'category' => $this->getType(),
            'malls' => $this->getRecommend(),
        ]);
    }
}