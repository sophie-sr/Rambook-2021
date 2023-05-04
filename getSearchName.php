<?php
	$file = "searchname.json";
	$jsonstring = file_get_contents($file);
	$jsonarray = json_decode($jsonstring, true);

	if(isset($_GET["fileright"])){
		for($i = 0; $i < count($jsonarray); $i++){
			if($_GET["fileright"] == $jsonarray[$i]){
				echo json_encode($jsonarray[$i+1]);
				die;
			}
		}
	}
	if(isset($_GET["fileleft"])){
		for($i = 0; $i < count($jsonarray); $i++){
			if($_GET["fileleft"] == $jsonarray[$i]){
				echo json_encode($jsonarray[$i-1]);
				die;
			}
		}
	}
?>