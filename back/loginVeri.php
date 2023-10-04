<?php
require_once('basic.php');
function makeToken($name, $pwd, $tm){
    $str = $name.",endnametopwd,".$pwd.",".$tm;
    $reta = base64_encode($str);
    return $reta;
}
function deToken($str){
    $reta = base64_decode($str);
    return $reta;
}
$reta;
$pst = $_POST;
date_default_timezone_set('PRC');
$regname = $pst['userName'];
$regpwd = $pst['password'];

//测试用
//$regname = 'ceshi';
//$regpwd = '2';

if (empty($regname) || empty($regpwd)) {
    cls('error', "用户名、密码均不能为空");
}

/*
  echo "用户名：".$regname." <br>";
  echo "密码：".$regpwd." <br>";
  echo "邮箱：".$regemail." <br>";
*/
$resa = getVal('用户_' . $regname);
//cls("error",'sad'.$resa);
if ($resa == 'null')
{
    cls("error","用户不存在");
}
if($resa[0] != $regpwd) {
    cls("error","密码错误，请重新输入");
}
$reta['status'] = "success";
$cs = makeToken($regname,$regpwd,strval(time()));
$reta['msg'] = $cs;
//$ret['msg'] = deToken($cs);
if(key_exists('ip',$pst) && key_exists('location',$pst)){
    $ip = $pst['ip'];
    $loc = $pst['location'];
    $res = postVal('登录信息web_' . $regname, json_encode(array(date('Y-m-d H:i:s',time()),$ip,$loc ),JSON_UNESCAPED_UNICODE));
}
echo json_encode($reta,JSON_UNESCAPED_UNICODE);
?>