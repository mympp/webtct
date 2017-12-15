<?php
namespace models\helpers\view;

//友情链接
class FriendLink extends View
{
    public $title = '友情链接：';
    public $titleOptions = [];
    public $linkData = [];
    public $linkDataOptions = [];

    /**
     * 设置友情链接的标题
     * @param string $titleName 标题内容 ， 例子：友情链接
     * @param array $additions 标题附加属性, 例子 ： ['class' => 'links-hd']
     * @return $this
     */
    public function setTitle($titleName = '' ,array $additions = []){
        if(!empty($titleName)){
            $this->title = $titleName;
        }
        if(!empty($additions)){
            $this->titleOptions = $additions;
        }
        return $this;
    }

    /**
     * 设置友情链接显示数据
     * @param array $data 链接数据 ,
     * 例子：[
     *  ['title' => '天成医疗网' ,'linkurl' => '#'],
     *  ['title' => '百度', 'linkurl' => '#']
     * ]
     *
     * @param array $additions 数据显示附加元素
     * 例子：[
     *  'div' => ['class' => 'class'],
     *  'a' => ['target' => '_blank'],
     * ]
     *
     * @return $this
     */
    public function setLinkData(array $data , array $additions = []){
        $this->linkData = $data;

        if(!empty($additions)){
            $this->linkDataOptions = $additions;
        }
        return $this;
    }

    /**
     * @param array $additions 友情链接最外层附加元素
     * 例子：['div' => ['class' => 'class']]
     * @return string
     */
    public function buildFriendLink(array $additions = []){
        if(empty($this->linkData)) return '';

        $dom = parent::createDocument();

        $divAttribute = isset($additions['div']) && is_array($additions['div']) ? $additions['div'] : [];
        $divElement = parent::createElement($dom,'div','',$divAttribute);

        $titleElement = parent::createElement($dom,'div',$this->title,$this->titleOptions);
        $divElement->appendChild($titleElement);

        $dataDivAttribute = isset($this->linkDataOptions['div']) ? $this->linkDataOptions['div'] : [];
        $dataElement = parent::createElement($dom,'div','',$dataDivAttribute);
        $aAttribute = isset($this->linkDataOptions['a']) ? $this->linkDataOptions['a'] : [];
        foreach($this->linkData as $item){
            $aAttribute['href'] = $item['linkurl'];
            $aAttribute['title'] = $item['title'];
            $aElement = parent::createElement($dom,'a',$item['title'],$aAttribute);
            $dataElement->appendChild($aElement);
        }
        $divElement->appendChild($dataElement);

        return parent::getHtml($dom);
    }
}

?>