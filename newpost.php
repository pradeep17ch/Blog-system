<?php 
	
	session_start();

	include('dbconnect.php');

	if(!isset($_SESSION['blogger_id'])){
		header('Location: login.php');
		exit();
	}

	if(isset($_POST['submit2'])){
		
		$title = $_POST['title'];
			$title = $db->real_escape_string($title);
		$body = $_POST['body'];
			$body = $db->real_escape_string($body);
			$body = htmlentities($body);
		$category = $_POST['category'];
		$blogger_id = $_SESSION['blogger_id'];
		$date = date('Y-m-d');
		$upload_image = $_FILES["imageupload"]["name"];

		$folder = "myimages";

		$authorquery = $db->query("SELECT blogger_username FROM blogger_info WHERE blogger_id = '$blogger_id' ");

		$author = $authorquery->fetch_object()->blogger_username;

		if($title && $body && $category && $upload_image){
			$query = $db->query("INSERT INTO blog_master (blogger_id, blog_title, blog_desc, blog_category, blog_author, creation_date, updated_date) VALUES ('$blogger_id','$title', '$body', '$category', '$author', '$date', '$date')" );


			if($query){

				$query1 = $db->query("SELECT blog_id FROM blog_master WHERE blogger_id = '$blogger_id' ORDER BY blog_id DESC");
				$row = $query1->fetch_object();
				$temp = $row->blog_id;
				
				move_uploaded_file($_FILES["imageupload"]["tmp_name"], "$folder".$_FILES["imageupload"]["name"]);
				
				$queryimg = $db->query("INSERT INTO blog_detail (blog_id, image_name, blog_detail_image) VALUES ('$temp','$folder', '$upload_image')");

			}

			else{
				echo 'Problem uploading image.';
			}


			if($query1){
				echo '<script> alert("Post added."); </script>';
			}
			else{
				echo "error";
			}

		}
		else{
			echo 'Missing information';
		}

	}

?>	

<!DOCTYPE html>
<html>
<head>
	<title>Write new blog!</title>
	<link rel="stylesheet" type="text/css" href="bootstrap.css">
	<style type="text/css">
		a:link{
		color: blue;
		text-decoration: none;
		}
		a:visited{
			color: blue;
		}
		a:hover{
			text-decoration: underline;
		}
	</style>
</head>
<body style="padding-top: 80px">

			<nav class="navbar navbar-inverse navbar-fixed-top">
			  <div class="container-fluid" >
			    <div class="navbar-header">
			      <a class="navbar-brand" href="index.php">Blog.com</a>
			    </div>
			    <ul class="nav navbar-nav">
			      <li class="active"><a href="index.php">Home</a></li>
			    </ul>
			    <ul class="nav navbar-nav navbar-right">
			    	<li><a href="contact.php"><span class="glyphicon glyphicon-phone"></span> Contact</a></li>
			      	<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
			    </ul>
			  </div>
			</nav>


	<div id="wrapper">
		<div id="content1" style="text-align: center; border: solid black 2px; padding: 20px">
		
			<form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data">
				<input type="text" placeholder="TITLE" style="height: 50px; width: 400px; font-size: 20px" name="title">
				<br><br>
					<textarea name="body" placeholder="Here goes my blog.." cols=70 rows=15></textarea>
				<br><br>
					<select name="category">
						<?php
							$query = $db->query("SELECT * FROM categories");
							while($row = $query->fetch_object()){
								echo "<option value='".$row->category_id."'>".$row->cat_name."</option>";
							}
						 ?>
					</select>
					<br>
					<input type="file" name="imageupload" id="image"><input type="submit" style="width: 200px; height: 35px; background-color: #3399ff; color: white; border: solid #0073e6 1px; border-radius: 4px; font-size: 14px;" name="submit2" value="Upload">
					
			</form>

		</div>
		

	</div>

</body>
</html>