<?php
require_once 'basic.php';
$pst = $_POST;

$content = $pst['content'];

$oary = explode(' ', $content);
$ary = array();
foreach($oary as $item)
{
    if($item != '')
    {
        array_push($ary, $item);
    }
}
//$ret['status'] = "success";
//$ret['msg'] = "Sunorange terminal does not support any operation temporarily. Coming soon.";
$sz = sizeof($ary);
if(!isset($ary[0])){
    cls("success", "[Error] Can't process empty request.");
}
if(!isset($ary[1]))
{
    cls("success", "[Error] There must be at least two parameters, but you only provided one.");
}

if($ary[0] == 'sys'){
    if($ary[1] == 'goto')
        cls("success", "[Success] (sys-goto).".$ary[2]." <a target=\"_blank\" href=\"".$ary[2]."\"><button>click</button></a>");
    if($ary[1] == 'clearLocalS')
        cls("action", "clearStorage");
}
else{
    cls("success", "[Error] We do not provide this function temporarily");
}

cls("success", "[Error] We do not provide this function temporarily");
?>