<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/21
 * Time: 下午3:42
 */

namespace CaoJiayuan\Io;


use CaoJiayuan\Io\Http\Requester;
use CaoJiayuan\Io\Http\TokenRequester;

class TokenProvider
{

    /**
     * @var TokenRequester
     */
    protected $requester;

    protected $token;

    public function __construct(TokenRequester $requester)
    {
        $this->requester = $requester;
    }

    public function login($credentials, $path = '/login')
    {
        if ($this->token) {
            return $this->token;
        }
        $token = $this->requester->request(Requester::METHOD_POST, $path, $credentials);

        return $this->parseToken($token);
    }

    public function parseToken($token)
    {
        $this->token = new Token($token['token'], $token['exp']);

        return $token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function loadTokenFromCache()
    {

    }
}
