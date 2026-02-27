<?php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "is420_store";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
	die("Connection Failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM usrnames WHERE username = '$username' AND password = '$password'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
	$_SESSION['username'] = $username;
	echo "Login successful. Welcome $username.";
	header("refresh:1;url=store.php");
	exit();
} else {
	echo ("Invalid username or password.");
}


$conn->close();
?>