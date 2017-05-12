<?php

function smarty_function_include_file($params, &$smarty)
{

    // 获取默认视图文件后缀
    $view_suffix = \gophp\config::get('view')['smarty']['template_suffix'];

    // 拼装完整视图文件
    $view_file   = VIEW_PATH . '/'. $params['name'] . '.' . $view_suffix;

    $smarty->assign($params);

    return $smarty->fetch($view_file);

}
