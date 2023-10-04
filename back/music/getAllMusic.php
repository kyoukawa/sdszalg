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
$st = intval($pst['start']);
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
$username=json_decode(($ret->msg))->name;

$res = getVal('阳橙曲库');
cls('success',$res);
?>