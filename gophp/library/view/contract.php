<?php

namespace gophp\view;

abstract class contract
{

    protected $config;
    protected $view;
    protected $theme;

    abstract public function exists($viewFile);

    abstract public function assign($name, $value);

    abstract public function fetch($viewName);

    abstract public function display($viewName);

    public function getViewFile($viewName = null)
    {

        $suffix = $this->config['template_suffix'];

        if(!$viewName){

            $viewName = CONTROLLER_NAME . DS . ACTION_NAME;
            $viewFile = VIEW_PATH . DS . $viewName . '.' . $suffix;

        }elseif($viewName && false === strpos($viewName, '.')){

            $viewFile = VIEW_PATH . DS . $viewName . '.' . $suffix;

        }else{

            $viewFile = $viewName;

        }

        return $viewFile;

    }

}