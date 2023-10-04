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
$data = $pst['data'];
$action = $pst['action'];

$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
if(property_exists($ret,'isip'))
    cls("ip","ip");

$username = json_decode(($ret->msg))->name;

if($action == 'deleteWj')
{
    $res = getVal('创建所有问卷_' . $username);
    $id = array_search($data,$res);
    $newArr = $res;
    array_splice($newArr, $id, 1);
    postVal('创建所有问卷_' . $username, json_encode($newArr, JSON_UNESCAPED_UNICODE));
    cls('success',$newArr);
}
if($action == 'saveInfo')
{
    $wjNum = $pst['wjNum'];
    $rs = getVal('问卷_'.$wjNum);
    if($rs == 'null'){
        cls('numerror',"问卷编号无效");
    }
    postVal('问卷信息_' . $wjNum, $data);
    cls('success',"well done");
}
cls('error','问卷类型错误');
?>