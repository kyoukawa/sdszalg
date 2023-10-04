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
$cont = $pst['cont'];

$ret = getInfo($token);
$username=json_decode(urldecode(($ret->msg)))->name;

if(!array_key_exists("wjid",$cont)){
    cls('error','缺少参数1，请联系管理员');
}
$wjid=$cont['wjid'];
$bindingName = $pst['bindingName'];

$wjInfo = json_decode(getVal('问卷信息_' . $wjid));
$veri = getVal("答卷_".$wjid."_".$username."_".$bindingName);
if($veri != 'null'){
    if(!is_object($wjInfo) || !isset($wjInfo->repeat) || $wjInfo->repeat != true)
    {
        cls('error','您已经填写过此问卷，请勿重复填写');
    }
    $i = 1;
    for(;;$i+=1){
        $veri = getVal("答卷_".$wjid."_".$username."_".$i."_");//其实不严谨，可能是信息确认类型，但信息确认类型不能多次填写
        if($veri == 'null') break;
    }
    $username = $username . "_" . $i;
}


$res = getVal('问卷_' . $wjid);
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    cls('error','问卷不存在');
}

$rr = array();
$len = count($res);
for($i = 0;$i < $len;$i+=1){
    $inv = $res[$i];
    //if(array_key_exists('req',$inv[2]))
    //cls('error',in_array('req',$inv[2]));
    if($inv[0] == 'input'){
        if(!(array_key_exists('item1at'.$i,$cont) && trim($cont['item1at'.$i]," ") != '') && array_key_exists(2,$inv) && in_array('req',$inv[2]))
            cls("error","有必填项(文本输入题)未填写，请检查");
    }
    else if($inv[0] == 'radio'){
        if(!(array_key_exists('item1at'.$i,$cont) && trim($cont['item1at'.$i]," ") != '') && array_key_exists(2,$inv) && in_array('req',$inv[2]))
            cls("error","有必填项(单选题)未填写，请检查");
    }
    else if($inv[0] == 'checkbox'){
        if(array_key_exists('item1at'.$i,$cont))
        {
            $minA=(array_key_exists(3,$inv)?$inv[3]:1);
            $maxA=(array_key_exists(4,$inv)?$inv[4]:10000);
            if(count($cont['item1at'.$i]) > $maxA || count($cont['item1at'.$i]) < $minA)
                cls("error","有多选题需要选择".$minA."~".$maxA."项，你选择了".count($cont['item1at'.$i])."项，请检查");
        }
        else if(array_key_exists(2,$inv) && in_array('req',$inv[2]))
            cls("error","有必填项(多选题)未填写，请检查");
    }
}
//接下来，上传rr
$nptr = json_encode($cont,JSON_UNESCAPED_UNICODE+JSON_UNESCAPED_SLASHES);
$nptr = str_replace("\\n", "\\\\n", $nptr);
$ptr = postVal("答卷_".$wjid."_".$username."_".$bindingName,$nptr);
if($ptr != 'success'){
    cls('error',"上传问卷数据时出错");
}
$ptr = getVal("所有答卷_".$wjid);
if($ptr == 'null')
{
    $ptr = array();
}
if(!in_array($username."_".$bindingName,$ptr))
    array_push($ptr , $username."_".$bindingName);
$nptr = json_encode($ptr, JSON_UNESCAPED_UNICODE);

$ptr = postVal("所有答卷_".$wjid,$nptr);
if($ptr != 'success'){
    cls('error',"上传答卷列表失败");
}
cls('success','success');
?>
