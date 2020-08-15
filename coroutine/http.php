<?php
$server=new Swoole\Http\Server('0.0.0.0',9504);

$server->on('request',function($request,$response){
    // 使用协程HttpClient请求第三方API.
    // 域名无需写http和https.
    $client=new Swoole\Coroutine\Http\Client('api.393633905.xyz',80);
    // get请求获取.
    $client->get('/api/v1/get/article/list');

    $response->header('Content-Type','application/json;charset=utf8;');
    $response->end($client->body);

    $client->close();
});

$server->start();

