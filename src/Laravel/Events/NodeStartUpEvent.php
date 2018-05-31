<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/31
 * Time: 上午9:51
 */

namespace CaoJiayuan\Io\Laravel\Events;

use Illuminate\Http\Request;

class NodeStartUpEvent
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
