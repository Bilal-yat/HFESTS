<?php
require("mysql_init.php");
//List all doctors infected in the last 2 weeks
$sql_doctors_inf_two_weeks = "SELECT p.FirstName, p.LastName, i.InfectionDate, f.FacilityName,
(SELECT COUNT(*) FROM LivesAt la 
 JOIN Employees e2 ON la.EmployeeID = e2.EmployeeID
 WHERE e2.SSN = p.SSN AND la.IsPrimary = 'N') AS NumSecondaryResidences
FROM Infections i 
JOIN Employees e ON i.PersonSSN = e.SSN
JOIN Persons p ON p.SSN = e.SSN
JOIN Facilities f ON e.FacilityID = f.FacilityID
WHERE i.InfectionType = 'COVID-19'
AND i.InfectionDate >= DATE_SUB(CURDATE(), INTERVAL 14 DAY) -- Within past two weeks
AND e.EmployeeRole = 'Doctor'
ORDER BY f.FacilityName ASC, NumSecondaryResidences ASC;"; 

$result = $mysqli->query($sql_doctors_inf_two_weeks);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Infected Doctors Two Weeks</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            List of Doctors Infected with Covid19 in the Past Two Weeks
</h1>

<table>
<tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Infection Date</th>
    <th>Works At</th>
    <th>Number of Secondary Residences</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["FirstName"]}</td> 
   <td> {$row["LastName"]}</td>
   <td> {$row["InfectionDate"]}</td>
   <td> {$row["FacilityName"]}</td>
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
