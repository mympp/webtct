<?php
namespace models\helpers\widget\sitemap;

use models\config\Config;
use models\module\baseModule;


class siteMap
{
    const MAX_URL_NUM = 10000;

    private $filePath = './sitemap';    //sitemap文件保存目录

    /**
     * @param $url ['http://www.t_tecenet.com/gongsi/so-1954-387-0-1.html','http://www.t_tecenet.com/gongsi/so-1954-387-0-2.html']
     * @param  int $module module模块
     * @param string $type 类型
     */
    public function buildSiteMap($url, $module, $type = '', $key = '', $changefrep = 'Daily')
    {
        global $DT_ROOT;
        global $DT_PATH;
            Config::getConfig('baseRoot');

        $data = '<?xml version="1.0" encoding="UTF-8"?>';
        $data .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $today = date('Y-m-d', time());
        foreach ($url as $v) {
            $data .= '<url>';
            $data .= "<loc>$v</loc>";
            $data .= "<lastmod>$today</lastmod>";
            $data .= "<changefreq>$changefrep</changefreq>";
            $data .= '<priority>0.8</priority>';
            $data .= '</url>';
        }
        $data .= "</urlset>";
        $path = $this->filePath . '/' . $module;
        if (!empty($type)) $path .= '/' . $type;
        $filename = $module . 'Sitemap' . $type . $key . '.xml';
        self::mkPathDir($path);
        return @file_put_contents($path . '/' . $filename, $data);
    }


    //入口文件内容
    public function updateIndexSiteMap()
    {
        $files = [];
        $xmls = $this->readAllFiles($this->filePath);
        $data = '<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $today = date('Y-m-d H:i', time());
        foreach ($xmls as $v) {
            $data .= '<sitemap>';
            $data .= "<loc>$v</loc>";
            $data .= "<lastmod>$today</lastmod>";
            $data .= '</sitemap>';
        }
        $data .= '</sitemapindex>';
        $data = str_replace('./', 'http://www.tecenet.com/', $data);
        @file_put_contents('./sitemap.xml', $data);

    }

    /**
     * 遍历所有xml文件并生成sitemap
     * @param string $dir
     * @return array
     */
    private function readAllFiles($dir = '')
    {
        $files = [];
        if (is_dir($dir)) {
            if ($handle = opendir($dir)) {  //遍历siteMap目录
                while (false !== ($file = readdir($handle))) {
                    $ifDir = $dir . '/' . $file;
                    if (($file != '.') && ($file != '..')) {  //不是..或者.才遍历文件夹
                        if (is_dir($ifDir)) {  //如果文件还是文件夹
                            $filesIn = self::readAllFiles($ifDir);  //对子目录便利
                            $files = array_merge($files, $filesIn);  //合并数组
                        } else {
                            if (pathinfo($ifDir, PATHINFO_EXTENSION) == 'xml') {  //当后缀是.xml才要
                                $files[] = $ifDir;
                            }
                        }
                    }


                }
                closedir($handle);
            }
        }
        return $files;
    }

    /**
     * 递归生成目录
     * @param $dir
     */
    public function mkPathDir($dir)
    {
        if (is_dir($dir) || @mkdir($dir, 0777)) {
        } else {
            self::mkPathDir(dirname($dir));
            @mkdir($dir, 0777);
        }
    }

    /**
     * 生成sitemap
     * @param string $moduelName 传入需要生成sitemap的module
     * @throws \models\module\Exception
     */
    public function start($moduelName)
    {
        $moduleObject = baseModule::moduleInstance($moduelName);
        if (method_exists($moduleObject, 'buildSiteMap')) {
            call_user_func(array($moduleObject, 'buildSiteMap'));
            $this->updateIndexSiteMap();  //最后更新首页的sitemap文件
        }
    }
}