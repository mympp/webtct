<?php
namespace source\db;

use source\config\Config;

class Db
{
    private static $_connection = null;
    private static $_modelPool = [];

    public $condition;
    protected $backup_condition;
    protected $result;
    public $field  = '*';
    public $start;
    public $pagesize;
    public $order;
    public $table;
    public $tb_pre ;
    public $errmsg;
    public $join;
    protected $query_str;

    private function __construct($tableName)
    {
        $this->table = $tableName;
    }

    static public function Table($tableName)
    {

        if(isset(self::$_modelPool[$tableName])){
            return self::$_modelPool[$tableName];
        }

        if(empty(self::$_connection)){
            $dbParams = Config::getInstance()->getParams('db');
            self::$_connection = mysqli_connect($dbParams['host'],$dbParams['username'],$dbParams['password'],
                $dbParams['dbname'],$dbParams['port']);
        }

        self::$_modelPool[$tableName] = new self($tableName);
        return self::$_modelPool[$tableName];
    }

    public function query($str)
    {
        $this->query_str = $str;
        $result = mysqli_query(self::$_connection,$str);
        $this->restart();
        if($result){
            return $result;
        }else{
            $this->errmsg = mysqli_error(self::$_connection);
            return false;
        }
    }

    //增加限定条件方法
    public function order($order)
    {
        if (is_array($order)) {
            $order_str = implode(',', $order);
            $this->order = ' order by ' . $order_str;
        } else {
            $this->order = ' order by ' . $order;
        }
        return $this;
    }

    public function limit($start = 0,$pagesize = 10){
        $this->start = $start;
        $this->pagesize = $pagesize;
        return $this;
    }

    public function field($field)
    {
        if ($field == '') return $this;
        if (is_array($field)) {
            $this->field = implode(',', $field);
        } else {
            $this->field = $field;
        }
        return $this;
    }

    /**
     * join查询拼接
     * @param $join     join查询表
     * @param string $with 连接字段
     * @param string $type  值为left或right
     * @return $this
     */
    public function join($join, $with = '', $type = '')
    {
        if (in_array($type, ['left', 'right'])) {
            $this->join = $type;
        }
        $this->join .= ' join ' . $join . ' ';
        if (!empty($with)) {
            $this->join .= ' on ' . $with . ' ';
        }
        return $this;
    }

    /**
     * 数据库条件查询拼接
     * @param array  or string $where 查询条件
     * @param string $relation  查询拼接字符
     * @param bool $and 默认为与条件查询
     * @return $this
     */
    public function where($where, $relation = '=', $and = true)
    {
        if (empty($where)) {
            return $this;
        }
        $link = $and ? 'and' : 'or';
        if (empty($this->condition)) {
            $this->condition = 'where ';
        } else {
            $this->condition .= ' ' . $link . ' ';
        }
        if (is_array($where)) {
            $condition_str = array();
            foreach ($where as $k => $v) {
                if ($relation == 'in') {
                    $condition_str[] = "$k $relation ($v)";
                } else {
                    $condition_str[] = "$k $relation '$v'";
                }
            }
            $this->condition .= implode(" $link ", $condition_str);
        } else {
            $this->condition .= $where;
        }
        return $this;
    }

    /**
     * 用于模糊查询
     * @param  array  $where 搜索条件
     * @param array  $and  and拼接方式，默认为 true
     * @param string $point 模糊匹配的方向,默认为all及两边都模糊匹配，其他可选值为left和right
     * @return  $this
     */
    public function likeWhere($where,$and = true,$point = 'all'){
        if(empty($where)) return $this;
        if(!is_array($where)) return $this;
        $condition_str = [];
        foreach($where as $k => $v){
            if(empty($v)) continue;
            $str = "$k like ";
            switch($point){
                case 'left':
                    $str .= "'%$v'";
                    break;
                case 'right':
                    $str .= "'$v%'";
                    break;
                default:
                    $str .= "'%$v%'";
            }
            $condition_str[] = $str;
        }
        $link = $and === true ? ' and ' : ' or ';
        $condition = implode(' '.$link,$condition_str);
        if(empty($condition)) return $this;
        if(empty($this->condition)){
            $this->condition = ' where ';
        }else{
            $this->condition .= $link;
        }
        $this->condition .= $condition;
        return $this;
    }

    //逻辑操作方法
    public function all(){
        $str = 'select '.$this->field.' from '.$this->table.' '.$this->join.' '.$this->condition.$this->order;
        $this->result = $this->query($str);
        return $this->result();
    }

    public function select(){
        $str = 'select '.$this->field.' from '.$this->table.' '.$this->join.' '.$this->condition.$this->order.' limit '.$this->start.','.$this->pagesize;
        $this->result = $this->query($str);
        return $this->result();
    }

    public function one(){
        $str = 'select '.$this->field.' from '.$this->table.' '.$this->join.' '.$this->condition.$this->order.' limit 0,1';
        $this->result = $this->query($str);
        if($this->result == false) return '';
        $result = $this->result();
        if(empty($result[0])) return '';
        //$this->restart();
        return $result[0];
    }

    public function add($data){
        if(!is_array($data)) return false;
        $key_arr = array();
        $value_arr = array();
        foreach($data as $k => $v){
            $key_arr[] = $k;
            $value_arr[] = str_replace("'",'"',$v);
        }
        $key_str = implode(",",$key_arr);
        $value_str = implode("','",$value_arr);
        return $this->query('insert into '.$this->table."(".$key_str.") values ('".$value_str."')");
    }

    /**
     * //批量添加数据
     * @param array $key 一维数组，保存键值顺序
     * @param array $data 二维数组，保存多个添加记录信息
     * @return
     */
    public function batchAdd($key,$data){
        if(!is_array($key)) return false;
        if(!is_array($data)) return false;
        $key_str = implode(',',$key);
        $values_str = '';
        foreach($data as $dk=>$dv){
            $value_arr = [];
            foreach($key as $kk=>$kv){	//按键值的顺序排列数据
                $value_arr[] = str_replace("'",'"',$dv[$kv]);		//单引号替换为双引号
            }
            $values_str .= " ('".implode("','",$value_arr)."'),";
        }
        $values_str = substr($values_str , 0 ,-1);
        return $this->query("insert into ".$this->table." (".$key_str.") values ".$values_str);
    }

    public function edit($data , $condition = null){
        if(!is_array($data)) return false;
        if(!empty($condition)) $this->where($condition);
        $update_str = ' set ';
        foreach($data as $k=>$v){
            $update_str .=' '.$k." = '".$v."' ,";
        }
        $update_str = substr($update_str,0,-1);
        return $this->query('update '.$this->table.$update_str.$this->condition);
    }

    public function delete($condition = null){
        if(!empty($condition)) $this->where($condition);
        return $this->query('delete from '.$this->table.' '.$this->condition);
    }

    public function getInsertId(){
        return mysqli_insert_id($this->con);
    }

    public function count($name = 'count'){
        $this->field("count(*) as $name");
        return $this->one();
    }

    public function close(){
        mysqli_close($this->con);
    }

    public function getQueryStr(){
        return $this->query_str;
    }

    public function getCondition(){
        $condition = str_replace('where','',$this->backup_condition);
        return $condition;
    }

    //结果处理
    public function restart(){
        $this->field = '*';
        $this->backup_condition = $this->condition;
        $this->condition = '';
        $this->start = 0;
        $this->pagesize = 10;
        $this->order = '';
        $this->join = '';
    }

    protected function result(){
        if(!$this->result) return false;
        $back = array();
        while($r = mysqli_fetch_assoc($this->result)){
            $back[] = $r;
        }
        return $back;
    }
}