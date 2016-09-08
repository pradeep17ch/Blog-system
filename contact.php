<?php
	session_start();

	include('dbconnect.php');

	if(isset($_POST['submit'])){
		
		$email = $_POST['email'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];

		if($email && $name && $comment){

			$email = $db->real_escape_string($email);
			$name = $db->real_escape_string($name);
			$comment = $db->real_escape_string($comment);
			
			if($addcomment = $db->prepare("INSERT INTO contact (name, email_id, comment_desc) VALUES(?,?,?)")){
				$addcomment->bind_param('sss', $name, $email, $comment);
				$addcomment->execute();
				echo '<script>alert("Comment added. Thank you!");</script>';
				$addcomment->close();
			}
			
				else
				echo '<script>alert("Values not inserted.");</script>';
			
		}
		else{
			echo '<script>alert("You havent entered some fields.");</script>';
		}

	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>
		Contact Us - Stay in touch!	
	</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body style="padding-top: 100px">
		<?php 
    		if(isset($_SESSION['blogger_id'])){
      			echo '
		      		<nav class="navbar navbar-inverse navbar-fixed-top">
					  <div class="container-fluid" >
					    <div class="navbar-header">
					      <a class="navbar-brand" href="index.php">Blog.com</a>
					    </div>
					    <ul class="nav navbar-nav">
					      <li class="active"><a href="index.php">Home</a></li>
					    </ul>
					    <ul class="nav navbar-nav navbar-right">
					    	<li class="active"><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
					    	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					    </ul>
					  </div>
					</nav>

      			';
      		}

      		else{
      				echo '
		      		<nav class="navbar navbar-inverse navbar-fixed-top">
					  <div class="container-fluid" >
					    <div class="navbar-header">
					      <a class="navbar-brand" href="home.php">Blog.com</a>
					    </div>
					    <ul class="nav navbar-nav">
					      <li class="active"><a href="home.php">Home</a></li>
					    </ul>
					    <ul class="nav navbar-nav navbar-right">
					    	<li><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
					    	<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					    	<li class="active"><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
					    </ul>
					  </div>
					</nav>

      			';
      		}
		?>
			

	<div style="display: flex;">
		<div style="width:25%"></div>
		<div style="text-align: center; border: solid black 2px; width: 50%">
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				<div style="padding: 20px">
					<input type="text" placeholder="Name" style="height: 30px; width: 200px; font-size: 15px" name="name">
				</div>

				<div style="padding: 20px">
					<input type="text" placeholder="Email address" style="height: 30px; width: 300px; font-size: 15px" name="email">
				</div>
				
				<div style="padding: 20px">
					<textarea name="comment" placeholder="The comment goes.." cols=50 rows=10></textarea>
				</div>
				<button type="submit" name="submit" style="width: 150px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;" value="submit">Submit</button><br><br>


			</form>
		</div>		
	</div>

</body>
</html>