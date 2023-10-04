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
$st = intval($pst['start']);
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败');
}
if(property_exists($ret,'isip'))
    cls("ip","ip");
$username=json_decode(($ret->msg))->name;


$res = getVal('创建所有问卷_' . $username);

global $rhtml;
$rhtml = '
<table style="width: 90%;font-weight: bold">
<thead>
    <tr>
        <td>问卷编号</td>
        <!--<td>问卷名称</td>-->
        <!--<td>创建时间</td>-->
        <td>详情</td>
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
    $wjlist = $res;
    $formax = max(count($wjlist)-1, $st+4);
    for($i = $st;$i <= $formax;$i += 1)
    {
        $wjid = $wjlist[$i];
        $frindex = $i;

        $rhtml .= '
        <tr>';
        $rhtml .= '
            <td>'.$wjid.'</td>
        ';

        /* :(
        $rhtml .= '
            <td colspan="2">暂不支持读取</td>
        ';
        */
        //
        $rhtml .= '
            <td><el-button type="info" icon="el-icon-s-data" circle onclick="window.open(`/wj/wjDetail.html?wjid='.$wjid.'`)"></el-button></td>
        ';
        // end :(
        
        /*$ininfo = getVal("问卷信息_".$wjid);
        //$ininfo = json_decode('{"createTime":"2022/11/17 22:26:44"}');
        if($ininfo == 'null' || !is_object($ininfo)){
            $rhtml .= '
                <td colspan="2">数据异常</td>
            ';
        }
        else{
            if(property_exists($ininfo,'wjName'))
            {
                $rhtml .= '
                    <td>'.$ininfo->wjName.'</td>
                ';
            }
            else{
                $rhtml .= '
                    <td>未知</td>
                ';
            }
            if(property_exists($ininfo,'createTime'))
            {
                $rhtml .= '
                    <td>'.$ininfo->createTime.'</td>
                ';
            }
            else{
                $rhtml .= '
                    <td>数据异常</td>
                ';
            }
        }
        */
        $rhtml .= '</tr>';
    }
    
}
$rhtml .= '</tbody></table>';
cls('success',$rhtml);
?>