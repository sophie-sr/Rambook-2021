<!DOCTYPE html>

<!-- content for header: includes reference to css and javascrrirpt files, title and navigation bar -->
  <html lang="en">
	<head>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width, initial-scale=1.0" charset="utf-8">
		<title>Rampage</title>
		 
		<!-- include an external style sheet -->
		<link rel="stylesheet" href="form.css">  
		
		<!-- include an external JavaScript file -->
		<script src="form.js"></script>
		
		<link rel="icon" type="image/x-icon" href="favicon.ico">
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
		
	</head>
  
	<body>
		<!-- page content -->
	
	<div id="navbar">
		<a href="javascript:void(0)" id="logo">RAMPAGE</a>
	    <div id="navbar-right">
			<div class="search-container">
				<form name="form" action="index.php" method="get">
					<input type="text" placeholder="Search..." name="search" id="subject" value="">
					<button type="submit"><i class="fa fa-search"></i></button>
				</form>
			</div>
			
			<a href = 'index.php'>Explore Profiles</a>
			<a href = '?x=4' id="friends">Friends</a>
			<a href = '?x=3'>Add Profile</a>				
	    </div>
	</div>
	
	<br><br><br><br>