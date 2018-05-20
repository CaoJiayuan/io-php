<?php
/**
 * Created by PhpStorm.
 * User: caojiayuan
 * Date: 2018/5/20
 * Time: 下午4:20
 */

namespace CaoJiayuan\Io\Token;


interface Provider
{
    public function getToken(): string;

}