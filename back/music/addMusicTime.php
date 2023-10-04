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
$username=json_decode(($ret->msg))->name;

$res = getVal('听歌时长_'.$username);
$musicTime = 0;
if($res != 'null')
    $musicTime = $res;
$musicTime += 10;
$res = postVal('听歌时长_'.$username, $musicTime);
if($res == 'success'){
    cls('success',$res);
}
else{
    cls('error','post数据错误，请联系管理员。');
}
?>