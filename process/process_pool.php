<?php
$workerNum = 10;
$pool = new Swoole\Process\Pool($workerNum);

$pool->on("WorkerStart", function ($pool, $workerId) {

    sendEmail($workerId);
});

//$pool->on("WorkerStop", function ($pool, $workerId) {
//    echo "Worker#{$workerId} is stopped\n";
//});

$pool->start();

function sendEmail(int $index){
    sleep(2);

    echo 'Success|index：'.$index.PHP_EOL;
}
