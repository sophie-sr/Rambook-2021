include "index.php";
<br><br><br><br><br><br>
<h1 id="profiles">Search Results for "<?php echo $_GET['search'] ?>"</h1>
<br><br><br><br><br><br>
	
<?php
	$search = "searchimages/";
	
	// Open a directory, and read its contents
	/*if (is_dir($search)){
	  if ($dh = opendir($search)){
		while (($file = readdir($dh)) !== false){
			if ($file != "." && $file != ".."){
				echo "<div class='grid-container'>";
				echo "<img class='thumb' alt='image' src='thumbnails/$file' onclick='toggleLightBox(\"$file\", \"image\")'>";
				echo "<p class='names' id='$file'>$file</p>";
				echo "</div>";
			}
		}
		closedir($dh);
	  }
	}*/
	/*$fileCount = new FilesystemIterator($search, FilesystemIterator::SKIP_DOTS);
	for($i = 0; $i < iterator_count($fileCount); $i++){
		$src = "thumbnails/".scandir($search)[($i+2)];
		echo "<img class='thumb' alt='image' src = \"$src\" onclick='toggleLightBox(\"$src\", \"image\")'>";
	}*/
	$fileCount = new FilesystemIterator($search, FilesystemIterator::SKIP_DOTS);
	for($i = 0; $i < iterator_count($fileCount); $i++){
		echo "<div class='grid-container'>";
		$name = scandir($search)[($i+2)];
		$nameArray3 = explode("_",$name);
		$uid3 = $nameArray3[count($nameArray3)-1];
		$newName3 = substr($name,0,-(strlen($uid3)+1));
		$src = "thumbnails/".scandir($search)[($i+2)];
		echo "<img class='thumb' alt='image' src = \"$src\" onclick='toggleLightBox(\"$src\", \"image\")'>";
		echo "<p class='names' id=$src >$src</p>";
		echo "</div>";
	}
	
?>
<br>
<a class="buttons" href="index.php?action=del">Reset Gallery</a>
<a class="buttons" href="downloadall.php" download>Download All</a>

<span
<div id="lightbox" class="hidden"></div>
      
<div id="positionBigImage">
	
	<div id="boundaryBigImage" class="hidden">
	
		<img id="x" src="images/x.png" alt="close" onclick="toggleLightBox('','')">
		<img id="bigImage" src="images/xxx.png" alt="image">
		<h1 id="name">&nbsp;</h1>
		<div id="info"></div>
		<button class="button" id="friend" type="button"></button>
		<a class="button" id="download" href="" download>Download Photo</a>
	</div>
  
</div>
<!-- Slideshow container -->
<div class="slideshow-container">

  <!-- Full-width images with number and caption text -->
  <div class="mySlides fade">
    <div class="numbertext">1 / 3</div>
    <img id="slideshow" src="" style="width:100%">
    <div class="text">Caption Text</div>
  </div>

  <!-- Next and previous buttons -->
  <a class="prev" onclick="leftArrowSearch()">&#10094;</a>
  <a class="next" onclick="rightArrowSearch()">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
</div>