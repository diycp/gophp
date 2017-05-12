<?php

function smarty_function_plugin_path($params, &$smarty)
{

    extract($params);

    return STATIC_URL . '/plugin';
    
}
