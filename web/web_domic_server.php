<?php
/**
 * 动态Web服务器：
 * 1.获取请求要解析的php的文件地址
 * 2.判断动态文件是否存在：
 *      - 1.若不存在，抛出404错误
 *      - 2.若存在，则使用include执行（因为php是服务端语言），然后将结果返回前台，通过暂存区。
 */

$server=new \Swoole\Http\Server('0.0.0.0',6066);
$server->set([
    'work_num'=>2,
    'daemonize'=>1,
    'document_root' => __DIR__.'/static/admin', // v4.4.0以下版本, 此处必须为绝对路径
    'enable_static_handler' => true,
]);

//WorkerStart事件监听进程启动
//进程启动时发生,这里创建的对象可以在进程生命周期内使用
//在进程启动时加载ThinkPHP框架,启动程序放在request回调中
$server->on('WorkerStart', function(swoole_server $server,  $worker_id) {
    // 定义应用目录
    define('APP_PATH', __DIR__.'/tp5/application'); //框架目录
    define('RPC_RUN', true);
});

$server->on('request',function($request,$response){
//    //获取请求的文件路径：
//    $file=$request->server['request_uri'];
//    $filePath=__DIR__.$file;
//    if(file_exists($filePath)){//文件存在
//            $_GET=$request->get;
//            $_POST=$request->post;
//            $_FILES=$request->file;
//        //状态码：
//        $status=200;
//        //执行php文件，将结果存入暂存区返回给前端
//        ob_start();
//        include $filePath;
//        $res=ob_get_contents();//返回暂存区内容
//        ob_clean();
//    }else{
//        $status=404;
//        $res='未找到';
//    }
    // 以下代码建议放在onWorkStart中.
    $_SERVER  =  []; //因swoole是持久连接，故每次请求的时候都重置这些数据
   if(isset($request->server)) {
        foreach($request->server as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }
    if(isset($request->header)) {
        foreach($request->header as $k => $v) {
            $_SERVER[strtoupper($k)] = $v;
        }
    }

    $_GET = [];
    if(isset($request->get)) {
        foreach($request->get as $k => $v) {
            $_GET[$k] = $v;
        }
    }

    $_POST = [];
    if(isset($request->post)) {
        foreach($request->post as $k => $v) {
            $_POST[$k] = $v;
        }
    }

    $_COOKIE = [];
    if(isset($request->cookie)) {
        foreach($request->cookie as $k => $v) {
            $_COOKIE[$k] = $v;
        }
    }
    try{
        $_GET=$request->get;
        $_POST=$request->post;
        $_FILES=$request->file;

        static $import = true;
        $_REQUEST['argv_rpc'] = $request->server['request_uri'];//请求的path_info;可通过$_SERVER['PATH_INFO']获取地址栏的请求。也可通过tcp客户端发送消息指定action
        if ($import) {
            $path = __DIR__.'/tp5/thinkphp/base.php'; //填入服务器中base文件所在路径
            include $path;
        }
        $import = false;
        $app = new \think\App();
        ob_start();
        $res = $app->run();
        echo $res;
        $res=ob_get_contents();
        ob_clean();
        $response->header('Content-Type','text/html;charset=utf8');
        $response->status(200);
        $response->end($res);
    }catch(Exception $exception){
        $response->header('Content-Type','text/html;charset=utf8');
        $response->status(404);
        $response->end('当前请求路径：'.$request->server['request_uri'].' 不存在');
    }

});

$server->start();