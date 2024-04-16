CREATE database HFESTS;
USE HFESTS;

CREATE TABLE Address (
    AddressID INT PRIMARY KEY,
    StreetAddress VARCHAR(255),
    City VARCHAR(50),
    Province VARCHAR(50),
    PostalCode VARCHAR(10)
);

CREATE TABLE Facilities (
  FacilityID INT PRIMARY KEY,
  FacilityName VARCHAR(255),
  AddressID INT, -- Now references AddressID 
  PhoneNumber VARCHAR(15),
  WebAddress VARCHAR(255),
  FacilityType VARCHAR(50),
  Capacity INT,
  FOREIGN KEY (AddressID) REFERENCES Address(AddressID)
);

CREATE TABLE Residence (
  ResidenceID INT PRIMARY KEY, 
  AddressID INT, -- Now references AddressID 
  PhoneNumber VARCHAR(15),
  ResidenceType VARCHAR(50),
  NumberOfBedrooms INT,
  IsSecondaryResidence CHAR(1) NOT NULL CHECK (IsSecondaryResidence  IN ('Y', 'N')),
  FOREIGN KEY (AddressID) REFERENCES Address(AddressID)
);

CREATE TABLE Persons (
  SSN VARCHAR(15) PRIMARY KEY,
  FirstName VARCHAR(50),
  LastName VARCHAR(50),
  DateOfBirth DATE,
  MedicareCardNumber VARCHAR(20) NOT NULL UNIQUE,
  PhoneNumber VARCHAR(15),   
  ResidenceID INT,  -- Now references AddressID 
  Citizenship VARCHAR(50),
  Email VARCHAR(255) UNIQUE,
  Occupation VARCHAR(50),
  PRIMARYResidence CHAR(1) NOT NULL CHECK (PrimaryResidence IN ('Y', 'N')),
  FOREIGN KEY (ResidenceID) REFERENCES Address(AddressID)
);

CREATE TABLE Employees (
    EmployeeID INT PRIMARY KEY,
    SSN VARCHAR(15) UNIQUE,
    EmployeeRole VARCHAR(50),
    StartDate DATE,
    EndDate DATE,
    FacilityID INT,
    FOREIGN KEY (SSN) REFERENCES Persons(SSN),
    FOREIGN KEY (FacilityID) REFERENCES Facilities(FacilityID)
);

CREATE TABLE WorksAt (
    EmployeeID INT NOT NULL,
    FacilityID INT NOT NULL,
    StartDate DATE NOT NULL,
    EndDate DATE ,
    PRIMARY KEY (EmployeeID, FacilityID, StartDate),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID),
    FOREIGN KEY (FacilityID) REFERENCES Facilities(FacilityID),
    CONSTRAINT chk_enddate CHECK (EndDate IS NULL OR EndDate >= StartDate)
);

CREATE TABLE LivesAt (
  EmployeeID INT NOT NULL,
  AddressID INT NOT NULL, 
  IsPrimary CHAR(1) NOT NULL CHECK (IsPrimary IN ('Y', 'N')), -- Indicates primary residence
  PRIMARY KEY (EmployeeID, AddressID), 
  FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID),
  FOREIGN KEY (AddressID) REFERENCES Address(AddressID)
);

CREATE TABLE Schedules (
    EmployeeID INT NOT NULL,
    FacilityID INT NOT NULL,
    ScheduleStart DATE NOT NULL,
    ScheduleEnd DATE NOT NULL,
    StartTime TIME NOT NULL,
    EndTime TIME NOT NULL,
    PRIMARY KEY (EmployeeID, FacilityID,  ScheduleStart, ScheduleEnd, StartTime),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID),
    FOREIGN KEY (FacilityID) REFERENCES Facilities(FacilityID),
    CONSTRAINT chk_endtime CHECK (EndTime IS NULL OR EndTime > StartTime),
    CONSTRAINT chk_dates CHECK ( ScheduleStart <= ScheduleEnd)
);


CREATE TABLE EmailLog (
    LogID INT PRIMARY KEY AUTO_INCREMENT,
    `Date` DATETIME NOT NULL,
    Sender VARCHAR(100) NOT NULL,
    Receiver VARCHAR(100) NOT NULL,
    `Subject` VARCHAR(100) NOT NULL,
    Body TEXT NOT NULL
); 

CREATE TABLE Relationships (
    RelationshipID INT PRIMARY KEY,
    RelationshipType VARCHAR(50),
    EmployeeID INT,
    PersonSSN VARCHAR(15),
    FOREIGN KEY (EmployeeID) REFERENCES Employees(EmployeeID),
    FOREIGN KEY (PersonSSN) REFERENCES Persons(SSN)
);

CREATE TABLE Vaccines (
    VaccineID INT PRIMARY KEY,
    VaccineType VARCHAR(50),
    DoseNumber INT,
    VaccinationDate DATE,
    FacilityID INT,
    PersonSSN VARCHAR(15),
    FOREIGN KEY (FacilityID) REFERENCES Facilities(FacilityID),
    FOREIGN KEY (PersonSSN) REFERENCES Persons(SSN)
);

CREATE TABLE Infections (
    InfectionID INT PRIMARY KEY,
    InfectionType VARCHAR(50),
    InfectionDate DATE,
    PersonSSN VARCHAR(15),
    FOREIGN KEY (PersonSSN) REFERENCES Persons(SSN)
);


DELIMITER $$

CREATE TRIGGER enforce_two_hour_schedule_gap
BEFORE INSERT ON Schedules
FOR EACH ROW
BEGIN
    DECLARE conflictFound BOOL DEFAULT FALSE;
    DECLARE existingEndTime TIME;

    -- Check for conflicts across all facilities within the scheduled period
    SELECT MAX(EndTime) INTO existingEndTime
    FROM Schedules
    WHERE EmployeeID = NEW.EmployeeID
        AND ((NEW.ScheduleStart = ScheduleStart AND NEW.StartTime < EndTime AND NEW.EndTime > StartTime) -- Within the same day
             OR (NEW.ScheduleStart > ScheduleStart AND NEW.ScheduleStart < ScheduleEnd) -- Starting after the scheduled period starts
             OR (NEW.ScheduleEnd = ScheduleEnd AND NEW.EndTime > StartTime)); -- Ending before the scheduled period ends

    IF existingEndTime IS NOT NULL AND TIME_TO_SEC(TIMEDIFF(NEW.StartTime, existingEndTime)) < 7200 THEN 
        SET conflictFound = TRUE;
    END IF;

    IF conflictFound THEN
        SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Schedule conflict: Must have at least a two-hour gap between assignments';
    END IF;
END$$

-- Trigger: Prevent Scheduling Infected Nurse/Doctor
CREATE TRIGGER prevent_scheduling_infected 
BEFORE INSERT ON Schedules
FOR EACH ROW
BEGIN
    IF EXISTS (
        SELECT 1 FROM Infections i 
        JOIN Employees e ON e.SSN = i.PersonSSN
        WHERE i.InfectionType LIKE 'COVID%' 
            AND e.EmployeeID = NEW.EmployeeID 
            AND e.EmployeeRole IN ('Doctor', 'Nurse')
            AND NEW.ScheduleStart BETWEEN i.InfectionDate AND DATE_ADD(i.InfectionDate, INTERVAL 14 DAY)
    ) THEN
        SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Cannot schedule infected doctor/nurse within two weeks of infection';
    END IF;
END$$

-- Trigger: Prevent Scheduling Unvaccinated (valid)
CREATE TRIGGER prevent_scheduling_unvaccinated
BEFORE INSERT ON Schedules
FOR EACH ROW
BEGIN
    IF NOT EXISTS (
        SELECT 1 FROM Vaccines v
        JOIN Employees e ON e.SSN = v.PersonSSN
        WHERE v.VaccineType LIKE '%COVID%' 
            AND e.EmployeeID = NEW.EmployeeID
            AND NEW.ScheduleStart <= DATE_ADD(v.VaccinationDate, INTERVAL 6 MONTH) 
    ) THEN
        SIGNAL SQLSTATE '45000' 
            SET MESSAGE_TEXT = 'Cannot schedule employee without recent (6 months) COVID-19 vaccination';
    END IF;
END$$

-- Trigger: Covid Schedule Cancel + Covid Notificaiton
CREATE TRIGGER covid_notification 
AFTER INSERT ON Infections
FOR EACH ROW
BEGIN
    DECLARE tempSSN VARCHAR(15); /* Or suitable string type */
    SET tempSSN = NEW.PersonSSN;
    
    IF NEW.InfectionType = 'COVID-19' THEN
        -- Email to infected employee
        INSERT INTO EmailLog (`Date`, Sender, Receiver, `Subject`, Body)
        SELECT NOW(), 
               f.FacilityName, 
               p.Email,
               'Assignment Cancellation Notice', 
               'Your assignments for the next two weeks have been canceled due to your COVID-19 infection. Please follow health guidelines and inform your close contacts.'
        FROM Persons p
        INNER JOIN Employees e ON p.SSN = e.SSN
        INNER JOIN WorksAt w ON e.EmployeeID = w.EmployeeID
        INNER JOIN Facilities f ON w.FacilityID = f.FacilityID
        INNER JOIN Schedules s ON e.EmployeeID = s.EmployeeID 
        WHERE p.SSN = NEW.PersonSSN  
          AND s.ScheduleStart >= NEW.InfectionDate
          AND s.ScheduleStart < DATE_ADD(NEW.InfectionDate, INTERVAL 14 DAY);
      
        -- Emails to employees who shared a schedule 
        INSERT INTO EmailLog (`Date`, Sender, Receiver, `Subject`, Body)
        SELECT NOW(), 
               f.FacilityName, 
               p.Email, 
               'Warning',
               'One of your colleagues with whom you worked in the past two weeks has been infected with COVID-19. Please monitor your health and take necessary precautions.'
        FROM Schedules s
        INNER JOIN Employees e ON s.EmployeeID = e.EmployeeID
        INNER JOIN Persons p ON e.SSN = p.SSN
        INNER JOIN WorksAt w ON e.EmployeeID = w.EmployeeID
        INNER JOIN Facilities f ON w.FacilityID = f.FacilityID
        WHERE w.EmployeeID = (SELECT EmployeeID FROM Employees WHERE SSN = NEW.PersonSSN)
          AND s.ScheduleStart >= DATE_SUB(NEW.InfectionDate, INTERVAL 14 DAY)
          AND s.ScheduleStart <= NEW.InfectionDate
          AND ( 
            (s.StartTime < (SELECT EndTime FROM Schedules WHERE EmployeeID = (SELECT EmployeeID FROM Employees WHERE SSN = NEW.PersonSSN) AND ScheduleStart = s.ScheduleStart) 
             AND s.EndTime > (SELECT StartTime FROM Schedules WHERE EmployeeID = (SELECT EmployeeID FROM Employees WHERE SSN = NEW.PersonSSN) AND ScheduleStart = s.ScheduleStart) 
            )
            OR ( 
              (SELECT StartTime FROM Schedules WHERE EmployeeID = (SELECT EmployeeID FROM Employees WHERE SSN = NEW.PersonSSN) AND ScheduleStart = s.ScheduleStart) < s.EndTime
               AND (SELECT EndTime FROM Schedules WHERE EmployeeID = (SELECT EmployeeID FROM Employees WHERE SSN = NEW.PersonSSN) AND ScheduleStart = s.ScheduleStart) > s.StartTime
            )
        );
        
        DELETE FROM Schedules
        WHERE EmployeeID = (SELECT EmployeeID FROM Employees WHERE SSN = tempSSN) 
        AND ScheduleStart >= NEW.InfectionDate 
        AND ScheduleStart < DATE_ADD(NEW.InfectionDate, INTERVAL 14 DAY);
    END IF;
END$$
DELIMITER ;
