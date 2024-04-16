<?php
require("mysql_init.php");
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$eid = $queries["EID"];
$startDate = date('Y-m-d', strtotime($queries["startdate"]));
$endDate = date('Y-m-d', strtotime($queries["enddate"]));

//List all employees of given facility
$sql_emp_schedules = "SELECT F.FacilityName,
S.ScheduleStart AS DayOfYear,
S.StartTime,
S.EndTime
FROM Schedules S
JOIN Facilities F ON S.FacilityID = F.FacilityID
WHERE S.EmployeeID = $eid
AND S.ScheduleStart AND S.ScheduleEnd BETWEEN '$startDate' AND '$endDate' 
ORDER BY F.FacilityName ASC, S.ScheduleStart ASC, S.StartTime ASC;";
$result = $mysqli->query($sql_emp_schedules);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Employee Schedules</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            Schedules for Selected Employee
</h1>

<table>
<tr>
    <th>Facility Name</th>
    <th>Date</th>
    <th>Start Time</th>
    <th>End Time</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["FacilityName"]}</td> 
   <td> {$row["DayOfYear"]}</td>
   <td> {$row["StartTime"]}</td>
   <td> {$row["EndTime"]}</td>  
   </tr>\n";
  }
  
} else {
  echo "0 results";
}

echo "</table>";
?>
</table>
</div>
</div>
</body>
</html>