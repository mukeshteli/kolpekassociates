<?php
session_start();
session_destroy();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Logged Out</title>
	<style>
		body { min-height: 100vh; display: flex; flex-direction: column; justify-content: flex-end; margin: 0; }
		.logout-btn-box {
			width: 100vw;
			display: flex;
			justify-content: center;
			align-items: flex-end;
			padding: 40px 0 30px 0;
			background: none;
		}
		.logout-btn {
			background: #e53935;
			color: #fff;
			border: none;
			border-radius: 6px;
			padding: 16px 40px;
			font-size: 1.2rem;
			font-weight: bold;
			cursor: pointer;
			box-shadow: 0 2px 8px rgba(0,0,0,0.08);
			transition: background 0.2s;
		}
		.logout-btn:hover {
			background: #b71c1c;
		}
	</style>
</head>
<body>
	<div class="logout-btn-box">
		<form action="index.html" method="get">
			<button type="submit" class="logout-btn">Go to Login</button>
		</form>
	</div>
</body>
</html>
