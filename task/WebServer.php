<?php

class WebServer
{
    private static $instance;

    private $server;

    private function __construct($host, $port)
    {
        // 创建HttpServer.
        $this->server = new Swoole\Http\Server($host, $port);

        // 支持静态资源请求.
        $this->server->set([
            'enable_static_handler' => true,// 支持静态资源
            'document_root' => __DIR__ . '/static',//静态资源根路径
            'work_num' => 4,//work进程数量
            'task_worker_num' => 2,//task进程数量
        ]);

        // 回调监听.
        $this->server->on('request', [$this, 'onRequest']);
        // Task任务回调监听.
        $this->server->on('task', [$this, 'onTask']);
        // Task任务执行完毕监听.
        $this->server->on('finish', [$this, 'onFinish']);

        // 启动HttpServer.
        $this->server->start();
    }

    private function __clone()
    {
    }

    /**
     * 获取WebServer实例.
     *
     * @param string $host
     * @param int $port
     *
     * @return WebServer
     */
    public static function getInstance(string $host = '0.0.0.0', int $port = 9501)
    {
        if (empty(self::$instance)) {
            self::$instance = new self($host, $port);
        }

        return self::$instance;
    }


    public function onRequest($request, $response)
    {
        $requestUri = $request->server['request_uri'];

        // 案例：访问$host:9501/email，使用task执行异步耗时任务
        if ($requestUri == '/email') {
            // 获取请求参数.
            $taskData=[
                'fd'=>$request->fd,
                'user'=>$request->get['user']
            ];

            // 执行异步耗时任务,例如发送电子邮件.
            $this->server->task($taskData);
        }
    }

    /**
     * @param $server
     * @param $task_id
     * @param $from_id
     * @param $data 任务传入的参数.
     * @return mixed
     */
    public function onTask($server, $task_id, $from_id, $data)
    {
        // 获取传入的数据.
        $fd=$data['fd'];
        $user=$data['user'];

        // 发送邮件，模拟耗时2s.
        sleep(2);

        //$server->finish('Time：'.date('Y-m-d H:i:s').'|Task：'.$task_id.'|User：'.$user.'|Send Email Success...');// 发送结果通知

        return $user;// 使用return 返回数据，可触发onFinish回调.
    }

    /**
     * @param $serv
     * @param $task_id
     * @param $data 此为onTask回调中return的内容
     */
    public function onFinish($serv, $task_id, $data)
    {
        echo "异步任务[$task_id] Finish: ".$data . PHP_EOL;
    }

}

$webServer = WebServer::getInstance('0.0.0.0', 9501);
