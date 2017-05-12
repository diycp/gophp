<?php

function smarty_function_image_path($params, &$smarty)
{

    extract($params);

    return STATIC_URL . '/image';
    
}
