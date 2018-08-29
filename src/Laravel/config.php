<?php
/**
 * Created by PhpStorm.
 * User: cjy
 * Date: 2018/5/22
 * Time: 下午6:17
 */

return [
    'host'        => env('IO_NODE_HOST', 'http://127.0.0.1:3003'),
    'master'        => env('IO_MASTER_CHANNEL', 'master'),
    'credentials' => [
        'key' => env('IO_MASTER_KEY', 'masterkey'),
        '_id' => env('IO_CLIENT_ID', 'somerandomid'),
    ],
];
