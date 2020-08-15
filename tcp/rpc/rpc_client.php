<?php
$client=new \Swoole\Client(SWOOLE_SOCK_TCP);
if($client->connect('127.0.0.1',6064,2)){
    //重连

    $client->close();
    $client->connect('127.0.0.1',6064,2);
};

if(!$client->send('/index/index/test')){
    die('请求失败');
}

while($res=$client->recv(1024)){
   echo $res;
}
$client->close();
