<?php
/**
 * Web静态资源服务器：
 */

$server=new \Swoole\Http\Server('0.0.0.0',6065);
$server->set([
    'work_num'=>2,
    'daemonize'=>1,
    'document_root' => __DIR__.'/static/admin', // v4.4.0以下版本, 此处必须为绝对路径
    'enable_static_handler' => true,
]);
//监听请求：
$server->on('request',function($request,$response){
    $response->status(200);
    $response->header('Content-Type','text/html;charset=utf8');
    $response->end('Hello');//响应内容
});
$server->start();