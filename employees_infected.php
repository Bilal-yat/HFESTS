<?php
require("mysql_init.php");
//List employees infected with Covid-19
$sql_employees_infected = "SELECT 
e.EmployeeRole,
COUNT(DISTINCT e.EmployeeID) AS TotalEmployees,
COUNT(DISTINCT CASE WHEN i.InfectionType = 'COVID-19' 
                    AND i.InfectionDate >= DATE_SUB(CURRENT_DATE(), INTERVAL 14 DAY) THEN w.EmployeeID END) AS InfectedEmployees
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
$result = $mysqli->query($sql_employees_infected);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Employee Report with Infection</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            Report of All Employees with Total Number of Infected
</h1>

<table>
<tr>
    <th>Role</th>
    <th>Number of Employees in All Facilities</th>
    <th>Number Infected by Covid-19</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["EmployeeRole"]}</td> 
   <td> {$row["TotalEmployees"]}</td>
   <td> {$row["InfectedEmployees"]}</td>
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
