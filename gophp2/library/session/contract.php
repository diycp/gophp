<?php

namespace gophp\session;

abstract class contract
{

    abstract function set($key, $value, $expire = null);

    abstract function has($key);

    abstract function get($key);

    abstract function delete($key);

    abstract function clean();


}