<?php

	session_start();

	include('dbconnect.php');

?>


<!DOCTYPE html>
<html>
<head>
	<title>Suggestions and Comments</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
</head>
<body style="padding-top: 70px">
			<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container-fluid" >
			    <div class="navbar-header">
			      <a class="navbar-brand" href="index.php">Blog.com</a>
			    </div>
			    <ul class="nav navbar-nav">
			      <li><a href="index.php">Home</a></li>
				  <li><a href="newpost.php">Create new post</a></li>
				  <li class="active"><a href="showcontact.php">View suggestions and comments</a></li>
				  <li><a href="adminpage.php">Edit permissions</a></li>
				  <li><a href="temp.php">View and edit posts</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
			      	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			    </ul>
			  </div>
			</nav>
	<div>
			<div id="commentshow">
			<?php
				$query = $db->query("SELECT * FROM contact ORDER BY comment_id DESC");
				while($row = $query->fetch_object()):
			?>

				<div style="text-indent: 30px">
					<h2><?php echo $row->name ?> says:</h2>
					<h6><?php echo $row->email_id ?></h6>
					<blockquote><?php echo $row->comment_desc ?></blockquote>
				</div>
				<hr style="border: solid black 2px">

			<?php endwhile ?>

		</div>
		

	</div>
	
</body>
</html>