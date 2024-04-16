<?php
require("mysql_init.php");
//List all facilities
$sql_facilities = "SELECT F.FacilityName,
A.StreetAddress AS Address,
A.City,
A.Province,
A.PostalCode,
F.PhoneNumber,
F.WebAddress,
F.FacilityType AS Type,
F.Capacity,
(SELECT CONCAT(P.FirstName, ' ', P.LastName) FROM Persons P INNER JOIN Employees E ON P.SSN = E.SSN WHERE E.EmployeeRole = 'General Manager' AND E.FacilityID = F.FacilityID LIMIT 1) AS GeneralManagerName,
COUNT(DISTINCT E.EmployeeID) AS NumberOfEmployees,
SUM(CASE WHEN E.EmployeeRole = 'Doctor' THEN 1 ELSE 0 END) AS NumberOfDoctors,
SUM(CASE WHEN E.EmployeeRole = 'Nurse' THEN 1 ELSE 0 END) AS NumberOfNurses
FROM Facilities F
JOIN Address A ON F.AddressID = A.AddressID
LEFT JOIN Employees E ON F.FacilityID = E.FacilityID
GROUP BY F.FacilityID, A.StreetAddress, A.City, A.Province, A.PostalCode, F.PhoneNumber, F.WebAddress, F.FacilityType, F.Capacity
ORDER BY A.Province ASC, A.City ASC, F.FacilityType ASC, NumberOfDoctors ASC;";
$result = $mysqli->query($sql_facilities);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Facilities</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            Details of All Facilities
</h1>

<table>
<tr>
    <th>Facility Name</th>
    <th>Address</th>
    <th>City</th>
    <th>Province</th>
    <th>Postal Code</th>
    <th>Phone Number</th>
    <th>Web Address</th>
    <th>Facility Type</th>
    <th>Capacity</th>
    <th>General Manager</th>
    <th>Number of Employees</th>
    <th>Number of Doctors</th>
    <th>Number of Nurses</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["FacilityName"]}</td> 
   <td> {$row["Address"]}</td>
   <td> {$row["City"]}</td>
   <td> {$row["Province"]}</td>
   <td> {$row["PostalCode"]}</td>
   <td> {$row["PhoneNumber"]}</td>
   <td> {$row["WebAddress"]}</td>
   <td> {$row["Type"]}</td>
   <td> {$row["Capacity"]}</td>
   <td> {$row["GeneralManagerName"]}</td>
   <td> {$row["NumberOfEmployees"]}</td>
   <td> {$row["NumberOfDoctors"]}</td>
   <td> {$row["NumberOfNurses"]}</td>
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
