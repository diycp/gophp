<?php

namespace gophp\session;

abstract class contract
{


    abstract public function set($key, $value, $expire = null);

    abstract public function has($key);

    abstract public function get($key);

    abstract public function delete($key);

    abstract public function clean();


}