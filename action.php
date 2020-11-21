<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>SQL Injection form error example</title>
	<meta name="description" content="Twitter Bootstrap Version2.0 form error example from w3resource.com."> 
	<link href="http://localhost/twitter-bootstrap/twitter-bootstrap-v2/docs/assets/css/bootstrap.css" rel="stylesheet">
</head>
<body style="margin-top: 50px">
	<div class="container"><div class="row"><div class="span6">
 
	<?php
	$host="localhost";
	$username="root";
	$password="";
	$db_name="SQL_INJECTION_EXAMPLE";
	$conn=new mysqli($host,$username,$password,$db_name);
	
	$uid = $_POST['uid'];
	$pid = $_POST['passid'];
	
	//INSERT INTO user_details (user_id, password) VALUES ('$user_id', SHA2(CONCAT('$password','$user_id'),512))
	//$result = $conn->query("SELECT * FROM user_details WHERE user_id = '$uid' AND password = SHA2(CONCAT('$pid','$uid'),512)");
	$result = $conn->query("select * from user_details where user_id = '$uid' and password = '$pid'" );

	if($result->num_rows > 0){
		echo "<h4>"."-- Personal Information -- "."</h4>","</br>";
		while ($row = $result->fetch_assoc()){
			echo "id: " . $row["user_id"]. "<br>Name: " . $row["fname"]. " " . $row["lname"]. "<br>Email: " . $row["email"]. "<br>";
			echo "--------------------------------------------<br>";
		}
	}else echo "Invalid user id or password";
	?>
	</div></div></div>
</body>
</html>