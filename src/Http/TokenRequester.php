<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/21
 * Time: 下午6:07
 */

namespace CaoJiayuan\Io\Http;


interface TokenRequester extends Requester
{
    public function setToken($token);

    public function getToken();
}
