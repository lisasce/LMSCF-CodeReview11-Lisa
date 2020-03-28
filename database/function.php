<?php
function clearString($param){
$val = trim($param);
$val = strip_tags($val);
$val = htmlspecialchars($val);
return $val;
}
?>


<!--// sanitize user input to prevent sql injection:-->
<!---->
<!--$firstName = trim($_POST['firstName']);  //trim - strips whitespace (or other characters) from the beginning and end of a string-->
<!--$firstName = strip_tags($firstName);    // strip_tags — strips HTML and PHP tags from a string-->
<!--$firstName = htmlspecialchars($firstName);    // htmlspecialchars converts special characters to HTML entities-->
