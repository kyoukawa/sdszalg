<?php
require_once 'basic.php';
$ret;
$pst = $_POST;

$regname = $pst['userName'];
$regpwd = $pst['password'];
$regemail = $pst['email'];

if (empty($regname) || empty($regpwd) || empty($regemail)) {
    
    $ret['status'] = "error";
    $ret['msg'] = "用户名、密码、邮箱均不能为空";
    echo json_encode($ret,JSON_UNESCAPED_UNICODE);
    return;
}

/*
  echo "用户名：".$regname." <br>";
  echo "密码：".$regpwd." <br>";
  echo "邮箱：".$regemail." <br>";
*/
$res = getVal('用户_' . $regname);
if (json_encode($res,JSON_UNESCAPED_UNICODE) != '"null"') {
    $ret['status'] = "error";
    $ret['msg'] = "用户名已经存在，请更换用户名";
    echo json_encode($ret,JSON_UNESCAPED_UNICODE);
    return;
}
$res = postVal('用户_' . $regname, json_encode(array($regpwd, $regemail, 'web'),JSON_UNESCAPED_UNICODE));
if ($res != 'success') {
    $ret['status'] = "error";
    $ret['msg'] = "注册失败，请联系管理员";
    echo json_encode($ret,JSON_UNESCAPED_UNICODE);
    return;
}
$ret['status'] = "success";
echo json_encode($ret,JSON_UNESCAPED_UNICODE);
?>