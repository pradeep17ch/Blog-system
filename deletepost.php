<?php
	
	session_start();
	include('dbconnect.php');

	$id = $_GET['id'];

	$query = $db->query("DELETE FROM blog_master WHERE blog_id = '$id' ");
	$query = $db->query("DELETE FROM blog_detail WHERE blog_id = '$id' ");
	$query = $db->query("DELETE FROM comments WHERE post_id = '$id' ");

	header('Location: temp.php');
	exit();

?>