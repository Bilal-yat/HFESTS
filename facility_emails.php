<?php
require("mysql_init.php");
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$fid = $queries["FID2"];
$startDate = date('Y-m-d', strtotime($queries["startdate1"]));
$endDate = date('Y-m-d', strtotime($queries["enddate1"]));

//List all cancellation emails for specific facility
$sql_list_emails = "SELECT *
FROM EmailLog
WHERE `Date` BETWEEN '$startDate' AND '$endDate' -- Specify the specific period of time
AND `Subject` = 'Assignment Cancellation Notice' -- Filter emails for cancellation of assignments
AND Sender = (SELECT FacilityName FROM Facilities WHERE FacilityID = $fid) -- Specify the given facility
ORDER BY `Date` DESC;";
$result = $mysqli->query($sql_list_emails);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Facility Emails</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            List of cancellation emails generated by the facility
</h1>

<table>
<tr>
    <th>Log ID</th>
    <th>Date</th>
    <th>Sender</th>
    <th>Receiver</th>
    <th>Subject</th>
    <th>Body</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["LogID"]}</td> 
   <td> {$row["Date"]}</td>
   <td> {$row["Sender"]}</td>
   <td> {$row["Receiver"]}</td>
   <td> {$row["Subject"]}</td>
   <td> {$row["Body"]}</td> 
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