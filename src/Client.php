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
    /**
     * @var string
     */
    protected $id;

    public function __construct(Requester $requester, $masterChannel = 'master', $id = 'random-id')
    {
        $this->requester = $requester;
        $this->masterChannel = $masterChannel;
        $this->id = $id;
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
            'hooks'    => $hooks,
            'id'       => $this->getId($channel)
        ], $guest);
    }

    public function unsubscribe($channel)
    {
        return $this->post('/unsubscribe', [
            'channels' => $channel,
            'id'       => $this->getId($channel)
        ]);
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

    protected function wrapArray($value)
    {
        if (!is_array($value)) {
            return [$value];
        }

        return $value;
    }

    protected function getId($channel)
    {
       return $this->id . '-' . md5(json_encode($this->wrapArray($channel)));
    }
}
