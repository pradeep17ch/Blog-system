<?php
	
	include('dbconnect.php');

	$query = $db->query("SELECT * FROM blogger_info");


	if(isset($_POST['submit'])){

		$id = $_POST['check'];

		foreach ($id as $sett) {
			$query1 = $db->query("SELECT * FROM blogger_info WHERE blogger_id = '$sett' ");
			$valact = $query1->fetch_object()->blogger_is_active; 

			if($valact != 0) $valact = 0;
			else $valact = 1;

			$db->query("UPDATE blogger_info SET blogger_is_active='$valact' WHERE blogger_id = '$sett' ");
		}

		header("Location: adminpage.php");
		//unset($_POST['submit']);
	}

?>

<!DOCTYPE html>

<html>

	<head>
		<title>Set permissions</title>
		<link rel="stylesheet" type="text/css" href="bootstrap.css">

		<style type="text/css">
			td{
				padding: 10px;
			}
			th{
				padding: 10px;
				border: solid black 3px;
				text-align: center;
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
				  <li><a href="newpost.php">Create new post</a></li>
				  <li><a href="showcontact.php">View suggestions and comments</a></li>
				  <li class="active"><a href="adminpage.php">Edit permissions</a></li>
				  <li><a href="temp.php">View and edit posts</a></li>
				</ul>
				<ul class="nav navbar-nav navbar-right">
					<li class="active"><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
				</ul>
				</div>
			</nav>


		<div style="display: flex;">
			<div style="width: 25%">
				
			</div>

			<div style="width: 50%">
			<center>
				<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
					<table style="border: solid black 3px; text-align: center; font-size: 20px; margin: 50px" border="1">
						<th>Username</th>
						<th>Permission</th>
						<th>Set or not</th>
						<?php
						while($row = $query->fetch_object()):
						?>
										<tr>
											<td><?php echo $row->blogger_username ?></td>
											<td><input type="checkbox" name="check[]" id="checker" value="<?php echo $row->blogger_id ?>"></td>
											<td>
												<?php 
													if($row->blogger_is_active) 
														echo "Yes";
													else echo "No";

												?>
												
											</td>
										</tr>

						<?php endwhile ?>

					</table>
						<br>
					<input type="submit" style="width: 150px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;" name="submit"></input><br><br>

				</form>
			</center>
			</div>


		</div>
		
		
	</body>

</html>