<?php
$input = json_decode(file_get_contents('php://input'), true);

$usr = $input['usr'];
$pwd = $input['pwd'];

$conn = new mysqli('sql2.njit.edu', 'cab56', '6beeUfL5', 'cab56');
$query = "SELECT ID FROM Login WHERE UserName ='".$usr."' AND Password = '".
$pwd."'";
$result = $conn->query($query);
$value = $result->fetch_array(MYSQLI_ASSOC);
$conn->close();

echo $value['ID'];

?>
