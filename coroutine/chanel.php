<?php
// 实例化管道.
$chanel=new \Swoole\Coroutine\Channel(1);

go(function() use($chanel){
    // 给管道添加数据.
    $chanel->push(['id'=>1]);
    $chanel->push(['id'=>2]);
});

go(function() use($chanel){
    // 从管道中取出数据.
    while($chanel->length()){
        $data=$chanel->pop();
        print_r($data);
    }
});