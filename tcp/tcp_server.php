<?php
/**
 * TCP服务端：
 */

//监听指定端口的所有ip：
$server=new Swoole\Server('0.0.0.0',6060);
$server->set([
    'daemonize'=>1,//开启守护进程，防止命令行阻塞
    'worker_num'=>2//2个work进程
]);

//监听客户端连接：
//$fd表示客户端的唯一标识
$server->on('Connect',function($server,$fd){
    echo '收到客户端连接，客户端唯一标识id：'.$fd."\n";
});

//监听客户端发送消息：
//$fd是客户端唯一标识，
//$rectorId表示请求是由哪个rector线程接收到的
$server->on('Receive',function($server,$fd,$rectorId,$data){
    echo '收到客户端发送的消息：'.$data."\n";

    //回复消息：
    $server->send($fd,'您的请求我已经收到，请等待管理员处理！'."\n",$rectorId);
});

$server->on('Close',function($server,$fd,$rectorId){
    echo '客户端已断开！'."\n";;
});

//开启服务：
$server->start();
