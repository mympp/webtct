<?php
namespace models\helpers\widget\cdn;

use models\config\Config;

class QiniuCdn
{
    private $_cdnUrl;
    private $_baseUrl;
    private $_watermarkPic;
    private $_watermarkParams;

    public function __construct()
    {
        $this->_cdnUrl = Config::getConfig('cdn','Qiniu','baseUrl');
        $this->_baseUrl = Config::getConfig('baseUrl');
        $this->_watermarkPic = Config::getConfig('cdn','watermarkPic');
        $this->_watermarkParams = Config::getConfig('cdn','Qiniu','watermark');
    }

    public function waterMark($html)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument;
        $dom->loadHTML(self::appendContentEncoding($html));
        $domXpath = new \DOMXPath($dom);

        $imgNodes = $domXpath->query('//img');

        //水印配置
        $paramsStr = '';
        foreach($this->_watermarkParams as $key => $value){
            $paramsStr .= "/$key/$value";
        }

        if ($imgNodes->length) {
            foreach ($imgNodes as $imgNode) {
                /* @var $imgNode \DOMElement */
                $src = $imgNode->getAttribute('src');
                if ($src) {
                    $newSrc = $src . '';
                    $newSrc = str_replace($this->_baseUrl,$this->_cdnUrl,$newSrc);
                    $newSrc .= '?watermark/1/image/'.base64_encode($this->_watermarkPic).$paramsStr;

                    $imgNode->setAttribute('src', $newSrc);
                }
            }
        }
        return $dom->saveHTML();

    }

    /**
     * @param string $content
     *
     * @return string
     */
    public static function appendContentEncoding( $content )
    {
        $encoding = mb_detect_encoding($content, 'UTF-8 ,gb2312, GBK, EUC-CN, cp936');
        if ($encoding) {
            return '<meta http-equiv="Content-Type" content="text/html; charset=' . $encoding . '">' . $content;
        }

        return $content;
    }
}

?>