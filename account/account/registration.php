<?php
session_start();
$username = $_POST['username'];
$pass= $_POST['pass'];

if (!empty($username)|| !empty($pass)) {
	$host = "localhost";
	$dbUsername = "localhost";
	$dbPassword = "root";
	$dbname = "localhost";
	$conn = new mysqli ($host, $dbUsername, $dbPassword, $dbname);

	if(mysqli_connect_error()){
		die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
	}

	else{

		$SELECT = "SELECT username from account where username = ? limit 1";
		$INSERT = "INSERT into account (username, pass) values (?, ?)";
		$stmt = $conn->prepare($SELECT);
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->bind_result($username);
		$stmt->store_result();
		$rnum = $stmt->num_rows;

		if($rnum==0){
			$stmt = $conn->prepare($INSERT);
			$stmt ->bind_param("ss",$username, $pass);
			$stmt->execute();
			echo '<script>alert("REGISTRATION SUCCESSFUL")</script>';
			echo ("<script>location.href = 'login.html'</script>");
				
		}else{
			echo '<script>alert("THE USERNAME ALREADY EXISTS PLEASE TRY AGAIN")</script>';
			echo ("<script>location.href = 'registration.html'</script>");
		}

		$stmt->close();
		$conn->close();
	}
}

?>
