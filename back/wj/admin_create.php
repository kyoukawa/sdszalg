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
$wjName = $pst['wjName'];

$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
if(property_exists($ret,'isip'))
    cls("ip","ip");

$username = json_decode(($ret->msg))->name;

$num = '';
while(1){
    $rand = strval(rand(10000,99999));
    $checkNum = getVal("问卷_".$rand);
    if($checkNum == 'null'){
        $num = $rand;
        break;
    }
}

postVal("问卷_".$num,$data);
$res = getVal("创建所有问卷_".$username);
$inarr = ($res == 'null'?array():$res);
array_unshift($inarr,$num);
postVal("创建所有问卷_".$username,json_encode($inarr,JSON_UNESCAPED_UNICODE));
date_default_timezone_set('PRC');
$timestr=date("Y-m-d H:i:s");

$narr = array("createTime"=>$timestr,"wjName"=>$wjName);
postVal("问卷信息_".$num,json_encode($narr,JSON_UNESCAPED_UNICODE));
cls('success',$num);

?>