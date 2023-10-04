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
    cls('error','用户登录失败：'.$ret->msg);
}
$username=json_decode(urldecode(($ret->msg)))->name;
$res = getVal('答卷_' . $wjid . '_' . $username);
$veri = json_decode(getVal('问卷信息_' . $wjid));
if($res != 'null'){
    if(!is_object($veri) || !array_key_exists('repeat',$veri) || $veri->repeat != true)
    {
        cls('error','您已经填写过此问卷，请勿重复填写。');
    }
}
if(is_object($veri) && array_key_exists('open',$veri) && $veri->open == false)
{
    cls('error','问卷未开放填写');
}
$res = getVal('问卷_' . $wjid);
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    cls('error','问卷不存在');
}
$sz = count($res);
for($i = 0;$i < $sz;$i+=1){
    $item = $res[$i];
    $qtp = $item[0];//question type
    if($qtp == 'info')
    {
        $userlist = $pst['userlist'];
        cls('success',$item[1]);
    }
}
cls('error',"empty");
?>