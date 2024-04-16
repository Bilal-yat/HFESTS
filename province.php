<?php
require("mysql_init.php");
//List all facilities
$sql_province = "SELECT a.Province,
COUNT(DISTINCT f.FacilityID) AS TotalFacilities,
COUNT(DISTINCT w.EmployeeID) AS TotalEmployees,
COUNT(DISTINCT CASE WHEN i.InfectionType = 'COVID-19' 
                    AND i.InfectionDate >= DATE_SUB(CURRENT_DATE(), INTERVAL 14 DAY) THEN w.EmployeeID END) AS InfectedEmployees,
MAX(f.Capacity) AS MaxCapacity,
SUM(TIMESTAMPDIFF(HOUR, s.StartTime, s.EndTime)) AS TotalScheduledHours
FROM 
Facilities f
JOIN 
Address a ON f.AddressID = a.AddressID
LEFT JOIN 
WorksAt w ON f.FacilityID = w.FacilityID
LEFT JOIN 
Infections i ON w.EmployeeID = i.PersonSSN
LEFT JOIN 
Schedules s ON f.FacilityID = s.FacilityID
GROUP BY 
a.Province
ORDER BY 
a.Province ASC;";
$result = $mysqli->query($sql_province);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Data by Province</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            Health Data by Province
</h1>

<table>
<tr>
    <th>Province</th>
    <th>Total Number of Facilities</th>
    <th>Total Number of Employees</th>
    <th>Employees Infected by Covid-19 in Past 2 Weeks</th>
    <th>Total Max Capacity</th>
    <th>Total Scheduled Hours</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["Province"]}</td> 
   <td> {$row["TotalFacilities"]}</td>
   <td> {$row["TotalEmployees"]}</td>
   <td> {$row["InfectedEmployees"]}</td>
   <td> {$row["MaxCapacity"]}</td>
   <td> {$row["TotalScheduledHours"]}</td>
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
