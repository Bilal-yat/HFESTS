<html>
  <title>
    HFESTS
</title>
	<head>
  <h1>HFESTS Database</h1>
</head>

<body>
  <h3 style="margin-bottom:10px;">
  <a href="/facilities.php">List all Facilities</a>
</h3>
<h3>
<a href="/infected_doctors_2weeks.php">List all Doctors Infected in the Past 2 Weeks</a>
</h3>
<h3>
<a href="/infected_nurses.php">List all Nurses Infected in the Past 2 Weeks and Working in 2 or More Facilities</a>
</h3>
<h3>
<a href="/employees_infected.php">Employee List by Role with Total Number of Infected</a>
</h3>
<h3>
<a href="/employees_never_infected.php">Employee List by Role with Total Number of Never Infected</a>
</h3>
<h3>
<a href="/province.php">List Info by Province</a>
</h3>



<hr class="solid">
      <h3>Employees at specific facility with secondary residences</h3>
      <form action="/employee_specific_facility.php" style="margin-bottom:22px;">
        <label for="FID">Facility ID:</label>
        <input type="text" id="FID" name="FID"><br><br>
        <input type="submit" value="List Employees">
      </form>

<hr class="solid">
      <h3>Employee schedule for specific timeframe</h3>
      <form action="/employee_schedules.php" style="margin-bottom:22px;">
        <label for="EID">Employee ID:</label>
        <input type="text" id="EID" name="EID"><br><br>
        <label for="startdate">Start Date:</label>
        <input type="date" id="startdate" name="startdate"><br><br>
        <label for="enddate">End Date:</label>
        <input type="date" id="enddate" name="enddate"><br><br>
        <input type="submit" value="View Schedules">
      </form>

<hr class="solid">
      <h3>People living with a given employee </h3>
      <form action="/lives_with_employee.php" style="margin-bottom:22px;">
        <label for="EID2">Employee ID:</label>
        <input type="text" id="EID2" name="EID2"><br><br>
        <input type="submit" value="List Roomates">
      </form>

<hr class="solid">
      <h3>Emails generated for given facility</h3>
      <form action="/facility_emails.php" style="margin-bottom:22px;">
        <label for="FID2">Facility ID:</label>
        <input type="text" id="FID2" name="FID2"><br><br>
        <label for="startdate1">Start Date:</label>
        <input type="date" id="startdate1" name="startdate1"><br><br>
        <label for="enddate1">End Date:</label>
        <input type="date" id="enddate1" name="enddate1"><br><br>
        <input type="submit" value="List Emails">
      </form>

<hr class="solid">
      <h3>Employees with at least 3 secondary residences and on schedule in past 4 weeks</h3>
      <form action="/employees_three_residences.php" style="margin-bottom:22px;">
        <label for="FID3">Facility ID:</label>
        <input type="text" id="FID3" name="FID3"><br><br>
        <input type="submit" value="View Nurses">
      </form>




    </hr>


<?php
require('mysql_init.php');
$mysqli->close();
?>

</body>

</html>