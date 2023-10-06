<?php
$ret;
$reta;
$resa;
$flag = true;
$pst = $_POST;
$conn = new mysqli('localhost', 'users', '4B8mDxsbZdk6tpec', 'users');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = addslashes($_POST["userName"]);
	$userTag = addslashes($_POST["userTag"]);
	$conn = new mysqli('localhost', 'users', '4B8mDxsbZdk6tpec', 'users');
	if ($conn->connect_error)
		die("Connection failed: " . $conn->connect_error);

	// var_dump($conn);

	mysqli_select_db($conn, $db->$dbname);

	$sql = "SELECT * FROM users where name = '" . $name . "' limit 0,1;";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		if (addslashes($row["name"]) == $name) {
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

	$sql = "SELECT name FROM users";
	$result = mysqli_query($conn, $sql);

	$sql = "UPDATE users SET userTag = '" . $userTag . "' where name = '" . $name . "'";
	// userTag
	if ($conn->query($sql) === TRUE) {
		$ret['status'] = "success";
		echo json_encode($ret, JSON_UNESCAPED_UNICODE);
		return;
	} else {
		$ret['status'] = "error";
		$ret['msg'] = "修改失败，请联系管理员";
		echo json_encode($ret, JSON_UNESCAPED_UNICODE);
		return;
	}
}
echo json_encode($ret, JSON_UNESCAPED_UNICODE);
?>