<?php

namespace gophp;

class page{

    protected $totalRows; // 总行数
    protected $pageRows; // 列表每页显示行数
    protected $totalPages; // 总页数
    protected $nowPage = 1; // 当前页码
    protected $pageParam; // 分页参数
    protected $arguments = []; // 附加参数

    public function __construct($totalRows, $pageRows, $arguments)
    {

        $this->pageParam = config::get('http', 'page_param');

        $this->nowPage   = request::getParam($this->pageParam, 1);

        $this->totalRows = $totalRows; //设置总记录数
        $this->pageRows  = $pageRows;  //设置每页显示行数

        // 计算总页数
        $this->totalPages = ceil($this->totalRows / $this->pageRows);

        if(!empty($this->totalPages) && $this->nowPage > $this->totalPages) {

            $this->nowPage = $this->totalPages;

        }

        return $this;

    }

    //生成页码链接
    public function url($page)
    {

        $page = $page >= $this->totalPages ? $this->totalPages : intval($page);

        if($page > 0){

            return route::url('', [$this->pageParam => $page]);

        }else{

            return route::url('', '');

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

    // 数字导航数组
    public function numbers($length = 5)
    {

        $numbers = [];

        $per = floor($length / 2);
        $min = $this->nowPage - $per;

        if ($length % 2) {

            $max = $this->nowPage + ceil($length / 2) - 1;

        } else {

            $max = $this->nowPage + $per - 1;

        }

        if ($max > $this->totalPages) {

            $min -= $max - $this->totalPages;

        }

        if ($min < 1) {

            $max += 1 - $min;

        }

        $max > $this->totalPages && $max = $this->totalPages;

        $min < 1 && $min = 1;

        foreach ( range($min, $max) as $k => $v) {

            $numbers[$k]['num'] = $v;
            $numbers[$k]['url'] = $this->url($v);

        }

        return $numbers;

    }
    
    //每页显示条数
    public function pageRows()
    {

        return $this->pageRows;

    }

}
