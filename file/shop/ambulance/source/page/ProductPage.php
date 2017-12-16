<?php
namespace source\page;

use source\db\Db;

class ProductPage extends BasePage
{
    public function plist($request, $response, $args)
    {
        $kw = $request->getParam('kw');
        if(!empty($kw)){
            return $this->render('product-list',[
                'Malls' => Db::Table('tc_mall')->where(['username'=> $this->username])->likeWhere(['title' => $kw])->all(),
                'typename' => '相关搜索',
            ]);
        }

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
            'htmlTitle' => $typename .'救护车|医疗车|体检车_配置方案报价_天成医疗车',
            'htmlKeywords' => "{$typename}救护车,{$typename}医疗车,{$typename}体检车",
            'htmlDescription' => "天成医疗车方案，为你您提供专业的{$typename}救护车配置方案，欢迎点击询价！",
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

        $type = Db::Table('tc_type')->field('typename')->where(['typeid' => $mall['mycatid']])->one();

        $content = Db::Table('tc_mall_data')->where(['itemid' => $itemid])->one();
        return $this->render('product-show',[
            'mall' => $mall,
            'content' => $content,
            'category' => $this->getType(),
            'malls' => $this->getMalls(),
            'typename' => $type['typename'],
            'reTypename' => str_replace('系列','',$type['typename']),
            'htmlTitle' => "{$mall['title']}配置方案报价_天成医疗车",
            'htmlKeywords' => "{$mall['title']}配置方案,{$mall['title']}报价",
            'htmlDescription' => "天成医疗车方案，为你您提供专业的{$mall['title']}配置方案，欢迎点击询价！",
        ]);
    }

}

