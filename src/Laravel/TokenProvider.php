<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/22
 * Time: 下午6:21
 */

namespace CaoJiayuan\Io\Laravel;


use CaoJiayuan\Io\Token;
use CaoJiayuan\Io\TokenProvider as BaseTokenProvider;
use Carbon\Carbon;
use Illuminate\Cache\Repository;

class TokenProvider extends BaseTokenProvider
{
    protected $cacheKey = '__io_token__';
    protected $cacheDriver = null;

    public function loadTokenFromCache(): ?Token
    {
        $cache = $this->getCacheDriver();

        $data = $cache->get($this->cacheKey);

        if (!empty($data) && isset($data['token'])) {
            $token = new Token($data['token'], $data['exp'] ?? null);
            $this->token = $token;
            return $token;
        }

        return null;
    }

    public function storeTokenToCache(Token $token)
    {
        $t = $token->getToken();
        $exp = $token->getExpireAt();
        $cache = $this->getCacheDriver();

        $data = [
            'token' => $t,
            'exp'   => $exp
        ];

        if (is_null($exp)) {
            $cache->forever($this->cacheKey, $data);
        } else {
            $cache->put($this->cacheKey, $data, Carbon::createFromTimestamp($exp));
        }
    }

    /**
     * Get the cache driver.
     *
     * @return \Illuminate\Cache\CacheManager|Repository
     */
    protected function getCacheDriver()
    {
        return app('cache')->driver($this->cacheDriver);
    }
}
