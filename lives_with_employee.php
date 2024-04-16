<?php
require("mysql_init.php");
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$eid1 = $queries["EID2"];
//List all roomates
$sql_lives_with = "SELECT A.StreetAddress,
A.City,
A.Province,
A.PostalCode,
CASE 
    WHEN R.IsSecondaryResidence = 'N' THEN 'Primary'
    ELSE 'Secondary'
END AS ResidenceType,
P.FirstName AS PersonFirstName,
P.LastName AS PersonLastName,
P.Occupation AS PersonOccupation,
Relationships.RelationshipType AS RelationshipWithEmployee
FROM Persons AS P
JOIN Relationships ON P.SSN = Relationships.PersonSSN
JOIN Residence AS R ON P.ResidenceID = R.ResidenceID
JOIN Address AS A ON R.AddressID = A.AddressID
WHERE R.ResidenceID IN (
SELECT ResidenceID
FROM Residence
WHERE EmployeeID = $eid1 -- Replace [EmployeeID] with the ID of the given employee
)
AND P.SSN <> '999-99-0000'; -- Exclude the employee from the result";

$result = $mysqli->query($sql_lives_with);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>People Living With Employee</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            List of All Individuals Living with the Employee
</h1>

<table>
<tr>
    <th>Address</th>
    <th>City</th>
    <th>Province</th>
    <th>Postal Code</th>
    <th>Residence Type</th>
    <th>Roomate First Name</th>
    <th>Roomate Last Name</th>
    <th>Occupation</th>
    <th>Relationship with Employee</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["StreetAddress"]}</td> 
   <td> {$row["City"]}</td>
   <td> {$row["Province"]}</td>
   <td> {$row["PostalCode"]}</td>
   <td> {$row["ResidenceType"]}</td>
   <td> {$row["PersonFirstName"]}</td>
   <td> {$row["PersonLastName"]}</td>
   <td> {$row["PersonOccupation"]}</td>
   <td> {$row["RelationshipWithEmployee"]}</td>
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
