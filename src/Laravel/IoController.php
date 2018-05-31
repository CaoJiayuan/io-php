<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/31
 * Time: 上午9:48
 */

namespace CaoJiayuan\Io\Laravel;


use CaoJiayuan\Io\Laravel\Events\NodeStartUpEvent;
use Illuminate\Http\Request;

class IoController
{

    public function startUp(Request $request)
    {
        event(new NodeStartUpEvent($request));

        return 'ok';
    }
}
