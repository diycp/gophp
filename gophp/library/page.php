<?php

namespace gophp;

class page{

    protected $totalRows; // 总行数
    protected $pageRows; // 列表每页显示行数
    protected $totalPages; // 总页数
    protected $rollPage   = 10;// 分页栏每页显示的页数
    protected $nowPage = 1; // 当前页码
    protected $arguments = []; // 附加参数

    public function __construct($totalRows, $pageRows, $arguments)
    {

        $this->nowPage    = request::getParam('p', 1);

        $this->totalRows  = $totalRows; //设置总记录数
        $this->pageRows   = $pageRows;  //设置每页显示行数

        // 计算总页数
        $this->totalPages = ceil($this->totalRows / $this->pageRows);

        if(!empty($this->totalPages) && $this->nowPage > $this->totalPages) {

            $this->nowPage = $this->totalPages;

        }

        return $this;

    }

    //生成页码链接
    public function url($page, $isAbsolute = false)
    {

        $page = $page >= $this->totalPages ? $this->totalPages : intval($page);

        if($page > 0){

            return route::url('', ['p' => $page], $isAbsolute);

        }else{

            return route::url('', '', $isAbsolute);


        }

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
    public function start()
    {

        return 1;

    }
    
    //最后一页页码
    public function end()
    {

        return $this->totalPages;

    }
    
    //总页数
    public function total()
    {

        return $this->totalPages;

    }
    
    //每页显示条数
    public function pageRows()
    {
        return $this->pageRows;
    }
    

    //组装limit条件
    public function limit()
    {
        return $this->firstRow.','.$this->listRows;
    }


}
