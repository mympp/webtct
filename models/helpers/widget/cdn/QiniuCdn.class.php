<?php
namespace models\helpers\widget\cdn;

class QiniuCdn
{
    private $_cdnUrl = 'http://img.tecenet.com/';
    private $_baseUrl = 'http://www.tecenet.com/';
    private $_watermarkPic = 'http://www.tecenet.com/skin/teceskin/images/watermark.JPG';

    public function waterMark($html)
    {
        libxml_use_internal_errors(true);
        $dom = new \DOMDocument;
        $dom->loadHTML(self::appendContentEncoding($html));
        $domXpath = new \DOMXPath($dom);

        $imgNodes = $domXpath->query('//img');
        if ($imgNodes->length) {
            foreach ($imgNodes as $imgNode) {
                /* @var $imgNode \DOMElement */
                $src = $imgNode->getAttribute('src');
                if ($src) {
                    $newSrc = $src . '';
                    $newSrc = str_replace($this->_baseUrl,$this->_cdnUrl,$newSrc);
                    $newSrc .= '?watermark/1/image/'.base64_encode($this->_watermarkPic).'/gravity/SouthEast/dx/2/dy/2';

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