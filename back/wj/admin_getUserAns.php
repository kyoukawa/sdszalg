<?php
require_once '../basic.php';
require_once '../getRealInfo.php';
function getInfo($token)
{
    require_once '../getRealInfo.php';
    $ret = json_decode(get_main());
    return $ret;
}

$pst = $_POST;
$token = $pst['token'];
$wjid = $pst['wjid'];
$usr = $pst['usr'];
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败'.$ret->msg);
}
if(property_exists($ret,'isip'))
    cls("ip","ip");
$username = json_decode(($ret->msg))->name;

$res = getVal('答卷_' . $wjid .'_' . $usr);
if($res == 'null'){
    cls('error','答卷不存在');
}
$res1 = json_decode($res);
$res1->username = $usr;
cls('success',json_encode($res1));
?>