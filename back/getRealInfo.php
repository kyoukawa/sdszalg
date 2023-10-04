<?php
$conn = new mysqli('localhost', 'users', '4B8mDxsbZdk6tpec', 'users');

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
$gloname = "";
$resa;
// function getValBD($tag)
// {
//     $api = 'http://tinywebdb.appinventor.space/api?user=xjc0317&secret=77e45d31&action=get&tag=' . urlencode($tag);
//     $ch = curl_init();
//     $options = array(
//         CURLOPT_URL => $api,
//         CURLOPT_RETURNTRANSFER => true,
//     );
//     curl_setopt_array($ch, $options);
//     $rt = curl_exec($ch);
//     $rt = json_decode($rt, true);
//     //return count($rt[$tag]);
//     return $rt[$tag];
// }

function getValBD($tag, $key)
{
    // tag for label, key for name
    global $conn;
    global $resa;
    $flag = true;
    $sql = "SELECT * FROM users where name = '" . $key . "' limit 0,1;";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        if (addslashes($row["name"]) == $key) {
            $resa = $row[$tag];
            $flag = false;
            break;
        }
    }
    if ($flag) {
        return cls_r("error", "用户不存在");
    }
    return $resa;
}

function get_main()
{
    require_once 'basic.php';
    date_default_timezone_set('PRC');
    $pst = $_POST;
    $token = $pst['token'];
    if (empty($token)) {
        return cls_r("error", "登录失败，未提供token参数");
    }
    $dec = deToken($token);
    $ndec = explode(",", $dec);
    //return cls_r("success",json_encode(array("name"=>'ceshi')));
    $regname = $ndec[0];
    $regpwd = $ndec[1];
    global $gloname;
    $gloname = $regname;

    if (time() - $ndec[2] < 0) //伪造token
    {
        return cls_r("error", "时间验证失败");
    }
    if (key_exists('ip', $pst) && key_exists('location', $pst)) {
        $ip = $pst['ip'];
        $loc = $pst['location'];
        $res = postVal('登录信息web_' . $gloname, json_encode(array(date('Y-m-d H:i:s', time()), $ip, $loc), JSON_UNESCAPED_UNICODE));
        //return cls_r("cs",$res);
    }
    //return cls_r("error","登录失效，请重新登录test");//test
    if ($regpwd == 'ip') {
        $rets = array();
        $rets['status'] = 'success';
        $rets['msg'] = json_encode(array("name" => $regname), JSON_UNESCAPED_UNICODE);
        $rets['isip'] = 'isip';
        return json_encode($rets, JSON_UNESCAPED_UNICODE);
    }
    /*if(time()-$ndec[3] > 3600)//1h后登录失效
    {
        return cls_r("error","登录失效，请重新登录");
    }*/
    if (time() - $ndec[2] < 60) {
        return cls_r("success", json_encode(array("name" => $regname), JSON_UNESCAPED_UNICODE));
    }
    //if(time() - $dec[3] > 60)
    $nres = getValBD("password", $regname);

    //$nres = getVal('用户_ceshi');
    // if ($nres == 'null') {
    //     return cls_r("error", "用户不存在");
    // }
    //return cls_r("cs63","err：token：".$token."；nres：".gettype($nres));
    //return cls_r("cs72","err：regname：".$regname);
    if ($nres != $regpwd) {
        return cls_r("error", "请重新登录");
    }
    return cls_r("success", json_encode(array("name" => $regname), JSON_UNESCAPED_UNICODE));
}
$ret = get_main();
$pst = $_POST;

if ($pst['type'] == 'e') {
    echo $ret;
}
?>