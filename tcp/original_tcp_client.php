<?php
/**
 * 使用原生PHP实现tcp服务器：stream_socket_client
 * 在Linux中一切皆文件，故发送消息和接收消息均通过写入和读取文件进行。
 * 因此可以将stream_socket_client的实例当作是一个文件；
 *
 */

//设置超时时间10秒：
$socket=stream_socket_client('tcp://127.0.0.1:6060',$errorno,$errstr,10);
//发送消息：
fwrite($socket,'你好 Swoole');
$buffer=fread($socket,1024);
fclose($socket);
echo $buffer."\n";