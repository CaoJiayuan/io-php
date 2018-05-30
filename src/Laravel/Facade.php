<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/30
 * Time: 下午2:16
 */

namespace CaoJiayuan\Io\Laravel;

use Illuminate\Support\Facades\Facade as Base;

class Facade extends Base
{

    /**
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'io-php.client';
    }
}
