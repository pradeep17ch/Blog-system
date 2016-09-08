<?php
	session_start();

	if(isset($_POST['submit'])){
		
		$user=$_POST['username'];
		$pass=$_POST['password'];

		include('dbconnect.php');

		if(empty($user) || empty($pass)){
			echo '<script> alert("Missing information") </script>';

		}

		else{
			$user = strip_tags($user);
			$user = $db->real_escape_string($user);


			$pass = strip_tags($pass);
			$pass = $db->real_escape_string($pass);
			$pass = md5($pass);

			$query = $db->query("SELECT blogger_id, blogger_username FROM blogger_info WHERE blogger_username='$user' AND blogger_password='$pass'");

			if($query->num_rows === 1){
				while ($row = $query->fetch_object()) {
					$_SESSION['blogger_id'] = $row->blogger_id;
				}
				//echo $_SESSION['blogger_id'];
				header('Location: index.php');
				exit();
			}
			else{
				echo "<script>alert('Incorrect username or password.');</script>" ;
			}
		}
	}
?>

<html>
	<head>
	<title>Login</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="index.css">
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
		
		<link href='http://fonts.googleapis.com/css?family=Orbitron' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Muli:300,400' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:300italic,300' rel='stylesheet' type='text/css'>
		<link href='http://fonts.googleapis.com/css?family=Lora:400,700' rel='stylesheet' type='text/css'>
	</head>

	<body >
	<div style="background-color: ">
			<nav class="navbar navbar-inverse">
			  <div class="container-fluid" >
			    <div class="navbar-header">
			      <a class="navbar-brand" href="home.php">Blog.com</a>
			    </div>
			    <ul class="nav navbar-nav">
			      <li><a href="home.php">Home</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
			      <li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
			      <li class="active"><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
			      <li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
			    </ul>
			  </div>
			</nav>

			<br><br>
			<div class="login">
			<br>
				<div>
					<img src="images/blogf2.gif" style="height:200px; width:200px; ">
				</div>
				<br><br><br>
				<form action="login.php" method="post">
				
					<p><input class="resize" placeholder="Username" type="text" name="username"></p>
					
					<p><input class="resize" placeholder="Password" type="password" name="password"></p>
					
					<button class="loginbut" type="submit" name="submit" value="login">Login</button>
				</form>

				<div class="newuser">
					<a href="register.php">New user?</a>

				</div>
				<br>
			</div> 
			

	</div>

	</body>

	</html>
