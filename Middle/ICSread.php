<?php


$input = json_decode(file_get_contents('php://input'), true);
$f = json_decode($_POST);
//echo '<pre>';
//echo $_POST;
print_r($_POST);


//echo json_encode($f);
$sep = "\n";
//$str = strtok($f, $sep);
//$str = strtok($sep);
$arr = explode(" ", $f);
//$arr = preg_split (' ', $string);
//echo json_encode($arr);

?>
