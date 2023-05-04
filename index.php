<?php

include "functions.inc";
include  "createthumbnail.php";

//declare and initialize all variables
$x = "";
$search = "";
$formSubmitted = false;
$isDataValid = true;
$searchSubmitted = false;

$name = "";
$nameErr = "";
$agree = "";
$agreeErr = "";
$bio = "";
$bioErr = "";
$connection = "";
$grades = "";
$friend = "Friend?";

$action = "";

$imageErr = "";
$imageTypeErr = "";
$imageSizeErr = "";
$target_dir = "profileimages/";
$thumbnail_dir = "thumbnails/";
$friend_dir = "friendimage/";
$search_dir = "searchimages/";

$file = "userprofiles.json";

//UID variable declaration
$uidFile = "identifier.txt";
$uid = file_get_contents($uidFile);
$_POST["uid"] = $uid;

//empty JSON file and remove profileimages
if (isset($_GET["action"]) && $_GET["action"] == "del") {
	//delete JSON file
	if (file_exists($file)){
		unlink("userprofiles.json");
	}//if
	
	//delete uploaded images
	if ($dh = opendir($target_dir)){
		while (($file = readdir($dh)) !== false){
			if ($file != "." && $file != ".."){
				unlink($target_dir . $file);
				$uid = file_put_contents("identifier.txt", 1);
			}//if
		}//while
		closedir($dh);
	}//if
	
	//delete uploaded images
	if ($dh = opendir($thumbnail_dir)){
		while (($file = readdir($dh)) !== false){
			if ($file != "." && $file != ".."){
				unlink($thumbnail_dir . $file);
			}//if
		}//while
		closedir($dh);
	}//if
}//if

//determine if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$formSubmitted = true;
	
	if(empty($_FILES)){
	 	//if image is larger than 10mb
		$imageSizeErr = "*File is too large, maximum file size is 4MB";
		$isDataValid = false;
	 } else {
		//validate submitted data for form, error checking
		//name
		if (empty($_POST["name"]) || ($_POST["name"] == "Enter name here...")) {
			$nameErr = "*Name is required";
			$isDataValid = false;
		}//if
		else if (preg_match('/[^A-Za-z0-9]/', $_POST["name"])) {
			$nameErr = "*Please do not include special characters in name. ";
			$isDataValid = false;
		}else {
			$name = test_input($_POST["name"]);
			$_POST["name"] = $name;
		}//else
		
		//bio
		if (empty($_POST["bio"]) || ($_POST["bio"] == "Enter bio here...")) {
			$bioErr = "*Bio is required";
			$isDataValid = false;
		} else {
			$bio = test_input($_POST["bio"]);
			$_POST["bio"] = $bio;
		}//else
		
		//agree to terms checkbox
		if(empty($_POST["agree"])){
			$agreeErr = "*Please check the box";
			$isDataValid = false;
		} else {
			$agree = $_POST['agree'];
		}//else
		
		//grades
		if(($_POST["connection"]) == "currentstudent"){
			$grades = $_POST["grades"];
		} else if(($_POST["connection"]) == "alumni"){
			$_POST["grades"] = "";
			$grades = $_POST["grades"];
		} else if(($_POST["connection"]) == "staff"){
			$_POST["grades"] = "";
			$grades = $_POST["grades"];
		}//else if
		
		//connection to school
		$connection = test_input($_POST["connection"]);

		//set default friend status to not friends
		$_POST["friend"] = $friend;
		
		//error checking for images
		$target_file = $target_dir . basename($_FILES["profilepic"]["name"]);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		//check if an image was uploaded or not
		if(empty($_FILES["profilepic"]["name"])){
			$imageErr = "*Please submit a profile image";
			$isDataValid = false;
		}//if
		
		// Check file size
		if ($_FILES["profilepic"]["size"] > 4000000) {
			$imageSizeErr = "*File is too large, maximum file size is 4MB";
			$isDataValid = false;
		}//if
		
		// Allow certain file formats
		if(!empty($_FILES["profilepic"]["name"]) && $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"){
			$imageTypeErr = "*Only the JPG and PNG files are allowed.";
			$isDataValid = false;
		} else {
			$imageType = $imageFileType;
			$_POST["imageType"] = $imageType;
		}//else
	}//else
	
	//create profileimages if it doesn't exist
	if(!is_dir($target_dir)){
		mkdir($target_dir);
		echo "<br>" . $target_dir . " created!<br>";
	}//if 

	//create thumbnails if it doesn't exist
	if(!is_dir($thumbnail_dir)){
		mkdir($thumbnail_dir);
	}//if 
	
}//if form submitted

include "header.inc";

//display content
//if the form is submitted
if($formSubmitted == true){
	if ($isDataValid == true){		
		// read json file into array of strings
		if (file_exists($file)){
			$jsonstring = file_get_contents($file);
			//decode the string from json to PHP array
			$phparray = json_decode($jsonstring, true);				
		}//if

		// add form submission to data
		$phparray[] = $_POST;

		// encode the php array to formatted json 
		$jsoncode = json_encode($phparray, JSON_PRETTY_PRINT);
			
		// write the json to the file
		file_put_contents($file, $jsoncode);
		
		$target_file = $target_dir . basename($uid) . "." . $imageFileType;
					
		//actually upload the file
		if (move_uploaded_file($_FILES["profilepic"]["tmp_name"], $target_file)) {
			//echo "The file ". htmlspecialchars( basename( $_FILES["profilepic"]["name"])). " has been uploaded.";
		} else {
			//echo "Sorry, there was an error uploading your file.";
		}//else

		//create thumbnail for image
		// set source and destination(create this folder and put this image there)
		$src = "profileimages/" . basename($uid) . "." . $imageFileType;
		$newName = strtolower($phparray[count($phparray)-1]["name"]);
		$dest = "thumbnails/" .$newName. "_".basename($uid). "." . $imageFileType;
	
		// create a thumbnail of an image on the server
		if (!file_exists($dest)) {
			createThumbnail($src, $dest, 240, 240);
		}//if

		//update a list of filenames in a json file
		$nameFile = "filename.json";
		$fileNameArray = scandir($thumbnail_dir);
		$nameJson = json_encode($fileNameArray);
		file_put_contents($nameFile,$nameJson);

		//update UID
		$uid = file_put_contents("identifier.txt", [$uid + 1]);

		include "home.inc";

	} else {
		echo "<br>There were errors.";
		include "form.inc";
	}//else
} else {

	if(isset($_GET["x"])){
		$x = $_GET["x"];
	} else {
		$x = "home";
	}//else
	
	if ($x == "3"){
		include "form.inc";
	} else if ($x == "4"){
			
			//create friend directory if needed
				if(!is_dir($friend_dir)){
					mkdir($friend_dir);
				}//if

				//delete all previous files in the directory upon new search
				if ($dh = opendir($friend_dir)){
					while (($file2 = readdir($dh)) !== false){
						if ($file2 != "." && $file2 != ".."){
							unlink($friend_dir . $file2);
						}//if
					}//while
					closedir($dh);
				}//if

				if (file_exists($file)){
				//read the json file
				$jsonstring = file_get_contents($file);				
				$jsonarray = json_decode($jsonstring, true);

				//create a thumbnail in the friendimage/ directory for every profile that the person
				//logged in is friends with
				for($i = 0; $i < count($jsonarray); $i++){
					if($jsonarray[$i]["friend"] == "Unfriend?"){
						$src = "thumbnails/".scandir($thumbnail_dir)[($i+2)];
						$imageType = strtolower(pathinfo($src,PATHINFO_EXTENSION));
						$dest = $friend_dir.($i+1).".".$imageType;
						if (!file_exists($dest)) {
							createThumbnail($src, $dest, 240, 240);
						}//if	
					}//if
				}//for
				
				}//if

				include "friends.inc";
		} else {

		//search
		if(!empty($_GET["search"])){

			//create search directory if needed
			if(!is_dir($search_dir)){
				mkdir($search_dir);
			}//if

			//delete all previous files in the directory upon new search
			if ($dh = opendir($search_dir)){
				while (($file1 = readdir($dh)) !== false){
					if ($file1 != "." && $file1 != ".."){
						unlink($search_dir . $file1);
					}//if
				}//while
				closedir($dh);
			}//if

			//read the json file
			$jsonstring = file_get_contents($file);
			$jsonarray = json_decode($jsonstring, true);
			
			//search loop
			for( $i = 0; $i < count($jsonarray); $i++){
				if(str_contains(strtolower($jsonarray[$i]["name"]), strtolower($_GET["search"]))){
					$src = "";

					//check image type
					if(file_exists("profileimages/".($i+1).".jpg")){
						$src = $target_dir.($i+1).".jpg";
					}//if
					else if(file_exists("profileimages/".($i+1).".png")){
						$src = $target_dir.($i+1).".png";
					}//else if
					else if(file_exists("profileimages/".($i+1).".jpeg")){
						$src = $target_dir.($i+1).".jpeg";
					}//else if
					else if(file_exists("profileimages/".($i+1).".gif")){
						$src = $target_dir.($i+1).".gif";
					}//else if
					
					$imageType = strtolower(pathinfo($src,PATHINFO_EXTENSION));

					$newName = strtolower($jsonarray[$i]["name"]);
					$dest = $search_dir.$newName."_".($i+1).".".$imageType;
					if (!file_exists($dest)) {
						createThumbnail($src, $dest, 240, 240);
					}//if

				}//if
			}//for

			//update a list of file names in search upon update
			$searchFile = "searchname.json";
			$searchNameArray = scandir($search_dir);
			$searchJson = json_encode($searchNameArray);
			file_put_contents($searchFile, $searchJson);
			
			include "search.inc";
			$_GET["search"] = "";

		}else {
			include "home.inc";
		}//else

	}//else

}//else
	
include "footer.inc";

?>