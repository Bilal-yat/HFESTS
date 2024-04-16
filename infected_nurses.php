<?php
require("mysql_init.php");
//List all facilities
$sql_infected_nurses = "SELECT p.FirstName,
p.LastName,
e.StartDate AS FirstDayOfWork,
p.DateOfBirth,
p.Email,
COUNT(i.InfectionID) AS TotalInfections,
COUNT(DISTINCT v.VaccineID) AS TotalVaccines,
SUM(TIME_TO_SEC(TIMEDIFF(s.EndTime, s.StartTime))) / 3600 AS TotalScheduledHours,
COUNT(DISTINCT CASE WHEN la.IsPrimary = 'N' THEN la.AddressID END) AS TotalSecondaryResidences
FROM Employees e
JOIN Persons p ON e.SSN = p.SSN
JOIN Infections i ON p.SSN = i.PersonSSN
JOIN Vaccines v ON p.SSN = v.PersonSSN
JOIN Schedules s ON e.EmployeeID = s.EmployeeID
JOIN LivesAt la ON e.EmployeeID = la.EmployeeID
WHERE e.EmployeeRole = 'Nurse'
AND e.StartDate IS NOT NULL
AND i.InfectionType = 'COVID-19'
AND i.InfectionDate >= DATE_SUB(CURDATE(), INTERVAL 2 WEEK)
GROUP BY e.EmployeeID, p.FirstName, p.LastName, e.StartDate, p.DateOfBirth, p.Email
HAVING COUNT(DISTINCT e.FacilityID) >= 1
ORDER BY e.StartDate ASC, p.FirstName ASC, p.LastName ASC;
";
$result = $mysqli->query($sql_infected_nurses);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Infected Nurses</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            Nurses Infected with Covid19 in Past Two Weeks Working at Two or More Facilities
</h1>

<table>
<tr>
    <th>FirstName</th>
    <th>Last Name</th>
    <th>First Day of Work</th>
    <th>Date of Birth</th>
    <th>Email Address</th>
    <th>Number of Infections</th>
    <th>Number of Vaccines Received</th>
    <th>Number of Hours Scheduled</th>
    <th>Number of Secondary Residences</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["FirstName"]}</td> 
   <td> {$row["LastName"]}</td>
   <td> {$row["FirstDayOfWork"]}</td>
   <td> {$row["DateOfBirth"]}</td>
   <td> {$row["Email"]}</td>
   <td> {$row["TotalInfections"]}</td>
   <td> {$row["TotalVaccines"]}</td>
   <td> {$row["TotalScheduledHours"]}</td>
   <td> {$row["TotalSecondaryResidences"]}</td>
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
