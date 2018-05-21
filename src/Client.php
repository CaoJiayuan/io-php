<?php

namespace CaoJiayuan\Io;


use CaoJiayuan\Io\Http\Requester;
use CaoJiayuan\Io\Http\TokenRequester;

class Client
{

    /**
     * @var Requester
     */
    protected $requester;

    /**
     * @var string
     */
    protected $masterChannel;

    /**
     * @var null|TokenProvider
     */
    protected $token = null;

    public function __construct(Requester $requester, $masterChannel = 'master')
    {
        $this->requester = $requester;
        $this->masterChannel = $masterChannel;
    }

    public function broadcast($channel, $payload)
    {
        return $this->post('/broadcast', [
            'channels' => $channel,
            'payload'  => $payload
        ]);
    }

    public function setTokenProvider(TokenProvider $provider)
    {
        $this->token = $provider;
    }

    public function getTokenProvider()
    {
        return $this->token;
    }

    public function post($path, $data = [], $guest = false)
    {
        if (!$guest && ($token = $this->getTokenProvider())) {
            $this->requester instanceof TokenRequester && $this->requester->setToken($token);
        }
        return $this->requester->request('POST', $path, $data);
    }
}
