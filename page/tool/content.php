
<?php
use database\db;

require_once __DIR__.'/autoload.php';

$article = new \database\db('tc_article_21');
$articleData = new \database\db('tc_article_data_21');
$urlDb = new \database\db('img_url');

$maxId = $articleData->field('max(itemid) as max')->one();

$addtimeLimit = strtotime('2017-1-1');
for ($i = 1; $i < $maxId['max']; $i++) {
    if (!$article->where(['itemid' => $i])
        ->where(['addtime' => $addtimeLimit], '<')->one()
    ) {
        continue;
    }

    $item = $articleData->where(['itemid' => $i,])->one();
    if ($item) {
        $content = $item['content'];
        $dom = new \DOMDocument();

        $encode = mb_detect_encoding($content, ["ASCII", 'UTF-8', 'GB2312', 'GBK', 'BIG5']);
        $content = '<meta http-equiv="Content-Type" content="text/html; charset=' . $encode . '">' . $content;
        $dom->loadHTML($content);

        $domXpath = new \DOMXPath($dom);
        $imgNodes = $domXpath->query('//img');

        if ($imgNodes->length) {

            foreach ($imgNodes as $node) {
                $src = $node->getAttribute('src');
                $urlDb->add(['url'=>$src]);
                $node->parentNode->removeChild($node);
            }
            $page = $dom->saveXML();
            $result = contentReplace($page);

            $articleData->where(['itemid'=>$item['itemid']])->edit(['content'=>$result]);
        }
    }
}

function contentReplace($page)
{
    $page = str_replace('<?xml version="1.0" encoding="UTF-8" standalone="yes"?>', '', $page);
    $page = str_replace('<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">', '', $page);
    $page = str_replace('<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/></head><body>', '', $page);
    $page = str_replace('</body>', '', $page);
    $page = str_replace('</html>', '', $page);
    return $page;
}

?>