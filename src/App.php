<?php
/**
 * Created by PhpStorm.
 * User: caojiayuan
 * Date: 2018/5/20
 * Time: 下午4:24
 */

namespace CaoJiayuan\Io;


use CaoJiayuan\Io\Http\SimpleRequester;

class App
{


    public static function createSimpleClient($host, array $credentials): Client
    {
        $requester = new SimpleRequester($host);
        $client = new Client($requester);

        $client->setTokenProvider(new TokenProvider($requester));

        $client->setCredentials($credentials);

        return $client;
    }
}
