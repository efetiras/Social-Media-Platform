<?php include('server.php');
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
  <title>see</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Timeline</h2>
  </div>

  <form method="post" action="index.php">
    <?php include('errors.php'); ?>

    <div class="container">
      <button type="submit" class = "btn" >back</button>
  </form>

</body>
</html>


<?php

$user = $_SESSION['username'];
$db = mysqli_connect('localhost', 'root', '', 'users');
//$sql_see = "SELECT * FROM posts ORDER BY timestamp DESC";

$sqlX = "SELECT username_2 FROM following WHERE username_1 = '$user'";
$resultX = mysqli_query($db, $sqlX);
if (!count(mysqli_fetch_assoc($resultX))) {
  echo "<div style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
	echo "You don't follow any user";
}
else {
	$sql_see = "SELECT *
							FROM posts
							INNER JOIN following ON posts.username = following.username_2 OR posts.username = '$user' /*eger OR olmazsa timlineda sadece takip ettiklerinin psotu gzoukur*/
							ORDER BY timestamp DESC";

	$result_see = mysqli_query($db, $sql_see);

	while ($user_see = mysqli_fetch_assoc($result_see)) {

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
}
?>
