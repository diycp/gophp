<?php

namespace app;

use gophp\schema;

class database {


    public static function backup()
    {

        $tables = schema::instance()->getTables();

        $path = RUNTIME_PATH . '/data/';

        $file = $path . date('YmdHis') . '_all.sql';

        foreach ($tables as $table) {
            // 如果存在则删除表

            echo <<<EOF
<tr>
                                <td>1</td>
                                <td>database.sql</td>
                                <td>1M</td>
                                <td>2017-09-21 23:00:00</td>
                                <td>@mdo</td>
                            </tr>
EOF;
            ;

            ob_flush();
            flush();

            sleep(1);//暂停1秒

        }

    }

}