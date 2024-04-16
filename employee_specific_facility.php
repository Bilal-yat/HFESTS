<?php
require("mysql_init.php");
$queries = array();
parse_str($_SERVER['QUERY_STRING'], $queries);
$fid = $queries["FID"];

//List all employees of given facility
$sql_list_employees = "SELECT 
P.FirstName, 
P.LastName, 
E.StartDate, 
P.DateOfBirth, 
P.MedicareCardNumber, 
P.PhoneNumber AS TelephoneNumber, 
A.StreetAddress AS PrimaryAddress, 
A.City, 
A.Province, 
A.PostalCode, 
P.Citizenship, 
P.Email,
(SELECT COUNT(*) 
 FROM LivesAt LA
 JOIN Address ADDR ON LA.AddressID = ADDR.AddressID
 WHERE LA.EmployeeID = E.EmployeeID AND LA.IsPrimary = 'N') AS NumberOfSecondaryResidences
FROM Employees E
JOIN Persons P ON E.SSN = P.SSN
JOIN LivesAt L ON E.EmployeeID = L.EmployeeID AND L.IsPrimary = 'Y'
JOIN Address A ON L.AddressID = A.AddressID
WHERE E.FacilityID = $fid
AND E.EndDate IS NULL
AND EXISTS (
SELECT 1
FROM LivesAt
WHERE EmployeeID = E.EmployeeID AND IsPrimary = 'N'
)
ORDER BY E.StartDate DESC, P.FirstName ASC, P.LastName ASC;";
$result = $mysqli->query($sql_list_employees);
?>

<!DOCTYPE html>
<html lang = "en">
    <head>
        <style>
            table, th, td{
                border: 1px solid blueviolet;
            }
            </style>
        <title>Employee Manifest</title>
</head>

<body>
    <div class = "container-parent">
        <div class = "container">
            <h1 style = "margin-bottom:10px;">
            List of Employees with Secondary Residences
</h1>

<table>
<tr>
    <th>First Name</th>
    <th>Last Name</th>
    <th>Start Date</th>
    <th>Date of Birth</th>
    <th>Medicare Number</th>
    <th>Phone Number</th>
    <th>Primary Address</th>
    <th>City</th>
    <th>Province</th>
    <th>Postal Code</th>
    <th>Citizenship</th>
    <th>Email Address</th>
    <th>Number of Secondary Residences</th>
</tr>

<?php
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
   echo "<tr><td>{$row["FirstName"]}</td> 
   <td> {$row["LastName"]}</td>
   <td> {$row["StartDate"]}</td>
   <td> {$row["DateOfBirth"]}</td>
   <td> {$row["MedicareCardNumber"]}</td>
   <td> {$row["TelephoneNumber"]}</td>
   <td> {$row["PrimaryAddress"]}</td>
   <td> {$row["City"]}</td>
   <td> {$row["Province"]}</td>
   <td> {$row["PostalCode"]}</td>
   <td> {$row["Citizenship"]}</td>
   <td> {$row["Email"]}</td>
   <td> {$row["NumberOfSecondaryResidences"]}</td>
  
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
