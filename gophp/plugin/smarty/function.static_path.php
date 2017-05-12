<?php

function smarty_function_static_path($params, &$smarty)
{

    extract($params);

    return STATIC_URL;
    
}
