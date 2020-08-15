<?php
//发送消息：
$redis=new \Redis();
$redis->connect('111.231.209.227',6379);
$redis->auth('393633905');
$res=$redis->publish('zfw:msg','短信提醒，请注意查收！');
echo '发布订阅消息成功';
