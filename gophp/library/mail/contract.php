<?php

namespace gophp\mail;

abstract class contract
{

    protected $config;
    protected $mail;

    abstract function __construct($config);

    abstract function from($from, $name);

    abstract function to($to, $name);

    abstract function attachment($path, $name);

    abstract function title($title);

    abstract function body($body);

    abstract function send();

}