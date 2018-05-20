<?php

namespace CaoJiayuan\Io;


use CaoJiayuan\Io\Http\Requester;

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

    public function post($path, $data = [])
    {
        return $this->requester->request('POST', $path, $data);
    }
}