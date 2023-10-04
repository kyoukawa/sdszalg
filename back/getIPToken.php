<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Credentials: true");
require_once 'basic.php';
function makeToken($name, $pwd, $tm){
    $str = $name.",".$pwd.",".$tm;
    $ret = base64_encode($str);
    return $ret;
}
function deToken($str){
    $ret = base64_decode($str);
    return $ret;
}
$ret;
$pst = $_POST;
date_default_timezone_set('PRC');
if(key_exists('ip',$pst) && key_exists('location',$pst)){
    $ip = $pst['ip'];
    $loc = $pst['location'];
    $ret['status'] = "success";
    $cs = makeToken($ip,'ip',strval(time()));
    $ret['msg'] = $cs;
    echo json_encode($ret,JSON_UNESCAPED_UNICODE);
}
else{
    $ret['status'] = "error";
    $ret['msg'] = "缺少参数";
    echo json_encode($ret,JSON_UNESCAPED_UNICODE);
}
?>