<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/31
 * Time: 上午9:51
 */

namespace CaoJiayuan\Io\Laravel\Events;


use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;

class NodeStartUpEvent
{
    use Dispatchable;

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
