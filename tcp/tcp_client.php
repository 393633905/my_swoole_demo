<?php
/**
 * tcp 客户端
 */
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
