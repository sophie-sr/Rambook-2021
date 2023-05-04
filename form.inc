<br><br><br><br><br><br>
<h1 id="profiles">SIGN UP</h1>
<br><br><br><br><br><br>

<form method="post" id="form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" enctype="multipart/form-data">

      <label for="name" class="title">Name:</label><br>
      <input type="text" name="name" value="<?php echo (empty($name)) ? "Enter name here..." : $name;?>" onclick="this.select()"><br>
	  <span class="error"><?php echo $nameErr;?></span>

	  <br><br>
    
      <label for="profilepic" class="title">Profile Picture:</label><br>
      <label id="profileButton">Upload Photo<input type="file" id="profilepic" name="profilepic" accept="image/png, image/jpg, image/jpeg"></label><br>
	  <span class="error"><?php echo $imageErr;?></span>
	  <span class="error"><?php echo $imageTypeErr;?></span>
	  <span class="error"><?php echo $imageSizeErr;?></span><br>
	  
      <label id="agree">
	  <input type="checkbox" name="agree"
	  <?php echo (empty($agree)) ? '':'checked' ?> /> I give RamBook non-exclusive, transferable, sub-licensable, royalty-free, worldwide license to use this photo.</label>
	  <span class='error'><?php echo $agreeErr;?></span><br><br>

      <label class="title">Connection to Mount Doug:</label><br>
      <input type="radio" id="currentstudent" name="connection"
	  <?php if (isset($connection) && $connection=="currentstudent") echo "checked";?>
	  value="currentstudent" onclick="showGrade()" checked>Current Student<br>
      <input type="radio" id="alumni" name="connection"
	  <?php if (isset($connection) && $connection=="alumni") echo "checked";?>
	  value="alumni" onclick="showGrade()">Alumni<br>
      <input type="radio" id="staff" name="connection"
	  <?php if (isset($connection) && $connection=="staff") echo "checked";?>
	  value="staff" onclick="showGrade()">Staff<br>
	  
	  <div id="grade">
	  <label for="grades">Grade:</label><br>
        <select id="grades" name="grades">
          <option value="9"
		  <?php if ($grades=="9" || !isset($_POST["grades"])) echo "selected";?>
		  >9</option>
          <option value="10"
		  <?php if ($grades=="10") echo "selected";?>
		  >10</option>
          <option value="11"
		  <?php if ($grades=="11") echo "selected";?>
		  >11</option>
          <option value="12"
		  <?php if ($grades=="12") echo "selected";?>
		  >12</option>
        </select>
      </div><br>
      
      <label for="bio" class="title">Say Something About Yourself:</label><br>
      <textarea id="bio" name="bio" onclick="this.select()" rows="4" cols="50"><?php echo (empty($bio)) ? "Enter bio here..." : $bio;?></textarea><br>
	  <span class="error"><?php echo $bioErr;?></span><br><br>

      <input type="submit"><br>
      
    </form>