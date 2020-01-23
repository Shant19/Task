<?php $base_url = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . '/Task/' ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title></title>
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
		<input type="email" placeholder="Email" id="email">
		<button id="addEmail">Submit</button>
	</div>
</body>
<script src="../assets/script.js"></script>
</html>