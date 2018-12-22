<?php
http://overapi.com/php  php函数库
https://blog.csdn.net/sssnmnmjmf/article/details/68486261  TCP 握手
https://github.com/ziadoz/awesome-php#documentation   php 包资源
https://github.com/xianyunyh/PHP-Interview  php 资源
https://github.com/sushengbuhuo/php-interview-2018
https://www.cnblogs.com/hellohell/p/5718319.html 正则表达式
// https://github.com/hookover/php-engineer-interview-questions
// https://blog.csdn.net/linuxnews/article/details/51142191 nginx php-fpm
https://juejin.im/post/5a2600bdf265da432b4aaaba  nginx  入门
https://laravel-china.org/articles/2765/elasticsearch-in-order-to-search  ES使用
find ./  -mtime +30 -name "*.log" |xargs rm 删除30天前的日志
https://laravel-china.org/articles/19459  https证书
https://segmentfault.com/a/1190000009745139  awk 命令

https://www.cnblogs.com/lamp01/p/8985068.html opcache 教程安装
https://www.zybuluo.com/phper/note/1016714
https://github.com/appstract/laravel-opcache 
https://laravel-china.org/articles/17883 jwt

https://laravel-china.org/articles/11006/detailed-explanation-of-laravels-own-api-guard-drive-token  laravel api token
https://www.cnblogs.com/thrillerz/p/7137682.html nginx swoole
https://www.cnblogs.com/wzjhoutai/p/6932007.html  nginx upstream 

https://laravel-china.org/topics/17687  laravel深入浅出
https://github.com/xiaohuilam/laravel/wiki

1.$_SERVER['REMOTE_ADDR'] 客户端IP，有可能是用户的IP，也可能是代理的IP。
4.$_SERVER['SERVER_ADDR'] 获取服务器端IP

一种是innodb,一种是myisam,两者的主要区别是
①myisam不支持事务处理，而innoDB支持事务处理
②myisam 不支持外键，innoDB支持外键
③myisam支持全文检索，而innoDB在MySQL5.6版本之后才支持全文检索
④数据的存储形式不一样，mysiam表存放在三个文件：结构、索引、数据，innoDB存储把结构存储为一个文件，索引和数据存储为一个文件
⑤myisam在查询和增加数据性能更优于innoDB，innoDB在批量删除方面性能较高。
⑥myisam支持表锁，而innoDB支持行锁


1.根据访问IP统计UV
awk '{print $1}'  access.log|sort | uniq -c |wc -l
2.统计访问URL统计PV
awk '{print $7}' access.log|wc -l
3.查询访问最频繁的URL
awk '{print $7}' access.log|sort | uniq -c |sort -n -k 1 -r|more
4.查询访问最频繁的IP
awk '{print $1}' access.log|sort | uniq -c |sort -n -k 1 -r|more
统计nginx日志中访问最多的100个ip及访问次数
awk ‘{print $1}’ access.log|sort | uniq -c |sort -n -k 1 -r| head -n 100


递归获取目录
function readDirDeep($path,$deep = 0)
{
    $handle = opendir($path);
    while(false !== ($filename = readdir($handle))){
        if($filename == '.' || $filename == '..') continue;
        echo str_repeat('&nbsp;',$deep*5) . $filename.'<br>';
            //str_repeat(str,n) 重复一个str字符串n次
        if(is_dir($path.'/'.$filename)){
            readDirDeep($path.'/'.$filename,$deep+1);
        }
    }
    //闭关
    closedir($handle);
}

PHP解决多进程读写一个文件的方法

function putFile($file){
	$file = fopen($file,'w');
	if(flock($file,LOCK_EX)){
		fwrite($file, 'aaaaa');
		flock($file,LOCK_UN);
	}else{
		echo '获取文件锁失败';
	}
	fclose($file);

}

nginx与php-fpm通信的两种方式
1.unix socket listen = /tmp/php-fpm.sock  fastcgi_pass unix:/tmp/php-fpm.sock;
2.tcp socket  listen = 127.0.0.1:9000  fastcgi_pass 127.0.0.1:9000;
tcp方式 
从稳妥的考虑肯定是使用tcp，tcp协议能保证数据的正确性，sock不能保证。
可以跨服务器，当nginx和php-fpm不在同一台机器上时，只能使用这种方式
unix socket方式要比tcp的方式快，而且消耗资源少

防sql注入方法
mysql_escape_string(strip_tags($arr["$val"]));
mysql_escape_string  将字符串转义 用于查询
strip_tags           从字符串中去除 HTML 和 PHP 标记
/**
* 函数名称：post_check() 
* 函数作用：对提交的编辑内容进行处理 
* 参　　数：$post: 要提交的内容 
* 返 回 值：$post: 返回过滤后的内容 
*/
function post_check($post){
if(!get_magic_quotes_gpc()){// 判断magic_quotes_gpc是否为打开 
$post = addslashes($post);// 进行magic_quotes_gpc没有打开的情况对提交数据的过滤 
}
$post = str_replace("_","\_",$post);// 把 '_'过滤掉
$post = str_replace("%","\%",$post);// 把 '%'过滤掉
$post = nl2br($post);// 回车转换 
$post =htmlspecialchars($post);// html标记转换 
 
return $post;
}

200 : 请求成功，请求的数据随之返回。
301 : 永久性重定向。
302 : 暂时行重定向。
401 : 当前请求需要用户验证。
403 : 服务器拒绝执行请求，即没有权限。
404 : 请求失败，请求的数据在服务器上未发现。
500 : 服务器错误。一般服务器端程序执行错误。
503 : 服务器临时维护或过载。这个状态时临时性的。

require 失败时会产生一个致命级别错误，并停止程序运行。
include 失败时只产生一个警告级别错误，程序继续运行。
include有条件引用；require是无条件引用。

如下代码，但无论$some取何值，下面的代码将把文件somefile.php包含进文件里。
if($some){ 
　　require 'somefile.php';
}

Iconv("utf-8","gb2312",$str);

$email=$_POST[’email’];
if(!preg_match(‘/^[w.]+@([w.]+).[a-z]{2,6}$/i’,$email))  {
echo “电子邮件检测失败”;
}else{
echo “电子邮件检测成功”;
}
date_default_timezone_get()返回默认时区。
date_default_timezone_set()设置默认时区。


生成器读取超大文件
function readTxt($file)
{
    # code...
    $handle = fopen($file, 'rb');

    while (feof($handle)===false) {
        # code...
        yield fgets($handle);
    }

    fclose($handle);
}

冒泡排序
$arr=[5,2,8,1,9];
$len=count($arr);
for($k=1;$k<$len;$k++)
{
    for($j=0;$j<$len-$k;$j++){
        if($arr[$j]<$arr[$j+1]){
            list($arr[$j+1],$arr[$j])=[$arr[$j],$arr[$j+1]];
            
        }
    }
}
print_r($arr);











求文件相对路径
$a     = '/a/b/c/d/e.php';
$b     = '/a/b/12/34/c.php';
function getRelativePath($fileA, $fileB) {

    $arrA = explode("/", $fileA); 
    $arrB = explode("/", $fileB); 
    array_pop($arrA);
    array_pop($arrB);

    $offset = 0;
    foreach($arrB as $key => $value) {
        if(!isset($arrA[$key]) || ($arrA[$key] != $arrB[$key])) {
            $offset = $key;
            break;
        }
    }

    $relativePath = '';

    for($i = $offset; $i <count($arrB); $i++) {
        $relativePath .= '../'; 
    }

    for($i=$offset; $i<count($arrA); $i++) { 
        $relativePath .= $arrA[$i].'/';
    }

    return $relativePath; 
}
echo getRelativePath($a,$b);


广度搜索目录 队列
function readDirQueue($dir){
    $dirs = [$dir];
    while($path = array_shift($dirs)){
        if(is_dir($path) && $handle = opendir($path)){
            while(false !==($filename = readdir($handle))){
                if($filename == '.'  || $filename == '..')continue;
                $real_path = $path . DIRECTORY_SEPARATOR . $filename;
                if(is_dir($real_path)) {
                    $dirs[] = $real_path;
                }else {
                    echo $real_path . '<br/>';
                }
            }
            closedir($handle);
        }
    }
}

10g文件，用php查看它的行数
来自网络: 它的方式是一次读取一部分数据,计算这部分数据中有多少个换行符,不断循环,效率会比顺序读取内容高
function count_line($file)
{
    $fp = fopen($file, "r");
    $i  = 0;
    while (!feof($fp)) {
        //每次读取2M
        if ($data = fread($fp, 1024 * 1024 * 2)) {
            //计算读取到的行数
            $num = substr_count($data, "\n");
            $i += $num;
        }
    }
    fclose($fp);
    return $i;
}
function mb_str_split($str){
    return preg_split('/(?<!^)(?!$)/u', $str );
}

1.在setcookie中省略domain参数，那么domain默认为当前域名。

2.domain参数可以设置父域名以及自身，但不能设置其它域名，包括子域名，否则cookie不起作用。

那么cookie的作用域：

cookie的作用域是domain本身以及domain下的所有子域名。