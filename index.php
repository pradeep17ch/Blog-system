<?php
	
	session_start();
	//echo $_SESSION['blogger_id'];
	if(!isset($_SESSION['blogger_id'])){
		header('Location: home.php');

		exit();
	}

	include('dbconnect.php');

	$blogger_id = $_SESSION['blogger_id'];
	$querytemp = $db->query("SELECT * FROM blogger_info WHERE blogger_id = '$blogger_id' ");
	$act = $querytemp->fetch_object()->blogger_is_active;
	$post_count = $db->query("SELECT * FROM blog_master WHERE blogger_id = '$blogger_id' ");
	$comment_count = $db->query('SELECT * FROM contact');
?>

<!DOCTYPE html>

<html>
	<head>
		<title>Welcome!</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">
	</head>
	
	<body style="padding: 70px">
	<div>
		<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container-fluid" >
			    <div class="navbar-header">
			      <a class="navbar-brand" href="index.php">Blog.com</a>
			    </div>
			    <ul class="nav navbar-nav">
			      <li class="active"><a href="index.php">Home</a></li>
			      	<?php
						if($act == 1){
							echo '<li><a href="newpost.php">Create new post</a></li>';
						}

					?>
					<?php
						if($blogger_id == 1){
							echo '<li><a href="showcontact.php">View suggestions and comments</a></li>';
						}

					?>

					<?php
						if($blogger_id == 1){
							echo '<li><a href="adminpage.php">Edit permissions</a></li>';
						}
					?>

			      <li><a href="temp.php">View posts</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
			      	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			    </ul>
			  </div>
			</nav>
			</div>
		<div>
			<div >
				
			</div>

			<div style="display: flex">

				<div style="width: 60%">
					
					<?php
		
						$query = $db->prepare("SELECT blog_id, blog_title, LEFT(blog_desc,100) AS blog_desc, cat_name, blogger_username FROM blog_master INNER JOIN categories ON blog_category = category_id AND blogger_id = '$blogger_id' INNER JOIN blogger_info ON blogger_info.blogger_id = blog_master.blogger_id ORDER BY blog_id DESC LIMIT 0,15");
						$query->execute();
						$query->bind_result($blog_id, $title, $body, $category, $name);

						while ($query->fetch()):
						$lastspace = strrpos($body, ' ');
					?>

					<div style="text-align: left; text-indent: 30px">
						<h2><?php echo '<u>'.$title.'</u>' ?></h2>
						<h4>By: <?php echo $name ?></h4>
						<h6><?php echo $category ?></h6>
						<p><?php echo substr($body, 0, $lastspace). "<a href='post.php?id=$blog_id'> Read more....</a>" ?></p><hr style="border: solid 1px">
					</div>
					<?php 
					endwhile ?>

				</div>

				<div style="width: 10%">
				</div>

				<div style="text-indent: 30px; width: 30%">
					<div>
					<h1>Other users</h1>
					<br>
						<?php
							$query->store_result();

							$query1 = $db->query("SELECT * FROM blogger_info WHERE blogger_id!= '$blogger_id' ");

							while($row = $query1->fetch_object()){
								$id = $row->blogger_id;
								
								if($_SESSION['blogger_id']==1)
									echo "<li><a href='temp2.php?id=$id' ><div style='text-indent: 20px'>".$row->blogger_username."</div></a><br>";

								else
									echo "<li><a href='temp2.php?id=$id' ><div style='text-indent: 20px'>".$row->blogger_username."</div></a><br>";
							}

						?>
					</div>
						<br>
					<div>
						<h1>All Recent Blogs</h1><br>
						<?php

							$query = $db->prepare("SELECT blog_id, blog_title, LEFT(blog_desc,100) AS blog_desc, cat_name, blogger_username FROM blog_master INNER JOIN categories ON blog_category = category_id INNER JOIN blogger_info ON blogger_info.blogger_id = blog_master.blogger_id ORDER BY blog_id DESC LIMIT 0,10");
							$query->execute();
							$query->bind_result($blog_id, $title, $body, $category, $name);


								while ($query->fetch()):
								$lastspace = strrpos($body, ' ');
							?>

							<div style="text-align: left; text-indent: 30px">
								<h2><?php echo '<u>'.$title.'</u>' ?></h2>
								<h4>By: <?php echo $name ?></h4>
								<h6><?php echo $category ?></h6>
								<p><?php echo substr($body, 0, $lastspace). "<a href='post2.php?id=$blog_id'> Read more....</a>" ?></p><hr style="border: solid 1px">
							</div>
							<?php endwhile ?>

						
					</div>

				</div>


			</div>

				<table>
					<tr>
						<td>Total Blog posts: </td>
						<td><?php echo $post_count->num_rows; ?></td>
					</tr>
				</table>

		</div>
	</body>
</html>