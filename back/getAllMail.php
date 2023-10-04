<?php
require_once 'basic.php';
function getInfo($token)
{
    require 'getRealInfo.php';
    $ret = json_decode(get_main());
    return $ret;
}

$pst = $_POST;
$token = $pst['token'];
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls("error","用户登录失败");
}
if(property_exists($ret,'isip'))
    cls("ip","ip");
$username=json_decode($ret->msg)->name;
$res = getVal('接收所有信件_' . $username);
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    cls("success",json_encode(array(),JSON_UNESCAPED_UNICODE));
}
cls("success",json_encode($res,JSON_UNESCAPED_UNICODE));
?>