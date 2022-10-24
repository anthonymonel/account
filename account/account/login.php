<?php
	session_start();
	$username = $_POST['username'];
	$pass = $_POST['pass'];

	$con = new mysqli("localhost","localhost", "root","localhost");

	if($con->connect_error){
		die("Failed to connect: ".$con->connect_error);
        }

	else{
	$stmt = $con->prepare("select * from account where username = ?");
	$stmt->bind_param("s",$username);
	$stmt->execute();
	$stmt_result = $stmt->get_result();

	if($stmt_result->num_rows > 0 ){

		$data = $stmt_result->fetch_assoc();
		if($data['pass']== $pass){

			$_SESSION['username'] = $data['username'];
			$pass="";

			if(isset($_POST['submit'])){
				$pass=$_POST['pass'];

				if(preg_match("/([%\$#\*_@!]+)/", $pass)){
					echo("<script>alert('YOUR PASSWORD SHOULD NOT HAVE ANY SPECIAL CHARACTERS')</script>");
					echo ("<script>location.href = 'login.html'</script>");
					
					}

					else{
					echo("<script>alert('LOGIN SUCCESSFULLY')</script>");
					echo ("<script>location.href = 'welcome.php'</script>");
					echo $pass;
					}
			}
		}

		else{
			echo("<script>alert('INVALID USERNAME OR PASSWORD, PLEASE TRY AGAIN')</script>");
			echo ("<script>location.href = 'login.html'</script>");
		
		}
	}

	else{
			echo("<script>alert('INVALID USERNAME OR PASSWORD, PLEASE TRY AGAIN')</script>");
			echo ("<script>location.href = 'login.html'</script>");
			
	}
}

?>