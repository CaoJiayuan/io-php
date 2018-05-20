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

class SimpleRequester implements Requester
{
    protected $baseUrl;
    /**
     * @var Provider
     */
    private $tokenProvider;

    public function __construct($baseUrl, Provider $tokenProvider)
    {
        $this->baseUrl = $baseUrl;
        $this->tokenProvider = $tokenProvider;
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
            'base_uri' => $this->baseUrl,
            'headers' => [
                'Authorization' => 'Bearer ' . $this->tokenProvider->getToken()
            ]
        ];

        return new Client($options);
    }
}