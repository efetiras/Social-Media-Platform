<?php include('server.php')
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
  <title>post</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Post Something</h2>
  </div>

  <form method="post" action="posts.php">
    <?php include('errors.php'); ?>

    <div class="container">

      <label for="text"><b>Post</b></label>
      <textarea name = "Post"> </textarea>

      <button type="submit" class = "btn" name = "share" >Send</button>
      <button type="submit" class = "btn" name = "post_back" >Back</button>

  </form>

</body>
</html>

<?php
$db = mysqli_connect('localhost', 'root', '', 'users');
$username_only = $_SESSION['username'];
$sql_see_only = "SELECT * FROM posts WHERE username = '$username_only' ORDER BY timestamp DESC";
$result_see_only = mysqli_query($db, $sql_see_only);

while ($user_see_only = mysqli_fetch_assoc($result_see_only)) {
  echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
  echo "<div style='font-size:15px;float:right;'>".getTime($user_see_only['timestamp'])."</div>";
  echo "<table>";
  echo "<tr>";
  echo "<td valign=top style='padding-top:4px;'>";
  echo "<img src='./default.jpg' style='width:35px;'alt='display picture'/>";
  echo "</td>";;
  echo "<td style='padding-left:5px;word-wrap: break-word;' valign=top>";
  echo "<a style='font-size:18px;' href='./".$user_see_only['username']."'>@".$user_see_only['username']."</a>";
  $new_tweet = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$user_see_only['body']);
  $new_tweet = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_tweet);
  echo "<div style='font-size:20px; margin-top:-3px;'>".$new_tweet."</div>";
  echo "</td>";
  echo "</tr>";
  echo "</table>";
  echo "</div>";
}
?>
