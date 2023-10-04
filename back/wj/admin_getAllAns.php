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
if(property_exists($ret,'isip'))
    cls("ip","ip");
$username = json_decode(($ret->msg))->name;
$res = getVal('创建所有问卷_' . $username);
if($res == 'null') $res = [];
if(!(in_array($wjid,$res)))
    cls("error","您没有查看权限");
$res = getVal('所有答卷_' . $wjid);
//$res = getVal('所有答卷_ceshi');
cls('success',$res);
?>