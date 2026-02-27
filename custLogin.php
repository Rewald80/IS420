<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body style="text-align: center;">
	<h2>Customer Login</h2>
	<form method="POST" action="processLogin.php">
		<label>Username: <input type="text" name="username" required></label>
			<br>
			<br>
			<label>Password: <input type="password" name="password" required></label>
			<br>
			<br>
			<input type="submit" value="Login">
	</form>
	<br>
	<a href="signup.php">
		<button>Create Account</button>
	</a>
	<br>
	<br>
	<a href="index.php"><button>Home</button></a>
</body>
</html>