

<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Registration system PHP and MySQL</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Register</h2>
  </div>

  <form method="post" action="register.php">
  	<?php include('errors.php'); ?>
  	<div class="input-group">
  	  <label>Username</label>
  	  <input type="text" name="username" value="<?php echo $username; ?>">
  	</div>

  	<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="<?php echo $email; ?>">
  	</div>

    <div class="input-group">
  	  <label>first name</label>
  	  <input type="text" name="fname">
  	</div>

    <div class="input-group">
      <label>last name</label>
      <input type="text" name="lname">
    </div>

  	<div class="input-group">
  	  <label>gender</label>
  	  <input type="text" name="gender">
  	</div>

    <div class="input-group">
  	  <label>birth date</label>
  	  <input type="date" name="birth_date" >
  	</div>

    <div class="input-group">
      <label>bio</label>
      <input type="text" name="bio" >
    </div>

  	<div class="input-group">
  	  <label>Password</label>
  	  <input type="password" name="password_1">
  	</div>

  	<div class="input-group">
  	  <label>Confirm password</label>
  	  <input type="password" name="password_2">
  	</div>

  	<div class="input-group">
  	  <button type="submit" class="btn" name="reg_user">Register</button>
  	</div>
  	<p>
  		Already a member? <a href="login.php">Sign in</a>
  	</p>
  </form>
</body>
</html>
