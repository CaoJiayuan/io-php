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

    protected $tokenFile = __DIR__ . '/../__token';

    public function __construct(TokenRequester $requester)
    {
        $this->requester = $requester;
    }

    public function login($credentials, $path = '/login')
    {
        $this->loadTokenFromCache();
        if ($this->token) {
            return $this->token;
        }
        $this->requester->setToken(null);
        $token = $this->requester->request(Requester::METHOD_POST, $path, $credentials);

        $t = $this->parseToken($token);

        $this->storeTokenToCache($t);

        return $t;
    }

    public function parseToken($token)
    {
        $exp = null;
        if (isset($token['exp'])) {
            $exp = intval($token['exp']);
        }
        $this->token = new Token($token['token'], $exp);
        return $this->token;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function loadTokenFromCache(): ?Token
    {
        if (!file_exists($this->tokenFile)) {
            return null;
        }
        $s = file_get_contents($this->tokenFile);

        $token = unserialize($s);

        if ($token->getExpireAt() && $token->getExpireAt() < time()) {
            return null;
        }

        $this->token = $token;

        return $token;
    }

    public function storeTokenToCache(Token $token)
    {
        $s = serialize($token);

        file_put_contents($this->tokenFile, $s);
    }
}
