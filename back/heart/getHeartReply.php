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
$qid = $pst['qid'];
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
$res = getVal('heartReply_' . $qid);
cls('success',$res);
?>