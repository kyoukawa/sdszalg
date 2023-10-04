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
$mlid = $pst['mlid'];
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls("error","用户登录失败，请刷新页面重试");
}


$username=json_decode(urldecode(($ret->msg)))->name;
$res = getVal('信件_' . $mlid);

if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    cls("error","信件不存在");
}
$res = explode(';', $res);
if(count($res) < 6){
    cls("error","信件内容异常，请联系谢京宸查看情况");
}
if(property_exists($ret,'isip'))
{
    cls("ip",$res[1]);
}
if($res[1] != $username)
{
    cls("error","您没有查看权限");
}
$lrt = "";
$len = count($res);
for($i = 5;$i < $len;$i += 1)
{
    $lrt .= $res[$i];
    if($i != $len-1) $lrt .= ';';
}
$rt = array($res[0],$res[1],$res[2],$res[3],$res[4],$lrt);
$res = getVal("已查看信件_".$username);
$cache = ($res == 'null'?[]:$res);
if(!in_array($mlid,$cache))
    array_push($cache,$mlid);
$np = postVal("已查看信件_".$username,json_encode($cache,JSON_UNESCAPED_UNICODE));
cls("success",json_encode($rt,JSON_UNESCAPED_UNICODE));
?>