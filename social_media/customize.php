<?php include('server.php') ?>
<!DOCTYPE html>
<html>
<head>
  <title>Editing Profile</title>
  <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
  <div class="header">
  	<h2>Edit Profile</h2>
  </div>

  <form method="post" action="customize.php">
  	<?php include('errors.php'); ?>
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


    <form method="POST" action="customize.php" enctype="multipart/form-data">
    	<input type="hidden" name="size" value="1000000000">
    	<div>
    	 <!-- <input type="file" name="image" id = "image"> -->
        <input type="file" name="image" id="image" class="form-control">
    	</div>
    	<div>

        <!--
      <h2>Upload your Photos:</h2>
      <hr />
      <form action="customize.php" method="POST" enctype="multipart/form-data">
      <input type="file" name="profilepic" />
      <input type="submit" name="uploadpic" value="Upload Image"> bu satir da kapaliydi-->



  	<div class="input-group">
  	  <button type="submit" class="btn" name="submit_changes">Submit</button>
      <button type="submit" class="btn" name="cancel">Cancel</button>
      </div>
  <!--	</div>
    <div class="input-group">
  	  <button type="submit" class="btn" name="cancel">Cancel</button>
  	</div> -->

  </form>

</body>
</html>
