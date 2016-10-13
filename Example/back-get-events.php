<?php
$input = json_decode(file_get_contents('php://input'), true);
$output = "";
$id = $input['id'];
if(!$id){
 $id = 0;
}

$conn = new mysqli('sql2.njit.edu', 'cab56', '6beeUfL5', 'cab56');
$query = "SELECT * FROM Event JOIN UserEvent ON UserEvent.EventID = Event.ID
WHERE UserEvent.UserID = ".$id.";";
$result = $conn->query($query);
while ($rs = $result->fetch_array(MYSQLI_ASSOC)){
  if($output != ""){$output .= ",";}
  $output .= '{"Calendar": "'.$rs["Calendar"].'",';
  $output .= '"Event": "'.$rs["Event"].'",';
  $output .= '"StartDate": "'.$rs["StartDate"].'"}';
}
$conn->close();
if($id && !$output){
  echo "no events";
}else{
  echo $output;
}
?>
