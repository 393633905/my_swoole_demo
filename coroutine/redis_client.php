<?php

use Swoole\Coroutine\Redis;

go(function(){
    $redis = new Swoole\Coroutine\Redis();

    $redis->setOptions([
        'connect_timeout'=>2,
        'timeout'=>5,
    ]);
    $redis->connect('127.0.0.1', 6380);


    $log=$redis->get('chat_log_2020-08-15');
    var_dump($log);

});

echo '协程测试';