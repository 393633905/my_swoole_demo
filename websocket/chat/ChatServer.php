<?php

use Swoole\Coroutine\Redis;

$server=new Swoole\WebSocket\Server('0.0.0.0',6077);

$data=[];

//当客户端连接时：
$server->on('open',function(Swoole\WebSocket\Server $server, $request){
    echo '有客户端连接，id为：'.$request->fd;
});

// 当收到消息时
$server->on('message',function(Swoole\WebSocket\Server $server, $frame){
    foreach ($server->connections as $connection){//获取所有连接到客户端
        $content=$frame->data;//客户端发送过来的数据
        //判断客户端是否是自己：
        if($connection==$frame->fd){
            $style='bubble me';
        }else{
            $style='bubble you';
        }

        $data=['id'=>$frame->fd,'style'=>$style,'content'=>'用户'.$frame->fd.'说：'.$content,'time'=>date('H:i:s')];

        // 发送消息给客户端.
        $server->push($connection,json_encode($data,256));
    }
});

//当客户端断开时：
$server->on('close',function($server, $fd){
    echo '客户端断开'.$fd;
});

$server->start();