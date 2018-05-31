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

    protected $credentials = [];

    protected $loginPath = '/login';

    /**
     * @var null|TokenProvider
     */
    protected $token = null;

    public function __construct(Requester $requester, $masterChannel = 'master')
    {
        $this->requester = $requester;
        $this->masterChannel = $masterChannel;
    }

    public function broadcast($channel, $payload, $guest = false)
    {
        return $this->post('/broadcast', [
            'channels' => $channel,
            'payload'  => $payload
        ], $guest);
    }

    public function subscribe($channel, $hooks, $guest = false)
    {
        return $this->post('/subscribe', [
            'channels' => $channel,
            'hooks'    => $hooks
        ], $guest);
    }

    public function config(array $configs)
    {
        return $this->post('/config', $configs, false);
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
        if (!$guest && ($tokenProvider = $this->getTokenProvider())) {
            if ($this->requester instanceof TokenRequester) {
                $tokenProvider->login($this->credentials, $this->loginPath);

                $this->requester->setToken($tokenProvider->getToken());
            }
        }
        return $this->requester->request('POST', $path, $data);
    }

    /**
     * @param array $credentials
     */
    public function setCredentials(array $credentials)
    {
        $this->credentials = $credentials;
    }
}
