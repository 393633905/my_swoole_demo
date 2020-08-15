<?php
// 一键协程化.
Swoole\Runtime::enableCoroutine(true);

go(function(){
    // 实例化redis.
    $redis=new Redis();
    $redis->connect('127.0.0.1',6380);
    
    // 设置值.
    $redis->set('coroutine','test');

});