<?php

// 案例：开启3个子进程执行耗时任务，缩短时间.

for ($i=1;$i<=10;$i++){
    $process=new \Swoole\Process(function() use($i){
        // 执行耗时任务
        sendEmail($i);
    });
    // 开启子进程.
    $process->start();
}

 function sendEmail(int $index){
    sleep(2);

    echo 'Success|index：'.$index.PHP_EOL;
}
