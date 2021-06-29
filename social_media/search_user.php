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
  	<h2>Search Useres' Posts</h2>
  </div>

  <form method="post" action="search_user.php">
    <?php include('errors.php'); ?>

    <div class="input-group">

      <label for="text"><b>Search</b></label>
      <input name = "search"> </input>

      <button type="submit" class = "btn" name = "search_user" >Search</button>
      <button type="submit" class = "btn" name = "back_from_search" >Back</button>
  </form>

</body>
</html>

<?php


if (isset($_POST['back_from_search'])) {
    header('location: index.php');
}

if (isset($_POST['search_user'])) {
  $db = mysqli_connect('localhost', 'root', '', 'users');
  $search_username = $_POST['search'];
  $sql_search = "SELECT * FROM posts WHERE username = '$search_username' ORDER BY timestamp DESC";
  $result_search = mysqli_query($db, $sql_search);

  $sql_find = "SELECT * FROM users WHERE username = '$search_username'";
  $result_find = mysqli_query($db, $sql_find);
  if (!count(mysqli_fetch_assoc($result_find))) {
    echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
    echo "there is no such user: ".$search_username;
  }
  else if ( isset($_POST['search_user']) && !count(mysqli_fetch_assoc($result_search))) {
    echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
    echo $search_username. " haven't post anything yet";
  }
  else{
    while ($search_username = mysqli_fetch_assoc($result_search)) {
      echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
      echo "<div style='font-size:15px;float:right;'>".getTime($search_username['timestamp'])."</div>";
      echo "<table>";
      echo "<tr>";
      echo "<td valign=top style='padding-top:4px;'>";
      echo "<img src='./default.jpg' style='width:35px;'alt='display picture'/>";
      echo "</td>";;
      echo "<td style='padding-left:5px;word-wrap: break-word;' valign=top>";
      echo "<a style='font-size:18px;' href='./".$search_username['username']."'>@".$search_username['username']."</a>";
      $new_tweet = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$search_username['body']);
      $new_tweet = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_tweet);
      echo "<div style='font-size:20px; margin-top:-3px;'>".$new_tweet."</div>";
      echo "</td>";
      echo "</tr>";
      echo "</table>";
      echo "</div>";
    }
  }
}
?>
