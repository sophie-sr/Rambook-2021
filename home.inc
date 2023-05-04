<br><br><br><br><br><br>
<h1 id="profiles">PROFILES</h1>
<br><br><br><br><br><br>
	
<?php
	$thumbnails = "thumbnails/";
	
	echo "<div id='grid-container'>";

	$fileCount = new FilesystemIterator($thumbnails, FilesystemIterator::SKIP_DOTS);
	for($i = 0; $i < iterator_count($fileCount); $i++){
		echo "<div class='container'>";
		$name = scandir($thumbnails)[($i+2)];
		$nameArray2 = explode("_",$name);
		$uid2 = $nameArray2[count($nameArray2)-1];
		$newName2 = substr($name,0,-(strlen($uid2)+1));
		$src = $thumbnails.scandir($thumbnails)[($i+2)];
		echo "<img class='thumb' alt='image' src = \"$src\" onclick='toggleLightBox(\"$src\", \"image\")'>";
		echo "<div class='names' id=$src>$src</div>";
		echo "</div>";
	}
	
	echo "</div>";
	
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
		<h1 id="name"></h1>
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
  <a class="prev" onclick="leftArrow()">&#10094;</a>
  <a class="next" onclick="rightArrow()">&#10095;</a>
</div>
<br>

<!-- The dots/circles -->
<div style="text-align:center">
  <span class="dot" onclick="currentSlide(1)"></span>
</div>