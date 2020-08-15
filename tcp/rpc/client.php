<?php
/**
 * tcp 客户端：用于调用头部body底部服务
 */

//头部：
$client=new \Swoole\Client(SWOOLE_SOCK_TCP);
if(!$client->connect('127.0.0.1',6060,0.5)){
    echo('连接失败');

    //重连：
    $client->close();
    $client->connect('127.0.0.1',6060,0.5);
}

if(!$client->send('hello swoole')){
    die('发送消息失败');
}
$buffer=$client->recv(9000);
$client->close();
echo $buffer."\n";

//body:

$client=new \Swoole\Client(SWOOLE_SOCK_TCP);
if(!$client->connect('127.0.0.1',6061,0.5)){
    echo('连接失败');

    //重连：
    $client->close();
    $client->connect('127.0.0.1',6061,0.5);
}

if(!$client->send('hello swoole')){
    die('发送消息失败');
}
$buffer=$client->recv(9000);
$client->close();
echo $buffer."\n";

//底部：
$client=new \Swoole\Client(SWOOLE_SOCK_TCP);
if(!$client->connect('127.0.0.1',6062,0.5)){
    echo('连接失败');

    //重连：
    $client->close();
    $client->connect('127.0.0.1',6062,0.5);
}

if(!$client->send('hello swoole')){
    die('发送消息失败');
}
$buffer=$client->recv(9000);
$client->close();
echo $buffer."\n";
