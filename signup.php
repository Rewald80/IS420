<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "is420_store");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $new_username = trim($_POST['new_username']);
    $new_password = trim($_POST['new_password']);
    $new_email = trim($_POST['new_email']);

    $stmt = $conn->prepare("SELECT * FROM usrnames WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $email_result = $stmt->get_result();

    if ($email_result->num_rows > 0) {
        echo "<p style='color:red; text-align:center;'>This email is already linked to an account. <a href='passwordHelp.php'>Recover your password</a>.</p>";
        exit;
    } 

    $combo_check = $conn->prepare("SELECT * FROM usrnames WHERE username = ? AND password = ?");
    $combo_check->bind_param("ss", $new_username, $new_password);
    $combo_check->execute();
    $combo_result = $combo_check->get_result();

    if ($combo_result->num_rows > 0) {
    	echo "This username cannot be used with this password, please select a new username or password and try again.<br><a href='signup.php'><button>Create Account</button></a>";
    	exit;
    }

    $insert = $conn->prepare("INSERT INTO usrnames (username, password, email) VALUES (?, ?, ?)");
    $insert->bind_param("sss", $new_username, $new_password, $new_password);

    if ($insert->execute()) {
    	echo "Account Created. <a href='custLogin.php'>Go to login</a>";
    } else {
    	echo "Account Creation Failed.";
    }

    $conn->close();
}
    ?>


<!DOCTYPE html>
<style>
	body {
		font-size: 20px;
		text-align: center;
		align-content: space-evenly;
		font-family: Arial, sans-serif;
	}
	h2 {
		color: black;
		font-size: 40px;
	}
</style>
<html>
<head>
	<meta charset="utf-8">
	<title>Sign Up</title>
</head>
<body style="text-align: center;">
	<h2>Create a New Account</h2>
	<form method="POST" action="signup.php">
		<label>Username: <input type="text" name="new_username" required></label>
		<br><br>
		<label>Password: <input type="password" name="new_password" required></label>
		<br><br>
		<label>Email: <input type="email" name="new_email" required></label>
		<br><br>
		<input type="submit" value="Create Account">
	</form>

	<br>
	<a href="custLogin.php"><button>Back to Login</button></a>
</body>
</html>
