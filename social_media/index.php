<?php
  session_start();
  $current_user = $_SESSION['username'];
  if (!isset($_SESSION['username'])) {
  	$_SESSION['msg'] = "You must log in first";
  	header('location: login.php');
  }
  if (isset($_GET['logout'])) {
  	session_destroy();
  	unset($_SESSION['username']);
  	header("location: login.php");
  }
?>

<?php
function getTime($t_time){
		$pt = time() - $t_time;
		if ($pt>=86400)
			$p = date("F j, Y",$t_time);
		elseif ($pt>=3600)
			$p = (floor($pt/3600))."h";
		elseif ($pt>=60)
			$p = (floor($pt/60))."m";
		else
			$p = $pt."s";
		return $p;
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>

<div class="header">
	<h2>Profile</h2>
  <?php
  $db = mysqli_connect('localhost', 'root', '', 'users');
  $followers_query = "SELECT * FROM users WHERE username = '$current_user'";
  $followers_res = mysqli_query($db, $followers_query);
  $row = mysqli_fetch_assoc($followers_res);
  echo "followers: ".$row['followers'];

  echo "<br>";

  $db = mysqli_connect('localhost', 'root', '', 'users');
  $following_query = "SELECT * FROM users WHERE username = '$current_user'";
  $following_res = mysqli_query($db, $following_query);
  $rowx = mysqli_fetch_assoc($following_res);
  echo "followings: ".$rowx['followings'];

  ?>
</div>



<div class="content">
  	<!-- notification message -->
  	<?php if (isset($_SESSION['success'])) : ?>
      <div class="error success" >
      	<h3>
          <?php
          	echo $_SESSION['success'];
          	unset($_SESSION['success']);
          ?>
      	</h3>
      </div>
  	<?php endif ?>

    <!-- logged in user information -->
    <?php  if (isset($_SESSION['username'])) : ?>
    	<p>Welcome <strong><?php echo $_SESSION['username']; ?></strong></p>
      <p> <a href="customize.php"> customize </a>	</p>
      <p> <a href="posts.php"> add post </a>	</p>
      <p> <a href="see_posts.php"> timeline </a>	</p>
      <p> <a href="search_user.php"> search user </a>	</p>
      <p> <a href="follow.php"> follow/unfollow </a>	</p>
    	<p> <a href="index.php?logout='1'" style="color: red;">logout</a> </p>
    <?php endif ?>

</div>


<div class = "content">
<p> Posts by: <strong><?php echo $_SESSION['username']; ?></strong></p>
  <?php
  $db = mysqli_connect('localhost', 'root', '', 'users');
  $sql_see = "SELECT * FROM posts WHERE username = '$current_user' ORDER BY timestamp DESC";
  $result_see = mysqli_query($db, $sql_see);
  //$user_see = mysqli_fetch_assoc($result_see);

  while ($user_see = mysqli_fetch_assoc($result_see)) {
    //"<br>";
  //  echo $user_see['body']. " Name: ". $user_see['username'];
    echo "<div style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
    echo "<div style='font-size:15px;float:right;'>".getTime($user_see['timestamp'])."</div>";
    echo "<table>";
    echo "<tr>";
    echo "<td valign=top style='padding-top:4px;'>";
    echo "<img src='./default.jpg' style='width:35px;'alt='display picture'/>";
    echo "</td>";;
    echo "<td style='padding-left:5px;word-wrap: break-word;' valign=top>";
    echo "<a style='font-size:18px;' href='./".$user_see['username']."'>@".$user_see['username']."</a>";
    $new_tweet = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$user_see['body']);
    $new_tweet = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_tweet);
    echo "<div style='font-size:20px; margin-top:-3px;'>".$new_tweet."</div>";
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
  }
   ?>
</div>
</body>
</html>
