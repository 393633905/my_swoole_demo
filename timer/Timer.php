<?php
// 案例：使用Swoole::Timer，打印输出；

Swoole\Timer::tick(3000, function (int $timer_id, $param1, $param2) {
    echo "timer_id #$timer_id, after 3000ms.\n";
    echo "param1 is $param1, param2 is $param2.\n";

}, "A", "B");


$timer=\Swoole\Timer::after(1000,function (){
    echo 'after'.PHP_EOL;
});

// 清除定时器.
\Swoole\Timer::clear($timer);




