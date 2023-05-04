# File Structure

createthumbnail.php
	creates the thumbnails for uploaded photos
downloadall.php
	downloads all the photos
favicon.ico
	the favicon
footer.inc
	the footer of the website
form.css
	the css of the website, makes everything look pretty
form.inc
	html form
form.js
	the js for the website
functions.inc
	cleans the data of unnecessary characters (i.e. white spaces at the end and start of
	text input)
getData.php
	gets the respective json data for a given uid
header.inc
	the header of the website, includes the navbar
home.inc
	the home page, has the gallery of all profiles
HZip.php
	creates a zip file of all uploaded images
identifier.txt
	holds the number of the next uid
index.php
	error checks form input, reads json file, links to other pages, sorts and searches
search.inc
	displays all images (in the form of clickable thumbnails) that match or contain the
	search results
userprofiles.json
	contains all the uploaded profiles and their respective information in json format
profile.inc
	displays all friends of user
