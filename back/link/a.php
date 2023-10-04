<?php
$the_host = $_SERVER['HTTP_HOST'];//取得当前域名
$request_uri = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';//判断地址后面是否有参数 

require_once '../basic.php';
//在此不验证用户信息
$gt = $_GET;
$lkid = $gt['i'];
$res = getVal('短链信息_' . $lkid);
//echo $res;
if($res=="null")
    //cls('error','链接编号不存在');
    echo "链接编号不存在";
else
{
    $res2 = getVal('访问统计_' . $lkid);
    if($res2 == 'null') $res2 = 0;
    $res2 += 1;
    postVal('访问统计_' . $lkid,$res2);
    header('HTTP/1.1 301 Moved Permanently');//发出301头部
    header('Location: '.$res[1]);//跳转到目标
    //cls('success',json_encode($res));
}

?>