<?php

// 当work_num>1时，可使用table进行进程间数据共享：
$size=1024;
$table=new \Swoole\Table($size);
$table->column('id',\Swoole\Table::TYPE_INT,4);
$table->column('name',\Swoole\Table::TYPE_STRING,4);
$table->column('age',\Swoole\Table::TYPE_INT,1);
// Table 使用共享内存来保存数据，在创建子进程前，务必要执行 Table->create().
// Server 中使用 Table，Table->create() 必须在 Server->start() 前执行。
$table->create();

// 开启Http服务.
$server=new Swoole\Http\Server('0.0.0.0',9502);
$server->set([
    'work_num'=>2,
    // 数据包分发模式.
    'dispatch_mode'=>1,
]);
$server->on('request',function($request,$response) use($table){
    // 获取请求路径.
    $uri=$request->server['request_uri'];

    if(trim($uri) == '/table/set'){
        // 获取key参数.
        $key=$request->get['key'];
        $fd=$request->fd;
        $table->set($key,['id'=>$fd,'name'=>'Bunny','age'=>23]);
        $response->end('Success');
    }elseif(trim($uri) == '/table/get'){
        // 获取key参数.
        $key=$request->get['key'];
        $res=$table->get($key);

        $response->end(json_encode($res,JSON_UNESCAPED_UNICODE));
    }
});

$server->start();


