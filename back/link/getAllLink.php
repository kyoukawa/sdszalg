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


$res = getVal('短链列表_' . $username);

global $rhtml;
$rhtml = '

<table style="width: 90%;font-weight: bold" class="ytable">
<thead>
    <tr>
        <td>链接编号</td>
        <td>链接地址</td>
        <td>说明</td>
        <td>短链网址</td>
    </tr>
</thead>
<tbody>
';
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    $rhtml .= '
        <tr>
            <td colspan="3">无数据</td>
        </tr>
    ';
}
else{
    $linklist = $res;
    for($i = 0;$i <= count($linklist)-1;$i += 1)
    {
        $lb = $linklist[$i];

        $rhtml .= '
        <tr>';
        $rhtml .= '
            <td>'.$lb[1].'</td>
        ';
        if(strlen($lb[0]) <= 20)
        {
            $rhtml .= '
                <td>'.$lb[0].'</td>
            ';
        }
        else
        {
            $rhtml .= '
                <td>'.substr($lb[0],0,20).'<el-button circle @click="$alert(\''.$lb[0].'\',\'链接网址 - '.$lb[1].'\',{type: \'info\'})"><i class="el-icon-more"></i></el-button></td>
            ';
        }
        
        if(count($lb) >= 3)
        {
            $rhtml .= "<td>".$lb[2]."</td>";
        }
        else{
            $rhtml .= "<td>/</td>";
        }

        $rhtml .= '
            <td>
                <el-button  class="btn" data-clipboard-action="copy" data-clipboard-text="sunorange.cn/l?i='.$lb[1].'">复制短链</el-button>
            </td>
        ';
        $rhtml .= '</tr>';
    }
    
}
$rhtml .= '</tbody></table>';
cls('success',$rhtml);
?>