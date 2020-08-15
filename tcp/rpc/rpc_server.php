<?php
$server=new Swoole\Server('0.0.0.0',6064);
$server->set([
    'work_num'=>2,
    'daemonize'=>1
]);

$server->on('Connect',function($server,$fd){
    echo '收到请求 '.$fd;
});

$server->on('Receive',function ($server,$fd,$rectorId,$data){
    static $import = true;
    if ($import) {
        //__DIR__代表当前文件rpc_server.php对应的父目录
        define('APP_PATH', __DIR__ . '/tp5/application'); //框架目录
        define('RPC_RUN', true);

        $_REQUEST['argv_rpc'] = $data;//请求的path_info;客户端可通过发送$_SERVER['PATH_INFO']获取地址栏的请求。客户端也可以直接指定action

        $path = __DIR__ . '/tp5/thinkphp/base.php'; //填入服务器中base文件所在路径
        include $path;
    }
    $import = false;
    $app = new \think\App();
    $res = $app->run();
    //将结果发送给客户端：
    $server->send($fd,$res,$rectorId);
});

$server->on('Close',function($server,$fd){

});

$server->start();