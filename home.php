<?php
	
	session_start();
	include('dbconnect.php');

	$query = $db->prepare("SELECT blog_id, blog_title, LEFT(blog_desc,100) AS blog_desc, cat_name, blogger_username FROM blog_master INNER JOIN categories ON blog_category = category_id INNER JOIN blogger_info ON blogger_info.blogger_id = blog_master.blogger_id ORDER BY blog_id DESC LIMIT 0,10");
	$query->execute();
	$query->bind_result($blog_id, $title, $body, $category, $name);

?>


<!DOCTYPE html>

<html>

	<head>
		<title>Blog.com -Create your own world</title>
			<link rel="stylesheet" type="text/css" href="index.css">
			<link rel="stylesheet" type="text/css" href="bootstrap.css">
	</head>

	<body style="padding-top: 50px">

		<div style="background-color: ;">
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
			      <li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
			    </ul>
			  </div>
			</nav>
		</div>

		<div>
			<img style="width: 100%" src="images/blogn.jpg">
		</div>

		<div style="text-indent: 30px">
			<h1 style="font-family: arial">Recent blogs</h1>
		</div>

		<div style="display: flex">
			<div style="width: 75%" >
				<?php
					while ($query->fetch()):
					$lastspace = strrpos($body, ' ');
				?>

				<div style="text-align: left; text-indent: 30px; background-color: #d3d3d3; margin: 10px; border-radius: 20px; padding: 10px; ">
					<h2 style="font-family: times new roman"><?php echo '<u>'.$title.'</u>' ?></h2>
					<h4>By: <?php echo $name ?></h4>
					<h6><?php echo $category ?></h6>
					<p><?php echo substr($body, 0, $lastspace). "<a href='post2.php?id=$blog_id'> Read more....</a>" ?></p>
				</div>
				<?php endwhile ?>
			</div>
			<div style="text-indent: 20px">
				<br><br><br>
				<h1>Other users</h1>
				<br>
				<?php

					$query->store_result();

					$query1 = $db->query("SELECT * FROM blogger_info");

					while($row = $query1->fetch_object()){
						$id = $row->blogger_id;
						echo "<li><a href='temp2.php?id=$id' ><div style='text-indent: 20px'>".$row->blogger_username."</div></a><br>";
					}

				?>


			</div>
			</div>
					<div style="color: grey; padding: 20px"><center>Copyright © 2016 Pradeep Ch. All rights reserved.</center></div>
	</body>

</html>