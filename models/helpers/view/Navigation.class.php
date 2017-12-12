<?php
namespace models\helpers\view;

class Navigation extends View
{
    /**
     * 构建导航
     * @param array $item 内容数据 ,
     * 事例：[
     *  ['name'=>'首页','url'=>'http://www.tecenet.com/' ],
     *  ['name'=>'产品库' ,'url' => 'http://www.tecenet.com/chanpin' ]
     * ]
     *
     * @param array $additions 附加属性内容
     * 事例：[
     *  'div' => ['class' => 'crumb' , 'id' => 'navigation'],
     *  'a' => [ 'target' => '_blank']
     * ]
     *
     * @return string
     */
    public function buildNavigation(array $item , array $additions = [])
    {
        $dom = parent::createDocument();
        $divAttribute = isset($additions['div']) && is_array($additions['div']) ? $additions['div'] : [];
        $divElement = parent::createElement($dom,'div','',$divAttribute);
        $aAttribute = isset($additions['a']) && is_array($additions['a']) ? $additions['a'] : [];

        $itemCount = count($item);
        $num = 1;
        foreach($item as $link){
            if(isset($link['name']) && isset($link['url'])){
                $aAttribute['href'] = $link['url'];
                $aAttribute['title'] = $link['name'];
                $aElement = parent::createElement($dom,'a',$link['name'],$aAttribute);
                $divElement->appendChild($aElement);
                if($itemCount != $num){
                    $spanElement = parent::createElement($dom ,'span','&gt;');
                    $divElement->appendChild($spanElement);
                }
                $num++;
            }else{
                continue;
            }
        }
        return parent::getHtml($dom);
    }
}
