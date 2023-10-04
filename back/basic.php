<?php
function postVal($tag, $val)
{
    $api = 'http://tinywebdb.appinventor.space/api?user=xj****7&secret=77e4****31&action=update&tag=' . urlencode($tag) . '&value=' . urlencode($val);
    $ch = curl_init();
    $options = array(
        CURLOPT_URL => $api,
        CURLOPT_RETURNTRANSFER => true,
    );
    curl_setopt_array($ch, $options);
    $result = json_decode(curl_exec($ch));
    return $result->status;
}
function getVal($tag, $key)
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
function cls($status, $msg)
{
    $rets = array();
    $rets['status'] = $status;
    $rets['msg'] = $msg;
    exit(json_encode($rets, JSON_UNESCAPED_UNICODE));
}
function cls_r($status, $msg)
{
    $rets = array();
    $rets['status'] = $status;
    $rets['msg'] = $msg;
    return json_encode($rets, JSON_UNESCAPED_UNICODE);
}
echo '';
?>