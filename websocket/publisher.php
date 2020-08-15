<?php
//发送消息：
$redis=new \Redis();
$redis->connect('127.0.0.1',6379);

$res=$redis->publish('zfw:msg','短信提醒，请注意查收！');
echo '发布订阅消息成功';
