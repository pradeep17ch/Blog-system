<?php
	session_start();
	if(!isset($_GET['id'])){
		header('Location: temp.php');
		exit();
	}
	else
	$id = $_GET['id'];

	include('dbconnect.php');

	if(!is_numeric($id))
		header('Location: temp.php');

	$query = $db->query("SELECT * FROM blog_detail WHERE blog_id = '$id' ");

	if(!$query){
		echo '<script> alert("Error showing"); </script>';
	}

	while($row = $query->fetch_assoc()){

		$image_name = $row["image_name"];
		$image_path = $row["blog_detail_image"];
	}

	$query->close();


	$query = $db->prepare("SELECT blog_title, blog_desc, cat_name, creation_date, updated_date FROM blog_master INNER JOIN categories WHERE blog_id = '$id' AND blog_category = category_id");

	$query->execute();
	$query->bind_result($title, $body, $category, $cdate, $udate);
	

	if(isset($_POST['submit'])){
		
		$email = $_POST['email'];
		$name = $_POST['name'];
		$comment = $_POST['comment'];

		if($email && $name && $comment){
			$query->store_result();

			$email = $db->real_escape_string($email);
			$name = $db->real_escape_string($name);
			$id = $db->real_escape_string($id);
			$comment = $db->real_escape_string($comment);
			
			if($addcomment = $db->prepare("INSERT INTO comments (name, post_id, email_id, comment_desc) VALUES(?,?,?,?)")){
				$addcomment->bind_param('ssss', $name, $id, $email, $comment);
				$addcomment->execute();
				echo '<script>alert("Comment added.");</script>';
				$addcomment->close();
			}
			
				else
				echo '<script>alert("Values not inserted.");</script>';
			
		}
		else{
			echo '<script>alert("You havent entered some fields.")</script>';
		}

	}

?>

<!DOCTYPE html>
<html>
<head>
	<title>View post</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<style type="text/css">
		#container{
			width: 800px;
			padding: 5px;
			margin: auto;
		}
		label{
			display: block;
		}
	</style>
</head>
<body style="padding-top: 60px">

		<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container-fluid" >
			    <div class="navbar-header">
			      <a class="navbar-brand" href="index.php">Blog.com</a>
			    </div>
			    <ul class="nav navbar-nav">
			      <li><a href="index.php">Home</a></li>
			      <li class="active"><a href="temp.php">View and edit posts</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
			      	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			    </ul>
			  </div>
	</nav>


	<div id="container">
		<div id="post">
			
			<div>
				<?php echo "<img src=../".$image_name."/".$image_path." height=250 width=100%><br>"; ?>
			</div>
			
			<?php
				while ($query->fetch()):
			?>

			<article>
				<h2><?php echo $title ?></h2>
				<h5><u>Category: <?php echo $category ?></u></h5><br>
				<div style="display: flex; font-size: 12px">
					<div style="text-align: left; width: 50%" >Created on: <span class="glyphicon glyphicon-time"></span> <?php echo $cdate ?></div>
					<div style="text-align: right; width: 50%">Last updated: <span class="glyphicon glyphicon-time"></span> <?php echo $udate ?></div>
				</div><br>
				<p><?php echo $body ?></p>

			</article>
			<?php endwhile ?>
			<?php
			$query->store_result();
			$bid = $_SESSION['blogger_id'];
			$permq = $db->query("SELECT blogger_is_active FROM blogger_info WHERE blogger_id = '$bid' ");
			if($permq->fetch_object()->blogger_is_active == 1):
			?>

			<div style="display: flex">
				<div style="width: 50%"><form action="editpost.php?id=<?php echo $id ?>" method="post"><button type="submit" name="update" style="width: 100px; height: 35px; background-color: green; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Edit post</button></form></div>
				
				<div style="width: 50%; text-align: right">
		
					<form action="deletepost.php?id=<?php echo $id ?>" method="post">
						<button type="submit" name="delete" style="width: 100px; height: 35px; background-color: red; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Delete post</button>
					</form>
				
				</div>
			</div>
			<?php endif ?>
		</div>


		<hr style="border: solid black 1px">

		<div id="comments">
			<h3><u>Comments:</u></h3>
			<br>
			<?php
				$query = $db->query("SELECT * FROM comments WHERE post_id = '$id' ORDER BY comment_id DESC");
				while($row = $query->fetch_object()):
			?>

				<div>
					<h4><?php echo $row->name ?></h4>
					<blockquote><?php echo $row->comment_desc ?></blockquote>
				</div>
				<hr>
			<?php endwhile ?>

		</div>


		<hr style="border: solid black 1px">

		<div id="commentinputs" style="background-color: #d3d3d3">
			<form action="<?php echo $_SERVER['PHP_SELF']."?id=$id" ?>" method="post">
				<div style="padding: 10px">
					<input type="text" placeholder="Name" name="name" style="height: 40px; width: 200px; font-size: 15px">
				</div>

				<div style="padding: 10px">
					<input type="text" placeholder="Email address" name="email" style="height: 30px; width: 300px; font-size: 15px">
				</div>
				
				<div style="padding: 10px">
					<textarea name="comment" placeholder="The comment goes.." cols=50 rows=10></textarea>
				</div>
				<div style="padding: 10px">
				<button type="submit" name="submit" value="submit" style="width: 100px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;">Submit</button>
				</div>

			</form>

		</div>
		
	</div>
</body>
</html>