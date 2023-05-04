<?php
	$file = "userprofiles.json";
	$jsonstring = file_get_contents($file);
	
	$jsonarray = json_decode($jsonstring, true);

	if(isset($_GET["uid"])){
		for($i = 0; $i < count($jsonarray); $i++){
			if($_GET["uid"] == $jsonarray[$i]["uid"]){
				echo json_encode($jsonarray[$i]);
				die;
			}
		}
	}
?>