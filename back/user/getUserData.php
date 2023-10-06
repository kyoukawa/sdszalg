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
if ($ret->status != 'success') {
    cls('error', '用户登录失败');
}
if (property_exists($ret, 'isip'))
    cls("ip", "ip");
$username = addslashes(json_decode(($ret->msg))->name);
$res = getVal("name", $username);
$userData = [];
$userData['name'] = $username;
$res = getVal("userTag", $username);
if ($res != 'null') {
    $userData['tag'] = $res;
}
$res = getVal("password", $username);
if ($res != 'null') {
    $userData['password'] = $res;
}
cls('success', $userData);

?>