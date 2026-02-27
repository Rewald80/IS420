<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "is420_store";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
	die("Connection Failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$email = $_POST['email'];

$sql = "SELECT password FROM usrnames WHERE username = '$username' AND email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
	$row = $result->fetch_assoc();
	echo "Your password is: " . $row['password'];
} else {
	echo "Username and email do not match any accounts.";
}

echo "<br><br>";
echo '<button onclick=history.back()>Back</button>';

$conn->close();
?>