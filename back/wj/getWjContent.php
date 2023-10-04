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
$wjid = $pst['wjid'];
$ret = getInfo($token);
if($ret->status != 'success')
{
    cls('error','用户登录失败：'.$ret->msg);
}
$username=json_decode(urldecode(($ret->msg)))->name;
$res = getVal('答卷_' . $wjid . '_' . $username);
$veri = json_decode(getVal('问卷信息_' . $wjid));
if($res != 'null'){
    if(!is_object($veri) || isset($veri->repeat) || $veri->repeat != true)
    {
        cls('error','您已经填写过此问卷，请勿重复填写');
    }
}
if(is_object($veri) && isset($veri->open) && $veri->open == false)
{
    cls('error','问卷未开放填写');
}   
$res = getVal('问卷_' . $wjid);
if(json_encode($res,JSON_UNESCAPED_UNICODE) == '"null"'){
    cls('error','问卷不存在');
}
$rhtml = '<input name="wjid" class="form_wjid" readonly hidden/>';
$sz = count($res);
for($ii = 0;$ii < $sz;$ii+=1){
    $item = $res[$ii];
    $qtp = $item[0];//question type
    
    $shangBianJu = false;
    if(key_exists(2,$item)) $shangBianJu = in_array('shangBianJu',$item[2]);
    if($shangBianJu)
    {
        $rhtml .= '<div style="height:0.8em"></div>';
    }
    if($qtp == 'text')
    {
        $cuTi = false;
        $xieTi = false;
        if(key_exists(2,$item)) $cuTi = in_array('cuTi',$item[2]);
        if(key_exists(2,$item)) $xieTi = in_array('xieTi',$item[2]);
        $align = "left";
        if(key_exists(2,$item))
        {
            if(in_array('alignleft',$item[2]))
            {
                $align = "left";
            }
            else if(in_array('aligncenter',$item[2]))
            {
                $align = "center";
            }
            else if(in_array('alignright',$item[2]))
            {
                $align = "right";
            }
        }

        $rhtml .= '<div style="text-align:'.$align.'">';
        
        if($cuTi) $rhtml .= '<b>';
        if($xieTi) $rhtml .= '<i>';
        $rhtml .= '<div>'.$item[1].'<br/></div>';
        if($xieTi) $rhtml .= '</i>';
        if($cuTi) $rhtml .= '</b>';
        $rhtml .= '</div>';
        
    }
    else if($qtp == 'info')
    {
        $pre = $pst['pre'];
        if($pre == '')
        {
            cls('empty','empty');
        }
        $infoData = getVal('问卷info数据_' . $wjid);
        $infoData0 = explode(':',$infoData);
        $infoData1 = explode(',',$infoData0[0]);
        $infoData2 = explode(';',$infoData0[1]);
        //下面是验证是否正确
        $nowtitle = $pre[0]['title'];
        $nowvalue = $pre[0]['value'];
        $firstVal = $nowvalue;
        $row = -1;
        for($i = 0;$i < count($infoData1);$i+=1)
        {
            if($infoData1[$i] == $nowtitle){
                for($j = 0;$j < count($infoData2);$j+=1)
                {
                    $shuzu = explode(',',$infoData2[$j]);
                    if($shuzu[$i] == $nowvalue)
                    {
                        $row = $j;
                    }
                }
            }
        }
        if($row == -1){
            cls('error',"NOT FOUND!");
        }
        $userArr = explode(',',$infoData2[$row]);
        for($i = 0;$i < count($userArr);$i+=1)
        {
            for($j = 0;$j < count($pre);$j+=1)
            {
                if($pre[$j]['title'] == $infoData1[$i])
                {
                    if($pre[$j]['value'] != $userArr[$i]) cls('error',"信息不匹配，请重新点击链接填写!");
                }
            }
        }
        //$rhtml .= '<el-input disabled type="textarea" autosize v-model="wjAns.item1at'.$i.'" placeholder="'.$item[1].' OKOK！" style="width:100%" ></el-input>'.$nowvalue;
        //$rhtml .= json_encode($userArr);
        $rhtml .= '<el-descriptions title="" border :column="1">';
        for($i = 0;$i < count($userArr);$i+=1)
        {
            $rhtml .= '<el-descriptions-item label="'.$infoData1[$i].'">'.$userArr[$i].'</el-descriptions-item>';
        }
        $rhtml .= '</el-descriptions>';
    }
    else if($qtp == 'input')
    {
        $minA=(array_key_exists(3,$item)?$item[3]:1);
        $maxA=(array_key_exists(4,$item)?$item[4]:10000);
        $rhtml .= '<el-input type="textarea" :autosize="{minRows:'.$minA.',maxRows:'.$maxA.'}" v-model="wjAns.item1at'.$ii.'" placeholder="'.$item[1].'" style="width:100%;" ></el-input>';
    }
    else if($qtp == 'radio')
    {
        $insz = count($item[1]);
        $button = false;
        if(key_exists(2,$item)) $button = in_array('button',$item[2]);
        $rhtml .= '<div class="row" style="justify-content:flex-start;text-align:left"><el-radio-group size="medium" v-model="wjAns.item1at'.$ii.'" >';
        for($j = 0;$j < $insz;$j+=1)
        {
            $radc = $item[1][$j];
            if(!$button) $rhtml .= '<el-radio ';
            else $rhtml .= '<el-radio-button ';
            $rhtml .= 'label="'.$j.'" style="margin:0;padding:0;cursor: pointer;"><span>'.$radc.'&nbsp;</span>';
            if(!$button) $rhtml .= '</el-radio> ';
            else $rhtml .= '</el-radio-button> ';
            //$rhtml .= '<label style="cursor: pointer"><input type="radio" name="item1at'.$i.'" value="'.$j.'" style="margin:0;padding:0;cursor: pointer;"><span>'.$radc.'&nbsp;</span></label>';
        }
        $rhtml .= '</el-radio-group>';
        $rhtml .= '<el-link type="warning" style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$ii.'=[];\'><b style="font-size:80%">[清除选择]</b></el-link>';
        //$rhtml .= '<label style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$i.'=0;\'><b style="font-size:80%">[清除选择]</b></label>';
        $rhtml .= '</div>';
        
    }
    else if($qtp == 'checkbox')
    {
        $insz = count($item[1]);
        $button = false;
        if(key_exists(2,$item)) $button = in_array('button',$item[2]);
        $rhtml .= '<div class="row" style="justify-content:flex-start;text-align:left"><el-checkbox-group size="medium" v-model="wjAns.item1at'.$ii.'" >';
        for($j = 0;$j < $insz;$j+=1)
        {
            $radc = $item[1][$j];
            if(!$button) $rhtml .= '<el-checkbox ';
            else $rhtml .= '<el-checkbox-button ';
            $rhtml .= 'label="'.$j.'" style="margin:0;padding:0;cursor: pointer;"><span>'.$radc.'&nbsp;</span>';
            if(!$button) $rhtml .= '</el-checkbox> ';
            else $rhtml .= '</el-checkbox-button> ';
        }
        $rhtml .= '</el-checkbox-group>';
        $rhtml .= '<el-link type="warning" style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$ii.'=[];\'><b style="font-size:80%">[清除选择]</b></el-link>';
        //$rhtml .= '<label style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$i.'=[];\'><b style="font-size:80%">[清除选择]</b></label>';
        
        $rhtml .= '</div>';
    }
    else
    {
        $rhtml .= '<div>[不支持的组件]</div>';
    }
    $rhtml .= '<div style="height:0.3rem"></div>';
}
$rhtml .= '<div class="center"><span><el-button :loading="isloading" type="primary" native-type="submit" class="submitWj center">提交</el-button></span></div>';
cls('success',$rhtml);
?>