<?php
require_once 'basic.php';
function makeToken($name, $pwd, $tm)
{
    $str = $name . "," . $pwd . "," . $tm;
    $reta = base64_encode($str);
    return $reta;
}
function deToken($str)
{
    $ret = base64_decode($str);
    return $ret;
}
$ret;
$pst = $_POST;

$token = $pst['token'];

if (empty($token)) {
    cls("error", "登录失败，未提供token参数");
}
$dec = deToken($token);
$ndec = explode(",", $dec);
$regname = $ndec[0];
$regpwd = $ndec[1];
/*if(time()-$ndec[3] > 3600)//30分钟后登录失效
{
    cls("error","登录信息已失效，请重新登录");
}*/
$ret['status'] = "success";
$cs = makeToken($regname, $regpwd, strval(time()));
$ret['msg'] = $cs;
//$ret['msg'] = deToken($cs);
echo json_encode($ret, JSON_UNESCAPED_UNICODE);
?>