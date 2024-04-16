<?php
require("mysql_init.php");
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$fid = $queries["FID3"];
//List employees with 3 or more residences
$sql_list_ballers = "SELECT p.FirstName,
p.LastName,
e.EmployeeRole AS EmpRole,
COUNT(CASE WHEN la.IsPrimary = 'N' THEN la.AddressID END) AS NumSecondaryResidences
FROM Employees e
JOIN Persons p ON e.SSN = p.SSN
JOIN LivesAt la ON e.EmployeeID = la.EmployeeID
JOIN Schedules s ON e.EmployeeID = s.EmployeeID AND s.ScheduleStart >= DATE_SUB(CURDATE(), INTERVAL 4 WEEK)
WHERE e.FacilityID = $fid
GROUP BY e.EmployeeID
HAVING NumSecondaryResidences >= 3
ORDER BY EmpRole ASC, NumSecondaryResidences ASC;";

$result = $mysqli->query($sql_list_ballers);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Employees with secondary residences</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            List of employees with 3 or more residences and on schedule in last 4 weeks
</h1>

<table>
<tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Role</th>
    <th>Number of Secondary Residences</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["FirstName"]}</td> 
   <td> {$row["LastName"]}</td>
   <td> {$row["EmpRole"]}</td>
   <td> {$row["NumSecondaryResidences"]}</td>
 
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
