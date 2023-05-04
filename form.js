//show the grade dropdown list if currentstudent is selected
function showGrade(){
	let element = document.getElementById("grade");
	if (document.getElementById("currentstudent") != null){
		if (document.getElementById("currentstudent").checked == true){
			element.style.display = "block";
		} else if (document.getElementById("currentstudent").checked == false){
			element.style.display = "none";
		}//else if
	}//if
}//showGrade

//when friend button is clicked, display a friend into not a friend or display a not friend unto a friend
function friend(uid) {
    if (document.getElementById("friend").innerHTML == "Unfriend?"){
		document.getElementById("friend").innerHTML = "Friend?";
	} else if (document.getElementById("friend").innerHTML == "Friend?"){
		document.getElementById("friend").innerHTML = "Unfriend?";
	}
	
	fetch('http://142.31.53.220/~group2/rambook99/friend.php?uid=' + uid)
		
}//friend

// When the user scrolls down 80px from the top of the document, resize the navbar's padding and the logo's font size
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 80 || document.documentElement.scrollTop > 80) {
    document.getElementById("navbar").style.padding = "10px 0px";
    document.getElementById("logo").style.fontSize = "25px";
  } else {
    document.getElementById("navbar").style.padding = "250px 0px";
    document.getElementById("logo").style.fontSize = "2em";
  }//else
}//scrollFunction

//change the visibility of divID
function changeVisibility(divID) {
    var element = document.getElementById(divID);
	//if lightbox is on, unable the scroll on the home page
    if(divID == "lightbox"){
		document.getElementsByTagName("body")[0].className = (element.className == 'hidden') ? 'no-scroll' : '';
	}//if

    //if element exists, toggle it's class between hidden and unhidden
    if (element) {
        element.className = (element.className == 'hidden') ? 'unhidden' : 'hidden';
    }//if  
}//changeVisibility

//toggles lightbox with bigImage in it
function toggleLightBox(imageFile, alt) {
	
	if(imageFile != ''){
    
		var image = new Image();
		var bigImage = document.getElementById("bigImage");

		//get the uid of the image
		const nameArray = imageFile.split('.');
		var name = nameArray[0];
		var fileType = nameArray[1];
		const uidArray = name.split('_');
		var uid = uidArray[uidArray.length - 1];
		
		image.src = "profileimages/" + uid + "." + fileType;
		image.alt = alt;
		
		//force big image to preload so we can have access to its width so it will be centered
		image.onload = function () {
			var width = window.innerWidth * 0.40;
			var height = window.innerHeight * 0.6;
			
			document.getElementById("boundaryBigImage").style.width = width + "px";	
			
			if (window.innerWidth <= 400) {
				document.getElementById("boundaryBigImage").style.width = (window.innerWidth * 0.8) + "px";
				document.getElementById("bigImage").style.width = "100%";
				document.getElementById("bigImage").style.height = "auto";
			} else if (image.height < image.width){
				document.getElementById("boundaryBigImage").style.width = width + "px";
				document.getElementById("bigImage").style.width = "100%";
				document.getElementById("bigImage").style.height = "auto";						
			} else if (image.height > image.width){
				document.getElementById("boundaryBigImage").style.height = height + "px";
				document.getElementById("bigImage").style.height = "100%";
				document.getElementById("bigImage").style.width = "auto";
				
				//document.getElementById("boundaryBigImage").style.width = (image.width * height / image.height) + "px";
				//document.getElementById("bigImage").style.height = "auto";
				//document.getElementById("bigImage").style.width = "100%";
			}//if
		}//onload function
		
		document.getElementById("friend").onclick = function () {
			friend(uid);
		}//function
		
		bigImage.src = image.src; 
		bigImage.alt = image.alt;

		//fetch the json data by image uid
		fetch('http://142.31.53.220/~group2/rambook99/getData.php?uid=' + uid)
		.then(response => response.json())
		.then(data => updateContents(data))
	
	}//if
    
    changeVisibility('lightbox');
    changeVisibility('boundaryBigImage');
}//toggleLightBox

//update the profile data according to the profile image
function updateContents(data){
	var ifgrade = "";
	var c = "";
	
	if(data.grades != ""){
		ifgrade = "Grade: ";
	}//if
	
	if (data.connection == "currentstudent"){
		c = "Current Student";
	}//if
	if (data.connection == "alumni"){
		c = "Alumni";
	}//if
	if (data.connection == "staff"){
		c = "Staff";
	}//if
	
	if(data.friend == "false"){
		document.getElementById("friend").innerHTML = "Friend?";
	}
	if(data.friend == "true"){
		document.getElementById("friend").innerHTML = "Unfriend?";
	}//if
	
	document.getElementById("name").innerHTML = data.name;
	document.getElementById("info").innerHTML = "About: " + data.bio + "<br>Connection to Mount Doug: " + c + "<br>" + ifgrade + data.grades;
	document.getElementById("friend").innerHTML = data.friend;
	document.getElementById("download").href = "profileimages/" + data.uid + "." + data.imageType;
}//updateContents

//display the profile name in home page
function loadNames(){	
	for (i = 0; i < document.getElementsByClassName("names").length; i++){
		let imageName = document.getElementsByClassName("names").item(i).innerHTML;
		var nameArray = imageName.split('/');
		var name = nameArray[nameArray.length - 1];
		var actualArray = name.split('_');
		var name = actualArray[actualArray.length - 1];
		var uidArray = name.split(".");
		let uid = uidArray[0];
		fetch('http://142.31.53.220/~group2/rambook99/getData.php?uid=' + uid)
			.then(response => response.json())
			.then(data => changeName(data,uid));			
	}//for
}//loadNames

//change the profile name for each thumbnail image
function changeName(data,uid){
	for (i = 0; i < document.getElementsByClassName("names").length; i++){
		let imageName = document.getElementsByClassName("names").item(i).innerHTML;
		var nameArray2 = imageName.split('/');
		var name2 = nameArray2[nameArray2.length - 1];
		var actualArray2 = name2.split('_');
		var name2 = actualArray2[actualArray2.length - 1];
		var uidArray2 = name2.split(".");
		let uid2 = uidArray2[0];
		if (uid == uid2){
			document.getElementById(imageName).innerHTML = data.name;
		}//if		
	}//for	
}//changeName

//run the functions when the page is loaded 
window.onload = function onloadFuntions() {
	loadNames();
	showGrade();
}//onload functions

//change the big image to one to its right
function rightArrow(){
	console.log("good");
	//get thumbnail name	
	const typeArray = document.getElementById("bigImage").src.split('/');
	var name = typeArray[typeArray.length - 1];
	const nameArray = name.split('.');
	var uidString = nameArray[0];
	var imageType = nameArray[1];
	var newUid = parseInt(uidString);
	var fileName = document.getElementById("name").innerHTML;
	var newName = fileName.toLowerCase();
	var thumbnailName = newName + "_" + newUid + "." + imageType;

	//fetch the next file in thumbnail directory
	fetch('http://142.31.53.220/~group2/rambook99/getName.php?fileright=' + thumbnailName)
		.then(response => response.json())
		.then(data => updateImage(data))

}//rightArrow

//change the big image to one to its left
function leftArrow(){	
	//get thumbnail name
	const typeArray = document.getElementById("bigImage").src.split('/');
	var name = typeArray[typeArray.length - 1];
	const nameArray = name.split('.');
	var uidString = nameArray[0];
	var imageType = nameArray[1];
	var newUid = parseInt(uidString);
	var fileName = document.getElementById("name").innerHTML;
	var newName = fileName.toLowerCase();
	var thumbnailName = newName + "_" + newUid + "." + imageType;

	//fetch the previous file in thumbnail directory
	fetch('http://142.31.53.220/~group2/rambook99/getName.php?fileleft=' + thumbnailName)
		.then(response => response.json())
		.then(data => updateImage(data))
}//leftArrow

//change the big image one to the right upon arrow click in search page
function rightArrowSearch(){	
	const typeArray = document.getElementById("bigImage").src.split('/');
	var name = typeArray[typeArray.length - 1];
	const nameArray = name.split('.');
	var uidString = nameArray[0];
	var imageType = nameArray[1];
	var newUid = parseInt(uidString);
	var fileName = document.getElementById("name").innerHTML;
	var newName = fileName.toLowerCase();
	var thumbnailName = newName + "_" + newUid + "." + imageType;
	fetch('http://142.31.53.220/~group2/rambook99/getSearchName.php?fileright=' + thumbnailName)
		.then(response => response.json())
		.then(data => updateImage(data))
}//rightArrowSearch

//change the big image one to the left upon arrow click in search page
function leftArrowSearch(){	
	const typeArray = document.getElementById("bigImage").src.split('/');
	var name = typeArray[typeArray.length - 1];
	const nameArray = name.split('.');
	var uidString = nameArray[0];
	var imageType = nameArray[1];
	var newUid = parseInt(uidString);
	var fileName = document.getElementById("name").innerHTML;
	var newName = fileName.toLowerCase();
	var thumbnailName = newName + "_" + newUid + "." + imageType;
	fetch('http://142.31.53.220/~group2/rambook99/getSearchName.php?fileleft=' + thumbnailName)
		.then(response => response.json())
		.then(data => updateImage(data))
}//leftArrowSearch

//update the big image when arrow is clicked
function updateImage(data){
	var name = data.split("_");
	var actualName = name[1];
	var uidArray = actualName.split(".");
	var uid = uidArray[0];
	var imageType = uidArray[1];
	document.getElementById("bigImage").src = "profileimages/" + uid + "." + imageType;

	//fetch other information upon change in big image
	fetch('http://142.31.53.220/~group2/rambook99/getData.php?uid=' + uid)
		.then(response => response.json())
		.then(data => updateContents(data))
}//updateImage

