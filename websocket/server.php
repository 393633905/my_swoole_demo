<?php



$server=new Swoole\WebSocket\Server('0.0.0.0',6077);


//当客户端连接时：
$server->on('open',function(Swoole\WebSocket\Server $server, $request){
    echo '有客户端连接，id为：'.$request->fd."\n";
});


// 当收到消息时
$server->on('message',function(Swoole\WebSocket\Server $server, $frame){
    echo "收到来自客户端{$frame->fd}消息：".$frame->data;
    foreach ($server->connections as $connection){
        if($connection!=$frame->fd && $frame->data!='connect'){
            $server->push($connection,$frame->data);
        }
    }
});

//当客户端断开时：也断开redis
$server->on('close',function($server, $fd){
    echo '客户端断开'.$fd;
});


$server->start();