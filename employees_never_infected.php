<?php
require("mysql_init.php");
//List all facilities
$sql_employees_never_infected = "SELECT e.EmployeeRole,
COUNT(DISTINCT e.EmployeeID) AS TotalEmployees,
COUNT(DISTINCT CASE WHEN i.InfectionType IS NULL 
                    OR (i.InfectionType != 'COVID-19') THEN w.EmployeeID END) AS NonInfectedEmployees
FROM 
Employees e
LEFT JOIN 
WorksAt w ON e.EmployeeID = w.EmployeeID
LEFT JOIN 
Infections i ON e.SSN = i.PersonSSN
GROUP BY 
e.EmployeeRole
ORDER BY 
e.EmployeeRole ASC;";
$result = $mysqli->query($sql_employees_never_infected);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Employee Report with No Infections</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            Report of All Employees with Total Number of Never Infected
</h1>

<table>
<tr>
    <th>Role</th>
    <th>Number of Employees in All Facilities</th>
    <th>Number of Employees Never Infected by Covid-19</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["EmployeeRole"]}</td> 
   <td> {$row["TotalEmployees"]}</td>
   <td> {$row["NonInfectedEmployees"]}</td>
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
