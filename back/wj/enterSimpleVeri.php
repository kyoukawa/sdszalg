<?php
require_once '../basic.php';
function getInfo($token)
{
    require_once '../getRealInfo.php';
    $ret = json_decode(get_main());
    return $ret;
}

$pst = $_POST;
$token = $pst['token'];
$wjid = $pst['wjid'];
$res = getVal('问卷_' . $wjid);
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    die('问卷不存在');
}
if($token == ''){
    die('toLogIn');
}
$ret = getInfo($token);
if($ret->status != 'success')
{
    die('用户登录失败');
}
//$username=$ret->msg->name;
echo 'able';
?>