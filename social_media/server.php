
<?php
session_start();

// initializing variables
$username = "";
$email    = "";
$errors = array();

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'users');

// REGISTER USER
if (isset($_POST['reg_user'])) {
  // receive all input values from the form
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  $fname = mysqli_real_escape_string($db, $_POST['fname']);
  $lname = mysqli_real_escape_string($db, $_POST['lname']);
  $gender = mysqli_real_escape_string($db, $_POST['gender']);
  $birth_date = mysqli_real_escape_string($db, $_POST['birth_date']);
  $bio = mysqli_real_escape_string($db, $_POST['bio']);

  // form validation: ensure that the form is correctly filled ...
  // by adding (array_push()) corresponding error unto $errors array
  if (empty($username)) { array_push($errors, "Username is required"); }
  if (empty($email)) { array_push($errors, "Email is required"); }
  if (empty($password_1)) { array_push($errors, "Password is required"); }
  if (empty($fname)) { array_push($errors, "Name is required"); }
  if (empty($lname)) { array_push($errors, "Last name is required"); }
  if (empty($gender)) { array_push($errors, "Gender is required"); }
  if (empty($birth_date)) { array_push($errors, "Birth date is required"); }
  if (empty($bio)) { array_push($errors, "bio is required"); }
  if ($password_1 != $password_2) {
	array_push($errors, "The two passwords do not match");
  }

  // first check the database to make sure
  // a user does not already exist with the same username and/or email
  $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);

  if ($user) { // if user exists
    if ($user['username'] === $username) {
      array_push($errors, "Username already exists");
    }

    if ($user['email'] === $email) {
      array_push($errors, "email already exists");
    }
  }

  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) {
  	$password = md5($password_1);//encrypt the password before saving in the database

  	$query = "INSERT INTO users (username, email, password, fname, lname, gender, birth_date, bio)
  			  VALUES('$username', '$email', '$password', '$fname', '$lname', '$gender', '$birth_date', '$bio')";
  	mysqli_query($db, $query);
  	$_SESSION['username'] = $username;
  	$_SESSION['success'] = "You are now logged in";
  	header('location: index.php');
  }
}



// ...

// LOGIN USER
if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  if (empty($username)) {
  	array_push($errors, "Username is required");
  }
  if (empty($password)) {
  	array_push($errors, "Password is required");
  }

  if (count($errors) == 0) {
  	$password = md5($password);
  	$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
  	$results = mysqli_query($db, $query);
  	if (mysqli_num_rows($results) == 1) {
  	  $_SESSION['username'] = $username;
  	  $_SESSION['success'] = "You are now logged in";
  	  header('location: index.php');
  	}else {
  		array_push($errors, "Wrong username/password combination");
  	}
  }
}

if (isset($_SESSION['username'])){
  if (isset($_POST['submit_changes'])) {
    $username = $_SESSION['username'];


    // Get image name
    $imagename = time(). '-' . $_FILES["image"]["name"];
    $target_dir = "images/";
    // image file directory
    $target =   $target_dir . basename($imagename);


    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target)) {
      //$errors = "Image uploaded successfully";

    }
    else{
      echo "Failed to upload image";
    }

    $sql = "INSERT INTO images (username, image) VALUES ('$username', '$target')";
    // execute query
    mysqli_query($db, $sql);
    $result = mysqli_query($db, "SELECT * FROM images");

    $fname = mysqli_real_escape_string($db, $_POST['fname']);
    $lname = mysqli_real_escape_string($db, $_POST['lname']);
    $gender = mysqli_real_escape_string($db, $_POST['gender']);
    $birth_date = mysqli_real_escape_string($db, $_POST['birth_date']);
    $bio = mysqli_real_escape_string($db, $_POST['bio']);


    $sql_statement = "UPDATE users SET fname = '$fname', lname = '$lname', gender = '$gender',
                        birth_date = '$birth_date', bio = '$bio' WHERE username = '$username'";
    mysqli_query($db, $sql_statement);
    header('location: index.php');
  }
  else if (isset($_POST['cancel'])) {

    header('location: index.php');
  }
}

// post
if (isset($_SESSION['username'])) {
  if (isset($_POST['share'])) {

    $username = $_SESSION['username'];
    $body = $_POST['Post'];
    $timestamp = time();

    $sql_statement1 = "INSERT INTO posts(username, body, timestamp) VALUES ('$username', '$body', '$timestamp') ";
    $result = mysqli_query($db, $sql_statement1);

    header('location: posts.php');
  }
  else if (isset($_POST['post_back'])) {
    header('location: index.php');
  }
}


?>
