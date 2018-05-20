<?php

namespace CaoJiayuan\Io;


class Client
{

    protected $host;

    public function __construct($host, $masterChannel = 'master')
    {
        $this->host = $host;
    }

    public function broadcast($channel, $payload)
    {
        
    }

    public function getGuzzle()
    {
        return new \GuzzleHttp\Client([
            'base_uri' => $this->host
        ]);
    }
}