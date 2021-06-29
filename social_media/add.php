<?php
include_once('posts.php');

session_start();
$db = mysqli_connect('localhost', 'root', '', 'users');
include_once("function.php");

$userid = $_SESSION['userid'];
$body = substr($_POST['body'],0,140);

add_post($userid,$body);
$_SESSION['message'] = "Your post has been added!";

header("Location:index.php");
?>
