<?php
/**
 * Created by PhpStorm.
 * User: caojiayuan
 * Date: 2018/5/20
 * Time: 下午4:29
 */

namespace CaoJiayuan\Io\Http;


use CaoJiayuan\Io\Token\Provider;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class SimpleRequester implements TokenRequester
{
    protected $baseUrl;

    protected $token = null;

    public function __construct($baseUrl)
    {
        $this->baseUrl = $baseUrl;
    }

    public function request($method, $path, $data = [])
    {
        $client = $this->getGuzzle();
        $type = 'query';
        if (strtoupper($method) != 'GET') {
            $type = 'json';
        }

        $response = $client->request($method, $path, [
            $type => $data
        ]);

        return $this->parseResponse($response);
    }

    public function parseResponse(ResponseInterface $response)
    {
        $body = $response->getBody();
        $result = json_decode($body, true);
        if ($result !== null) {
            return $result;
        }

        return $body;
    }


    public function getGuzzle()
    {
        $options = [
            'base_uri'    => $this->baseUrl,
            'headers'     => [
                'Accept' => 'application/json'
            ],
            'http_errors' => false
        ];
        $this->getToken() && $options['headers']['Authorization'] = 'Bearer ' . $this->getToken();

        return new Client($options);
    }

    /**
     * @param bool|string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return $this->token;
    }
}
