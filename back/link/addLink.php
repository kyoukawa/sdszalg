<?php
require_once '../basic.php';
function getInfo($token)
{
    require_once '../getRealInfo.php';
    $ret = json_decode(get_main());
    return $ret;
}

$pst = $_POST;
if(!(key_exists('hr',$pst) && key_exists('explain',$pst)))
{
    cls('error','缺少参数');
}
$token = $pst['token'];
$hr = $pst['hr'];
$explain = $pst['explain'];

$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
if(property_exists($ret,'isip'))
    cls("ip","ip");
$username = json_decode(($ret->msg))->name;

$res = getVal('短链列表_'. $username);
$arr = array();
if($res != 'null')
{
    $arr = $res;
}
$id="";
while(1){
    global $id;
    for($i=1;$i<=5;$i+=1) $id=$id.mt_rand(1,9);
    
    $ver = getVal('短链信息_'. $id);
    if($ver == 'null'){
        break;
    }
}
//cls('error',$id);

array_push($arr , array($hr, $id, $explain));
$res = postVal("短链列表_".$username,json_encode($arr,JSON_UNESCAPED_UNICODE));
if($res == 'success'){
    $arr=array(time(),$hr,$explain);
    $res = postVal("短链信息_".$id,json_encode($arr,JSON_UNESCAPED_UNICODE));
    cls('success',$res);
}
else{
    cls('error',$res);
}
?>