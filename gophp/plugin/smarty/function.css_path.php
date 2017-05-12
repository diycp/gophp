<?php

function smarty_function_css_path($params, &$smarty)
{

    extract($params);

    return STATIC_URL . '/css';
    
}
