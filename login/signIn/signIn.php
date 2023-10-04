<?php

$ret;
$reta;
$resa;
$flag = true;
$pst = $_POST;
$name = addslashes($_POST["userName"]);
$password = addslashes($_POST["password"]);
$conn = new mysqli('localhost', 'users', '4B8mDxsbZdk6tpec', 'users');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function makeToken($name, $pwd, $tm)
{
    $str = $name . "," . $pwd . "," . $tm;
    $reta = base64_encode($str);
    return $reta;
}
function deToken($str)
{
    $reta = base64_decode($str);
    return $reta;
}

mysqli_select_db($conn, $db->$dbname);
// $sql = "SELECT * FROM users";
$sql = "SELECT * FROM users where name = '" . $name . "' limit 0,1;";
$result = mysqli_query($conn, $sql);

if (empty($name) or empty($password)) {
    $ret['status'] = "error";
    $ret['msg'] = "用户名、密码均不能为空";
    echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    return;
}
while ($row = mysqli_fetch_assoc($result)) {
    if (addslashes($row["name"]) == $name) {
        $resa = $row["password"];
        $flag = false;
        break;
    }
}
if ($flag) {
    $ret['status'] = "error";
    $ret['msg'] = "用户不存在";
    echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    return;
}
if ($resa != $password) {
    $ret['status'] = "error";
    $ret['msg'] = "密码错误";
    echo json_encode($ret, JSON_UNESCAPED_UNICODE);
    return;
}
$reta['status'] = "success";
$cs = makeToken($name, $password, strval(time()));
$reta['msg'] = $cs;
// $ret['msg'] = deToken($cs);
if (key_exists('ip', $pst) && key_exists('location', $pst)) {
    $ip = $pst['ip'];
    $loc = $pst['location'];
}
echo json_encode($reta, JSON_UNESCAPED_UNICODE);
// $ret['status'] = "token";
// echo json_encode($ret, JSON_UNESCAPED_UNICODE);
?>