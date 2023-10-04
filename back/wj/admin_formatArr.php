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

$res = json_decode($pst['arr']);
if($res == null)
{
    cls('success',"[还未开始创建问卷]");
}

$rhtml = '<input name="wjid" class="form_wjid" readonly hidden/>';
$sz = count($res);
for($i = 0;$i < $sz;$i+=1){
    $item = $res[$i];
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
    else if($qtp == 'input')
    {
        $minA=(array_key_exists(3,$item)?$item[3]:1);
        $maxA=(array_key_exists(4,$item)?$item[4]:10000);
        $rhtml .= '<el-input type="textarea" :autosize="{minRows:'.$minA.',maxRows:'.$maxA.'}" v-model="wjAns.item1at'.$i.'" placeholder="'.$item[1].'" style="width:100%;" ></el-input>';
    }
    else if($qtp == 'radio')
    {
        $insz = count($item[1]);
        $button = false;
        if(key_exists(2,$item)) $button = in_array('button',$item[2]);
        $rhtml .= '<div class="row" style="justify-content:flex-start;text-align:left"><el-radio-group size="medium" v-model="wjAns.item1at'.$i.'" >';
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
        $rhtml .= '<el-link type="warning" style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$i.'=[];\'><b style="font-size:80%">[清除选择]</b></el-link>';
        //$rhtml .= '<label style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$i.'=0;\'><b style="font-size:80%">[清除选择]</b></label>';
        $rhtml .= '</div>';
        
    }
    else if($qtp == 'checkbox')
    {
        $insz = count($item[1]);
        $button = false;
        if(key_exists(2,$item)) $button = in_array('button',$item[2]);
        $rhtml .= '<div class="row" style="justify-content:flex-start;text-align:left"><el-checkbox-group size="medium" v-model="wjAns.item1at'.$i.'" >';
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
        $rhtml .= '<el-link type="warning" style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$i.'=[];\'><b style="font-size:80%">[清除选择]</b></el-link>';
        //$rhtml .= '<label style="cursor: pointer" onclick=\'vmphp.wjAns.item1at'.$i.'=[];\'><b style="font-size:80%">[清除选择]</b></label>';
        
        $rhtml .= '</div>';
        /*
        $insz = count($item[1]);
        $rhtml .= '<div>';
        for($j = 0;$j < $insz;$j+=1)
        {
            $radc = $item[1][$j];
            $rhtml .= '<label style="cursor: pointer"><input type="checkbox" name="item1at'.$i.'" value="'.$j.'" style="margin:0;padding:0;cursor: pointer"><span>'.$radc.'&nbsp;</span></label>';
        }
        $rhtml .= '<label style="cursor: pointer" onclick=\'$("input[name=\\"item1at'.$i.'\\"]").prop("checked",false)\'><b style="font-size:80%">[清除选择]</b></label>';
        $rhtml .= '</div>';
        */
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