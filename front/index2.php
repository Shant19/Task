<?php
$base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/Task/';
$db 	  = new mysqli('localhost', 'root', '', 'task');
$token 	  = $_GET['token'];
$res 	  = $db->query("SELECT * FROM users WHERE token='$token'");
$res 	  = $res ? $res->fetch_all(true) : [];

if (!count($res)) {
	header('Location:' . $base_url . 'front');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<style>
body {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
}
div {
	width: 200px;
	height: 200px;
	background: #ccc;
	display: flex;
	justify-content: center;
	align-items: center;
	flex-direction: column;
}
</style>
<body>
	<input type="hidden" value="<?=$base_url?>" id="bUrl">
	<div id="form">
		<span id="info"></span>
		<input type="text" placeholder="name" id="name">
		<input type="text" placeholder="surname" id="surname">
		<button id="sendInfo">Submit</button>
	</div>
</body>
<script src="../assets/script.js"></script>
</html>