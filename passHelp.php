<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Password Help</title>
	<style>
		body {
			text-align: center;
			align-content: space-evenly;			
		}
		h2 {
			font-size: 20px;
		}
	</style>
</head>
<body style="text-align:center;">
	<h2>Password Help</h2>
	<form method="POST" action="showPass.php">
	<label>Username: <input type="text" name="username" required></label>
	<br>
	<br>
	<label>Email: <input type="text" name="email" required></label>
	<br>
	<br>
	<input type="submit" value="Recover Password">
	</form>	
	<br>
	<button onclick="history.back()">Back</button>

</body>
</html>