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
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
$username=json_decode(urldecode(($ret->msg)))->name;
$res = getVal('问卷_' . $wjid);
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    cls('error','问卷不存在');
}
cls('success',$res);
?>