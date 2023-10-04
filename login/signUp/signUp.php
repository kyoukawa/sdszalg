<?php
$ret;
$pst = $_POST;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$name = addslashes($_POST["userName"]);
	$password = addslashes($_POST["password"]);

	if (empty($name) or empty($password)) {
		$ret['status'] = "error";
		$ret['msg'] = "用户名、密码均不能为空";
		echo json_encode($ret, JSON_UNESCAPED_UNICODE);
		return;
	}

	$conn = new mysqli('localhost', 'users', '4B8mDxsbZdk6tpec', 'users');
	if ($conn->connect_error)
		die("Connection failed: " . $conn->connect_error);

	// var_dump($conn);

	mysqli_select_db($conn, $db->$dbname);

	$sql = "SELECT name FROM users";
	$result = mysqli_query($conn, $sql);
	while ($row = mysqli_fetch_assoc($result)) {
		if (addslashes($row["name"]) == $name) {
			$ret['status'] = "error";
			$ret['msg'] = "请勿重复注册";
			echo json_encode($ret, JSON_UNESCAPED_UNICODE);
			return;
		}
	}

	$sql = "INSERT INTO users (name, password) VALUES ('" . $name . "', '" . "$password" . "')";
	if ($conn->query($sql) === TRUE) {
		$ret['status'] = "success";
		echo json_encode($ret, JSON_UNESCAPED_UNICODE);
		return;
	} else {
		$ret['status'] = "error";
		$ret['msg'] = "注册失败，请联系管理员";
		echo json_encode($ret, JSON_UNESCAPED_UNICODE);
		return;
	}
}
echo json_encode($ret, JSON_UNESCAPED_UNICODE);
?>