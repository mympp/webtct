<?php
namespace models\helpers\view;

abstract class View {

    /**
     * 创建文本元素
     * @return \DOMDocument
     */
    public function createDocument(){
        return new \DOMDocument;
    }

    /**
     * 创建文本标签
     * @param \DOMDocument $dom 标签所在元素
     * @param $element 标签类型
     * @param string $content 标签内容
     * @param array $attributes 标签属性
     * @return \DOMElement
     */
    public function createElement(\DOMDocument &$dom , $element ,$content = '', $attributes = []){
        $elementDom = $dom->createElement($element,$content);
        if(!empty($attributes)){
            $this->buildAttributes($dom , $elementDom, $attributes);
        }
        $dom->appendChild($elementDom);
        return $elementDom;
    }

    /**
     * 文本标签附加属性
     * @param \DOMDocument $dom 标签所在元素
     * @param \DOMElement $element 标签对象
     * @param array $attributes 标签属性
     * @return \DOMElement
     */
    public function buildAttributes(\DOMDocument &$dom, \DOMElement &$element ,array $attributes){
        foreach($attributes as $name => $value){
            $attribute = $dom->createAttribute($name);
            $attribute->value = $value;
            $element->appendChild($attribute);
        }
        return $element;
    }

    /**
     * 获取元素文本输出
     * @param \DOMDocument $dom
     * @return string
     */
    public function getHtml(\DOMDocument &$dom){
        return $dom->saveHTML();
    }

}