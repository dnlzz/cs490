<!DOCTYPE html>
<html>

    <body>
        <?php
        session_start();
        include 'loginFront.php';
        
        function genCalendar($month, $year, $myEvents){
            echo date("F","Y");
            //$usrInf = getEvent();
            //$myEvents=json_decode(curlFunc($usrInf), true);//Gets events and puts them into a traversable array;
            
            //echo $myEvents[0]["event_start_date"];
            //print_r(date("d",strtotime($myEvents[i]["event_start_date"])));
            //print_r($_SESSION);
            //print_r($myEvents);
            /*uses unix time stamps to properly format calendar*/
            $firstDayofMonth = date("l", mktime(0,0,0,$month, 1, $year));
            $daysinMonth = date('t',mktime(0,0,0,$month,1,$year));
            $daysinWeek = 1;
            $dayCount = 0;
            $dates = array();

            /*Calendar HTML buffer*/
            $calendar = '<label>'.date($month).'</label><table cellpadding="5" cellspacing="2" class="calendar">';

            /*Top Row*/
            $header = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
            $calendar.='<tr class="calendar-row"><td class="calendar-day-head">'.implode('</td><td class="calendar-day-head">',$header).'</td></tr>';

            /*first row of days*/
            $calendar.= '<tr class="calendar_row">';
            for($x = 0; $header[$x] != $firstDayofMonth; $x++){
                $calendar.= '<td class="calendar-day-blank"></td>';
                $daysinWeek++;
                $dayofWeek=$x;
            }
            $dayofWeek++;
            $i = 0;
            for($monthDay = 1; $monthDay <= $daysinMonth; $monthDay++){
                $todayDate = $year.'-'.$month.'-'.$monthDay;
                $calendar.= '<td class="calendar-day"><div class="day-number" onclick="addEvent(\''.$todayDate.'\')">'.$monthDay.'</div>';
                
                /*########add in events here############*/
                while($month == date("m",strtotime($myEvents["result"]["msg"][$i]["event_start_date"])) && $monthDay == date("d",strtotime($myEvents["result"]["msg"][$i]["event_start_date"]))){//turn this into while loop to check for all events of that day

                    $calendar.='<button class="event '.$myEvents["result"]["msg"][$i]["event_calendar"].'" onclick="editRemove('.$i.');">'.$myEvents["result"]["msg"][$i]["event_name"].'</button><br>';
                    $i++;
                }
                /*########close the cell################*/

                $calendar.='</td>';

                if($header[$dayofWeek]=="Saturday"){
                    $calendar.='</tr>';
                    if(($dayCount+1) != $daysinMonth){
                        $calendar.= '<tr class="calendar-row">';
                    }
                    $dayofWeek=-1;
                    $daysinWeek=0;
                }
                $daysinWeek++;
                $dayofWeek++;
                $dayCount++;

            }
            if($daysinWeek < 8){
                for($x = 1; $x <= (8 - $daysinWeek); $x++){
                    $calendar.= '<td class="calendar-day-blank"> </td>';
                }
            }

            /* final row */
            $calendar.= '</tr></table>';
            /*return finished html buffer as code to echo*/
            return $calendar;

        }
        function eventClick($event){
            $eventForm = '';
        }
        
        $usrInf = getEvent();
        print_r($usrInf);
        $myEvents=json_decode(curlFunc($usrInf), true);//Gets events and puts them into a traversable array
        echo genCalendar(10, 2016, $myEvents);
 
        ?>
        
        <div id="eventForm"></div>
        <script>
         function clearHTML(){
             html = '';
             document.getElementById('eventForm').innerHTML = html;
         }
         function editRemove(eventID){
             var jsonEventVal = <?php echo json_encode($myEvents); ?>;
             html = '<div id="editremoveform"><form action="loginFront.php" method="post">Event Name:<input type="text" name="event_name" value="';
             html += jsonEventVal.result.msg[eventID].event_name;
             html += '"><br>Event Start Day:<input type="text" name="event_start_date" value="';
             html += jsonEventVal.result.msg[eventID].event_start_date;
             html += '"><br>Event End Day:<input type="text" name="event_end_date" value="';
             html += jsonEventVal.result.msg[eventID].event_end_date;
             html += '"><br>Event Start Time:<input type="text" name="event_start_time" value="';
             html += jsonEventVal.result.msg[eventID].event_start_time;
             html += '"><br>Event End Time:<input type="text" name="event_end_time" value="';
             html += jsonEventVal.result.msg[eventID].event_end_time;
             html += '"><br>Event Repeated:<input type="text" name="event_repeated" value="';
             html += jsonEventVal.result.msg[eventID].event_repeated;
             html += '"><br>Event Description:<input type="text" name="event_desc" value="';
             html += jsonEventVal.result.msg[eventID].event_description;
             html += '"><br>Event Calendar:<input type="text" name="event_calendar" value="';
             html += jsonEventVal.result.msg[eventID].event_calendar;
             html += '"><br>Event Location Lattitude:<input type="text" name="event_location_lat" value="';
             html += jsonEventVal.result.msg[eventID].event_location_lat;
             html += '"><br>Event Location Longitude:<input type="text" name="event_location_long" value="';
             html += jsonEventVal.result.msg[eventID].event_location_long;
             html += '"><br><input type="radio" name="event_public" value=1> Public<br><input type="radio" name="event_public" value=0> Private<br><button type="submit" class="edit" name="editbtn">Save Changes</button><button class="delete" name="removebtn">Delete</button></form><button onclick="clearHTML();">x</button><br></div>';
             //this.html = html;
             document.getElementById('eventForm').innerHTML = html;
         }
         function addEvent(dateStart){
             html = '<div id="addEventForm"><form action="loginFront.php" method="post">Event Name:<input type="text" name="event_name" value="';
             html += '"><br>Event Start Day:<input type="text" name="event_start_date" value="';
             html += dateStart;
             html += '"><br>Event End Day:<input type="text" name="event_end_date" value="';
             html += dateStart;
             html += '"><br>Event Start Time:<input type="text" name="event_start_time" value="';
             html += '"><br>Event End Time:<input type="text" name="event_end_time" value="';
             html += '"><br>Event Repeated:<input type="text" name="event_repeated" value="';
             html += '"><br>Event Description:<input type="text" name="event_desc" value="';
             html += '"><br>Event Calendar:<input type="text" name="event_calendar" value="';
             html += '"><br>Event Location Lattitude:<input type="text" name="event_location_lat" value="';
             html += '"><br>Event Location Longitude:<input type="text" name="event_location_long" value="';
             html += '"><br><input type="radio" name="event_public" value=1> Public<br><input type="radio" name="event_public" value=0> Private<br><button type="submit" class="edit" name="addbtn">Add Event</button></form><button onclick="clearHTML();">x</button></div>';
             document.getElementById('eventForm').innerHTML = html;
         }
        </script>
    </body>
</html>
