<?php

namespace gophp;

class page{

    public $firstRow; // 起始行数
    public $listRows; // 列表每页显示行数
    public $parameter; // 分页跳转时要带的参数
    public $totalRows; // 总行数
    public $totalPages; // 分页总页面数
    public $rollPage   = 10;// 分页栏每页显示的页数
	public $lastSuffix = true; // 最后一页是否显示总页数

    private $p       = 'p'; //分页参数名
    private $url     = ''; //当前链接URL
    private $nowPage = 1;
    
    /**
     * 架构函数
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows, $listRows, $parameter = array()) {
        C('VAR_PAGE') && $this->p = C('VAR_PAGE'); //设置分页参数名称
        /* 基础设置 */
        $this->totalRows  = $totalRows; //设置总记录数
        $this->listRows   = $listRows;  //设置每页显示行数
        $this->parameter  = empty($parameter) ? $_GET : $parameter;
        $this->nowPage    = empty($_GET[$this->p]) ? 1 : intval($_GET[$this->p]);
        $this->nowPage    = $this->nowPage>0 ? $this->nowPage : 1;
        $this->firstRow   = $this->listRows * ($this->nowPage - 1);
        
        /* 计算分页信息 */
        $this->totalPages = ceil($this->totalRows / $this->listRows); //总页数
        if(!empty($this->totalPages) && $this->nowPage > $this->totalPages) {
            $this->nowPage = $this->totalPages;
        }
        
        /* 生成URL */
        $this->parameter[$this->p] = '[PAGE]';
        $module       = strtolower(MODULE_NAME);
        $controller  = strtolower(CONTROLLER_NAME );
        $action      = strtolower(ACTION_NAME);
        
        $default_module= C('DEFAULT_MODULE');
        if ($default_module == $module) {
            $this->url   = U($controller.'/'.$action, $this->parameter);
        } else {
            $this->url   = U($module.'/'.$controller.'/'.$action, $this->parameter);
        }
        
    }



    //生成链接
    public function url($page){
        return str_replace(urlencode('[PAGE]'), $page, $this->url);
    }
    
    //当前页码
    public function now()
    {
        return $this->nowPage;
    }
    
    //上一页页码
    public function prev()
    {
        return ($this->nowPage - 1) > 0 ? ($this->nowPage - 1) : 1;
    }
    
    //下一页页码
    public function next()
    {
        return ($this->nowPage + 1) > $this->totalPages ? $this->totalPages : ($this->nowPage + 1);
    }
    
    
    //第一页页码
    public function start(){
        return 1;
    }
    
    //最后一页页码
    public function end(){
        return $this->totalPages;
    }
    
    //总页数
    public function total(){
        return $this->totalPages;
    }
    
    //每页显示条数
    public function per_num(){
        return $this->listRows;
    }
    

    //组装limit条件
    public function limit(){
        return $this->firstRow.','.$this->listRows;
    }

    //返回数字分页数组
    public function page_list($num = null) {

        $page_array = array();
        
        if ($num === null) {
            $page_array = range(1, $this->totalPages);
        } else{
            $per = floor($num / 2);
            $min = $this->nowPage - $per;
            
            if ($num % 2) {
                $max = $this->nowPage + ceil($num / 2) - 1;
            } else {
                $max = $this->nowPage + $per - 1;
            }
            
            if ($max > $this->totalPages) {
                $min -= $max - $this->totalPages;
                $max = $this->totalPages;
            } elseif ($min < 1) {
                $max += 1 - $min;
                $min = 1;
            }
            
            $max > $this->totalPages && $max = $this->totalPages;
            $min < 1 && $min = 1;
            
            $page_array = range($min, $max);
            
            
        }
        
        foreach ($page_array as $k => $v) {
            $page_list[$k]['num'] = $v;
            $page_list[$k]['url'] = $this->url($v);
        }
        
        return $page_list;
        
    }
}
