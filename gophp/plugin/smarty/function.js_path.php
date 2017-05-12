<?php

function smarty_function_js_path($params, &$smarty)
{

    extract($params);

    return STATIC_URL . '/js';
    
}
