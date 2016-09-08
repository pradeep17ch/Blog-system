<?php
	
	session_start();

	include('dbconnect.php');

	$blogger_id = $_GET['id'];

	$record_count = $db->query("SELECT * FROM blog_master WHERE blogger_id = '$blogger_id'");

	$per_page = 3;

	$pages = ceil($record_count->num_rows / $per_page);

	if(isset($_GET['p']) && is_numeric($_GET['p'])){
		$page = $_GET['p'];
	}
	else{
		$page = 1;
	}

	if($page <= 0)
		$start = 0;
	else
		$start = $page * $per_page - $per_page;

	$prev = $page - 1;
	$next = $page + 1;

	$query = $db->prepare("SELECT blog_id, blog_title, LEFT(blog_desc,100) AS blog_desc, cat_name FROM blog_master INNER JOIN categories WHERE blogger_id = '$blogger_id' AND blog_category = category_id ORDER BY blog_id DESC LIMIT $start, $per_page");
	$query->execute();
	$query->bind_result($blog_id, $title, $body, $category);

?>

<!DOCTYPE html>
<html>
<head>
	<title>View blogs</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<style>
		#container{
			margin: auto;
			width: 800px;
		}

	</style>
</head>
<body style="padding: 70px">

	<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container-fluid" >
			    <div class="navbar-header">
			      <a class="navbar-brand" href="index.php">Blog.com</a>
			    </div>
			    <ul class="nav navbar-nav">
			      <li><a href="index.php">Home</a></li>
			      <li class="active"><a href="temp2.php?id=<?php echo $blogger_id ?>">View posts</a></li>
			    </ul>
			    <?php 

				    if(isset($_SESSION['blogger_id']))
				    {
				    	echo '
					    <ul class="nav navbar-nav navbar-right">
					    	<li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
					      	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
					    </ul>
					    ';
				    }	

				    else
				    {
				    	echo '
						<ul class="nav navbar-nav navbar-right">
					      <li class="active"><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
					      <li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
					      <li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
					    </ul>

				    	';
				    }
			    ?>
			  </div>
	</nav>

	<div id="container">
		<?php
			while ($query->fetch()):
			$lastspace = strrpos($body, ' ');
		?>

		<article>
			<h2><u><?php echo $title ?></u></h2>
			<h5><?php echo $category ?></h5>
			<p><?php 

				if(isset($_SESSION['blogger_id']))
				{	
					if($_SESSION['blogger_id'] == 1)
						echo substr($body, 0, $lastspace). "<a href='post.php?id=$blog_id'> Read more....</a>" ;

					else
						echo substr($body, 0, $lastspace). "<a href='post2.php?id=$blog_id'> Read more....</a>" ;
				}

				else
					echo substr($body, 0, $lastspace). "<a href='post2.php?id=$blog_id'> Read more....</a>" ;

			?></p>
		</article><br>
		<?php endwhile ?>
	</div>
	
	<br>

	<div style="display: flex;">
		<div style="width: 50%; text-align: left">
		<?php
			if($prev > 0)
				echo "<a href='temp2.php?id=$blogger_id&p=$prev' style='font-size: 20px'>..Prev</a>";
			
		?>
		</div>
		<div style="width: 50%; text-align: right">
		<?php
		 	if($page < $pages){
				echo "<a href='temp2.php?id=$blogger_id&p=$next' style='font-size: 20px'>Next..</a>";
			}

		?>
		</div>
	</div>

</body>
</html>