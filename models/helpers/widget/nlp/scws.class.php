<?php
namespace models\helpers\widget\nlp;

defined('IN_DESTOON') or exit('Access Denied');

//scws分词处理工具，使用需要开启scws拓展
class scws
{
    protected $scws;
    public $word;

    function __construct($str = '', $charset = 'utf8')
    {
        if (!function_exists('scws_new')) return false;  //scws扩展未开启
        $this->scws = scws_new();
        $this->scws->set_charset($charset);
        $this->word = $str;
    }

    public function checkScwsExist()
    {
        return is_null($this->scws) ? false : true;
    }

    public function setWord($str = '')
    {
        $this->word = $str;
    }

    public function getSeg($stopWord = false)
    {
        $this->scws->send_text($this->word);
        $arr = array();

        if ($stopWord) {
            $stopWordArr = $this->getStopWord();
        }
        while ($temp = $this->scws->get_result()) {
            foreach ($temp as $k => $v) {
                //$length = mb_strlen($v['word'],$charset);
                //if($length < 2) continue;
                if ($stopWord && in_array(trim($v['word']),$stopWordArr)) {
                    $arr[] = '***';
                } else {
                    $arr[] = $v['word'];
                }
            }
        }
        if (empty($arr)) $arr[] = $this->word;
        return $arr;
    }

    //只获取指定词性的分词
    public function getSegByAttr($attr = '')
    {
        if (empty($attr)) return $this->getSeg();

        $this->scws->send_text($this->word);
        $arr = array();

        while ($temp = $this->scws->get_result()) {
            foreach ($temp as $k => $v) {
                if ($v['attr'] == $attr) {
                    $arr[] = $v['word'];
                }
            }
        }
        return $arr;
    }

    public function getStopWordInContent($content){
        $result = [];
        $this->scws->send_text($content);
        while ($temp = $this->scws->get_result()) {
            foreach ($temp as $k => $v) {
                if(in_array(trim($v['word']),$this->getStopWord())){
                    $result[] = $v['word'];
                }
            }
        }
        return $result;
    }


    public function getStopWord()
    {
        if (!file_exists(__DIR__ . '/stop_word.txt')) {
            return false;
        }
        $stopWord = file(__DIR__ . '/stop_word.txt');
        $result = [];
        foreach($stopWord as $word){
            $result[] = trim($word);
        }
        return $result;
    }

    function __destruct()
    {
        if (!empty($this->scws)) $this->scws->close();
    }

}

?>