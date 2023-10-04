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

$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
if(property_exists($ret,'isip'))
    cls("ip","ip");
$username = json_decode(($ret->msg))->name;

$res = getVal('用户_'. $username);
$userData = [];
$userData['name'] = $username;
if($res != 'null')
{
    $userData['email'] = $res[1];
}
$res = getVal('userTags_'. $username);
if($res != 'null')
{
    $userData['tags'] = $res;
}
else
{
    $userData['tags'] = array();
}
$res = getVal('创建所有问卷_'. $username);
if($res != 'null')
{
    $userData['wjNum'] = count($res);
}
else
{
    $userData['wjNum'] = 0;
}
$res = getVal('接收所有信件_'. $username);
if($res != 'null')
{
    $userData['mlRecNum'] = count($res);
}
else
{
    $userData['mlRecNum'] = 0;
}
$res = getVal('已发送信件_'. $username);
if($res != 'null')
    $userData['mlSendNum'] = count($res);
else
    $userData['mlSendNum'] = 0;
$res = getVal('系统反馈_'. $username);
if($res != 'null')
    $userData['reportNum'] = count($res);
else
    $userData['reportNum'] = 0;
$res = getVal('听歌时长_'. $username);
if($res != 'null')
    $userData['musicTime'] = $res;
else
    $userData['musicTime'] = 0;
cls('success',$userData);

?>