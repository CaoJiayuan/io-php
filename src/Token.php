<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/21
 * Time: 下午6:13
 */

namespace CaoJiayuan\Io;


class Token
{
    /**
     * @var string
     */
    protected $token;
    /**
     * @var int|null
     */
    protected $expire_at;

    public function __construct(string $token, ?int $expire_at = null)
    {
        $this->token = $token;
        $this->expire_at = $expire_at;
    }

    public function __toString()
    {
        return $this->token;
    }

    /**
     * @return int|null
     */
    public function getExpireAt()
    {
        return $this->expire_at;
    }
}
