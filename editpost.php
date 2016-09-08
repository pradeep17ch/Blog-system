<?php
	
	session_start();

	include('dbconnect.php');

	$id = $_GET['id'];
	//echo $id;
	$query1 = $db->query("SELECT * FROM blog_master WHERE blog_id = '$id' ");
	$query2 = $db->query("SELECT * FROM blog_detail WHERE blog_id = '$id' ");
	$row = $query1->fetch_object();
	$row1 = $query2->fetch_object();

	if(isset($_POST['submit'])){
		$title = $_POST['title'];
			$title = $db->real_escape_string($title);
		$body = $_POST['body'];
			$body = $db->real_escape_string($body);
			$body = htmlentities($body);
		$category = $_POST['category'];
		$blogger_id = $_SESSION['blogger_id'];
		$date = date('Y-m-d');
	
		$upload_image = $_FILES["imageupload1"]["name"];

		$folder = "myimages";


		$query = $db->query("UPDATE blog_master SET blog_title='$title', blog_desc='$body', blog_category='$category', updated_date='$date' WHERE blog_id='$id' ");

		move_uploaded_file($_FILES["imageupload1"]["tmp_name"], "$folder".$_FILES["imageupload1"]["name"]);
		
		$queryimg = $db->query("UPDATE blog_detail SET image_name='$folder', blog_detail_image='$upload_image' WHERE blog_id='$id' ");

		if($query && $queryimg){
			header("Location: editpost.php?id=$id");

			echo '<script>alert("Post edited");</script>';
		}
		else{
			echo '<script>alert("Couldnt edit post.");</script>';
		}
	}
	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit post</title>
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
			      <li><a href="temp.php">View and edit posts</a></li>
			      <li class="active"><a href="editpost.php?id=<?php echo $id ?> ">Edit post</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
			      	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			    </ul>
			  </div>
	</nav>

<div>
		<div id="content1" style="text-align: center; border: solid black 2px; padding: 20px;">
			<form action="<?php echo $_SERVER['PHP_SELF']."?id=$id" ?>" method="post" enctype="multipart/form-data">
				<div style="padding: 20px">
					<input type="text" name="title" value="<?php echo $row->blog_title ?>" style="height: 40px; width: 300px; font-size: 20px">
				</div>

				<div style="padding: 20px">
					<textarea name="body" cols=75 rows=13 value="" 	><?php echo $row->blog_desc ?></textarea>
				</div>

				<div style="padding: 20px">
					<select name="category">
						<?php
							$query = $db->query("SELECT * FROM categories");
							while($row = $query->fetch_object()){
								echo "<option value='".$row->category_id."'>".$row->cat_name."</option>";
							}
						 ?>
					</select>
				</div>	
					<input type="file" name="imageupload1" id="image">
					<input type="submit" name="submit" value="Submit" style="width: 150px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;" value="submit">

			</form>

		</div>

</div>

</body>
</html>