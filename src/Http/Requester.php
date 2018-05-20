<?php
/**
 * Created by PhpStorm.
 * User: caojiayuan
 * Date: 2018/5/20
 * Time: 下午4:29
 */

namespace CaoJiayuan\Io\Http;


interface Requester
{
    public function request($method, $path, $data = []);

}