<?php include('server.php');
?>

<!DOCTYPE html>
<html>
<head>
  <title>follow</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Follow/Unfollow</h2>
  </div>

  <form method="post" action="follow.php">
    <?php include('errors.php'); ?>

    <div class="input-group">

      <label for="text"><b>Search</b></label>
      <input name = "search_follow"> </input>
      <button type="submit" class = "btn" name = "search_user_follow" >Follow</button>
      <button type="submit" class = "btn" name = "search_user_unfollow" >Unfollow</button>
      <button type="submit" class = "btn" name = "back_from_follow" >Back</button>

      <?php
      if (isset($_POST['search_user_follow'])){
          $db = mysqli_connect('localhost', 'root', '', 'users');
          $search_username_follow = $_POST['search_follow'];
          $sql_search_follow = "SELECT * FROM users WHERE username = '$search_username_follow'";
          $result_search_follow = mysqli_query($db, $sql_search_follow);

          $username = $_SESSION['username'];

          $sql_find = "SELECT * FROM users WHERE username = '$search_username_follow'";
          $result_find = mysqli_query($db, $sql_find);
          if($username != $search_username_follow){
            if (count(mysqli_fetch_assoc($result_find))){
               echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
               $username = $_SESSION['username'];
               $sql_query = "SELECT * FROM following WHERE (username_1 = '$username' AND username_2 = '$search_username_follow')";
               $res = mysqli_query($db, $sql_query);
               if(!count(mysqli_fetch_assoc($res))){
                    $username = $_SESSION['username'];

                    $sql_statement0 = "UPDATE users SET followings = followings + 1 WHERE username = '$username'";
                    $result0 = mysqli_query($db, $sql_statement0);
                    $sql_statement1 = "UPDATE users SET followers = followers + 1 WHERE username = '$search_username_follow'";
                    $result1 = mysqli_query($db, $sql_statement1);

                    $sql_statement_following = "INSERT INTO following (username_1, username_2) VALUES ('$username', '$search_username_follow')";
                    $result_following = mysqli_query($db, $sql_statement_following);

                    echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
                    echo $search_username_follow. " is followed";

                }
                else {
                    echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
                    echo "You already followed " .$search_username_follow;
                }
            }
            else {
              echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
              echo "there is no such user: ";
            }
          }
          else{
            echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
            echo "You try to follow yourself!";
          }
      }

      if (isset($_POST['search_user_unfollow'])) {
          $db = mysqli_connect('localhost', 'root', '', 'users');
          $search_username_follow = $_POST['search_follow'];
          $sql_search_follow = "SELECT * FROM users WHERE username = '$search_username_follow'";
          $result_search_follow = mysqli_query($db, $sql_search_follow);

          echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
          $username = $_SESSION['username'];
          $sql_query = "SELECT * FROM following WHERE (username_1 = '$username' AND username_2 = '$search_username_follow')";
          $res = mysqli_query($db, $sql_query);
          if($username != $search_username_follow){
            if(count(mysqli_fetch_assoc($result_search_follow))){
              if(!count(mysqli_fetch_assoc($res))){
                echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
                echo "You don't follow: " .$search_username_follow;
              }
              else {
                  $username = $_SESSION['username'];
                  //echo $username;
                  //echo $search_username_follow;

                  $sql_statement2 = "UPDATE users SET followings = followings - 1 WHERE username = '$username'";
                  $result2 = mysqli_query($db, $sql_statement2);
                  $sql_statement3 = "UPDATE users SET followers = followers - 1 WHERE username = '$search_username_follow'";
                  $result3 = mysqli_query($db, $sql_statement3);

                  $sql_statement_unfollow = "DELETE FROM following WHERE (username_1 = '$username' AND username_2 = '$search_username_follow')";
                  $result_unfollow = mysqli_query($db, $sql_statement_unfollow);

                  echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
                  echo $search_username_follow. " is unfollowed";
             }
           }
           else {
             echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
             echo "You cannot unfollow " .$search_username_follow. " because there is no such a user.";
           }
         }
         else {
           echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
           echo "You try to unfollow yourself!";
         }
      }
      ?>
  </form>

</body>
</html>

<?php
if (isset($_POST['back_from_follow'])) {
    header('location: index.php');
}
?>
