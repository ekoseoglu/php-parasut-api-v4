<?php

// Initialize a file URL to the variable
$url = '';

// Use basename() function to return the base name of file
$file_name = basename("123123.pdf");

// Use file_get_contents() function to get the file
// from url and use file_put_contents() function to
// save the file by using base name
if(file_put_contents( $file_name,file_get_contents($url))) {
    echo "File downloaded successfully";
}
else {
    echo "File downloading failed.";
}

?>