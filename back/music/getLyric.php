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
$msid = $pst['msid'];
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
$username=json_decode(urldecode(($ret->msg)))->name;
$res = getVal('歌词_' . $msid);
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    cls('error','歌词不存在');
}
cls('success',$res);
?>