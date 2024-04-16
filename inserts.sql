USE HFESTS;
-- Addresses
INSERT INTO Address (AddressID, StreetAddress, City, Province, PostalCode) VALUES
(1, '123 Main St', 'Anytown', 'Province1', 'A1B 2C3'),
(2, '456 Elm St', 'Othertown', 'Province2', 'X4Y 5Z6'),
(3, '789 Oak St', 'Sometown', 'Province3', 'P7Q 8R9'),
(4, '101 Pine St', 'Anothertown', 'Province4', 'M1N 2O3'),
(5, '321 Maple Ave', 'Yetanothertown', 'Province5', 'K4L 5M6'),
(6, '555 Cedar Rd', 'Lasttown', 'Province6', 'T9U 1V2'),
(7, '777 Beach Blvd', 'Seasidetown', 'Province7', 'S8T 9U0'),
(8, '888 River Rd', 'Rivertown', 'Province8', 'R1V 2W3'),
(9, '999 Mountain Ave', 'Mountaintown', 'Province9', 'M4X 5Y6'),
(10, '101 Forest Lane', 'Foresttown', 'Province10', 'F7Z 8A9'),
(11, '102 Forest Lane', 'Foresttown', 'Province10', 'F8Z 8A9');

-- Facilities
INSERT INTO Facilities (FacilityID, FacilityName, AddressID, PhoneNumber, WebAddress, FacilityType, Capacity) VALUES
(1, 'Anytown General Hospital', 1, '123-456-7890', 'www.anytownhospital.com', 'Hospital', 200),
(2, 'Othertown Medical Center', 2, '987-654-3210', 'www.othertownmedcenter.com', 'Medical Center', 150),
(3, 'Sometown Community Clinic', 3, '111-222-3333', 'www.sometownclinic.com', 'Clinic', 100),
(4, 'Anothertown Urgent Care', 4, '444-555-6666', 'www.anothertownurgentcare.com', 'Urgent Care', 75),
(5, 'Yetanothertown Rehabilitation Center', 5, '777-888-9999', 'www.rehabcenter.com', 'Rehabilitation Center', 120),
(6, 'Lasttown Medical Laboratory', 6, '123-456-7890', 'www.lasttownmedlab.com', 'Medical Laboratory', 50),
(7, 'Seasidetown Emergency Center', 7, '777-111-2222', 'www.seasidetownemergency.com', 'Emergency Center', 100),
(8, 'Rivertown Surgery Center', 8, '888-333-4444', 'www.rivertownsurgery.com', 'Surgery Center', 50),
(9, 'Mountaintown Nursing Home', 9, '999-555-6666', 'www.mountaintownnursinghome.com', 'Nursing Home', 150),
(10, 'Foresttown Dental Clinic', 10, '101-777-8888', 'www.foresttowndentalclinic.com', 'Dental Clinic', 75);

-- Residence
INSERT INTO Residence (ResidenceID, AddressID, PhoneNumber, ResidenceType, NumberOfBedrooms,IsSecondaryResidence) VALUES
(1, 1, '111-222-3333', 'Apartment',2, 'N'),
(2, 2, '444-555-6666', 'House', 3, 'N'),
(3, 3, '333-444-5555', 'Condo', 1, 'N'),
(4, 4, '555-666-7777', 'Apartment', 3, 'N'),
(5, 5, '888-999-0000', 'House', 4, 'N'),
(6, 6, '111-222-3333', 'Townhouse', 2, 'N'),
(7, 7, '111-333-4444', 'Apartment', 2, 'N'),
(8, 8, '222-444-5555', 'Condo', 1, 'N'),
(9, 9, '333-555-6666', 'House', 4, 'N'),
(10, 10, '444-666-7777', 'Apartment', 2, 'N'),
(11, 11, '424-666-7777', 'Apartment', 2, 'Y');

-- Persons
INSERT INTO Persons (SSN, FirstName, LastName, DateOfBirth, MedicareCardNumber, PhoneNumber, ResidenceID, Citizenship, Email, Occupation, PrimaryResidence) VALUES
('123-45-6789', 'John', 'Doe', '1980-05-10', 'MC123456', '777-888-9999', 1, 'Canadian', 'johndoe@example.com', 'Doctor', 'Y'),
('987-65-4321', 'Jane', 'Smith', '1990-08-15', 'MC987654', '111-222-3333', 2, 'American', 'janesmith@example.com', 'Nurse', 'Y'),
('111-22-3333', 'Alice', 'Johnson', '1975-08-20', 'MC111222', '123-456-7890', 3, 'Canadian', 'alicejohnson@example.com', 'Psychologist', 'Y'),
('222-33-4444', 'Bob', 'Williams', '1988-03-15', 'MC222333', '234-567-8901', 4, 'American', 'bobwilliams@example.com', 'Paramedic', 'Y'),
('333-44-5555', 'Charlie', 'Brown', '1995-11-25', 'MC333444', '345-678-9012', 5, 'British', 'charliebrown@example.com', 'Physical Therapist', 'Y'),
('444-55-6666', 'David', 'Miller', '1982-02-05', 'MC444555', '456-789-0123', 6, 'Australian', 'davidmiller@example.com', 'Lab Technician', 'Y'),
('555-66-7777', 'Emily', 'Brown', '1985-12-01', 'MC555666', '555-777-8888', 7, 'Canadian', 'emilybrown@example.com', 'Surgeon', 'Y'),
('666-77-8888', 'Michael', 'Johnson', '1970-09-18', 'MC666777', '666-888-9999', 8, 'American', 'michaeljohnson@example.com', 'Dentist', 'Y'),
('777-88-9999', 'Olivia', 'Wilson', '1992-06-30', 'MC777888', '777-999-0000', 9, 'British', 'oliviawilson@example.com', 'Nurse Practitioner', 'Y'),
('888-99-0000', 'Sophia', 'Martinez', '1998-03-12', 'MC888999', '888-000-1111', 10, 'Australian', 'sophiamartinez@example.com', 'Dental Hygienist', 'Y'),
('999-99-0000', 'Ron', 'Martinez', '1998-04-12', 'MC888992', '887-000-1111', 10, 'Australian', 'ronmartinez@example.com', 'Doctor', 'Y'),
('999-99-9000', 'Kon', 'Partinez', '1998-07-12', 'MC888993', '887-000-1111', 10, 'Australian', 'konpartinez@example.com', 'Doctor', 'Y');
('123-12-1234', 'Doug', 'Shumer', '1970-03-05', 'MC325444', '874-775-6622', '3', 'American', 'doug.shumer@outlook.com', 'General Manager', 'Y')

-- Employees
INSERT INTO Employees (EmployeeID, SSN, EmployeeRole, StartDate, EndDate, FacilityID) VALUES
(1, '123-45-6789', 'Doctor', '2020-01-15', NULL, 1),
(2, '987-65-4321', 'Nurse', '2020-03-20', NULL, 2),
(3, '111-22-3333', 'Psychologist', '2020-02-25', NULL, 3),
(4, '222-33-4444', 'Paramedic', '2020-04-10', NULL, 4),
(5, '333-44-5555', 'Physical Therapist', '2020-06-15', NULL, 5),
(6, '444-55-6666', 'Lab Technician', '2020-08-20', NULL, 6),
(7, '555-66-7777', 'Surgeon', '2020-01-01', NULL, 7),
(8, '666-77-8888', 'Dentist', '2020-02-15', NULL, 8),
(9, '777-88-9999', 'Nurse Practitioner', '2020-03-20', NULL, 9),
(10, '888-99-0000', 'Dental Hygienist', '2020-04-25', NULL, 10),
(11, '999-99-0000', 'Doctor', '2020-04-26', NULL, 10),
(12, '999-99-9000', 'Doctor', '2020-03-27', NULL, 10);
(13, '123-12-1234', 'General Manager', '2020-02-01', NULL, '1')

-- WorksAt
INSERT INTO WorksAt (EmployeeID, FacilityID, StartDate, EndDate) VALUES
(1, 1, '2020-01-15', NULL),
(1, 2, '2020-02-15', NULL),
(2, 2, '2020-03-20', NULL),
(2, 3, '2021-03-20', NULL),
(3, 3, '2020-02-25', NULL),
(4, 4, '2020-04-10', NULL),
(5, 5, '2020-06-15', NULL),
(6, 6, '2020-08-20', NULL),
(7, 7, '2020-01-01', NULL),
(8, 8, '2020-02-15', NULL),
(9, 9, '2020-03-20', NULL),
(10, 10, '2020-04-25', NULL),
(11, 10, '2020-04-26', NULL),
(12, 10, '2020-03-27', NULL);
(13, 1, '2020-02-01', NULL)

-- LivesAt
INSERT INTO LivesAt (EmployeeID, AddressID, IsPrimary) VALUES 
(1, 1, 'Y'),
(2, 1, 'N'),
(3, 3, 'Y'),
(4, 3, 'N'),
(5, 5, 'Y'),
(6, 6,  'Y'),
(7, 7,  'Y'),
(8, 8,  'Y'),
(9, 9,  'Y'),
(10, 10, 'Y'),
(11, 10, 'Y'),
(11, 11, 'N'),
(9, 11,  'N'),
(11, 3, 'N'),
(11, 4, 'N'),
(11, 5, 'N'),
(12, 10,'Y');
(1, 1, 'Y'),
(2, 2, 'Y');
(1, 3, 'N');

INSERT INTO Relationships (RelationshipID, RelationshipType, EmployeeID, PersonSSN) VALUES
(1, 'Supervisor', 1, '987-65-4321'),
(2, 'Colleague', 2, '123-45-6789'),
(3, 'Colleague', 3, '444-55-6666'),
(4, 'Supervisor', 4, '111-22-3333'),
(5, 'Colleague', 5, '666-77-8888'),
(6, 'Colleague', 6, '555-66-7777'),
(7, 'Supervisor', 7, '888-99-0000'),
(8, 'Colleague', 8, '777-88-9999'),
(9, 'Supervisor', 9, '999-99-0000'),
(10, 'Husband', 10, '999-99-0000'),
(11, 'Spouse', 11, '888-99-0000'),
(12, 'Friend', 11, '777-88-9999'),
(13, 'Tenant', 12, '999-99-0000');

-- Vaccines
INSERT INTO Vaccines (VaccineID, VaccineType, DoseNumber, VaccinationDate, FacilityID, PersonSSN) VALUES
(1, 'COVID-19', 1, '2023-11-01', 1, '123-45-6789'),
(2, 'COVID-19', 1, '2023-11-15', 2, '987-65-4321'),
(3, 'COVID-19', 1, '2023-11-20', 3, '111-22-3333'),
(4, 'COVID-19', 1, '2023-11-30', 4, '222-33-4444'),
(5, 'COVID-19', 1, '2023-11-05', 5, '333-44-5555'),
(6, 'COVID-19', 1, '2023-11-15', 6, '444-55-6666'),
(7, 'COVID-19', 1, '2023-12-10', 7, '555-66-7777'),
(8, 'COVID-19', 1, '2024-01-20', 8, '666-77-8888'),
(9, 'COVID-19', 1, '2024-02-25', 9, '777-88-9999'),
(10, 'COVID-19', 1, '2024-03-05', 10, '888-99-0000'),
(11, 'COVID-19', 1, '2024-03-20', 10, '999-99-0000'),
(12, 'COVID-19', 1, '2024-03-20', 10, '999-99-9000');

-- Schedules
INSERT INTO Schedules (EmployeeID, FacilityID, ScheduleStart,ScheduleEnd, StartTime, EndTime) VALUES
(1, 2, '2023-12-26', '2023-12-28', '08:00:00', '12:00:00'),
(1, 1, '2024-01-01', '2024-01-02', '08:00:00', '12:00:00'),
(2, 2, '2024-03-28', '2024-04-10', '09:00:00', '17:00:00'), 
(2, 3, '2024-03-27', '2024-04-10', '19:00:00', '20:00:00'), 
(3, 3, '2024-03-11', '2024-03-12', '09:00:00', '15:00:00'),
(4, 4, '2024-03-11', '2024-03-13', '10:00:00', '18:00:00'),
(5, 5, '2024-03-12', '2024-03-14', '08:00:00', '16:00:00'),
(6, 6, '2024-03-12', '2024-03-14', '08:30:00', '12:30:00'),
(7, 7, '2024-03-13', '2024-03-15', '08:00:00', '12:00:00'),
(8, 8, '2024-03-13', '2024-03-15', '10:00:00', '16:00:00'),
(9, 9, '2024-03-14', '2024-03-17', '09:00:00', '17:00:00'),
(10, 10, '2024-03-31', '2024-04-01', '09:00:00', '17:00:00'),
(11, 10, '2024-03-21', '2024-04-01', '09:00:00', '17:00:00'),
(12, 10, '2024-03-21', '2024-04-01', '09:00:00', '17:00:00');

-- Infections
INSERT INTO Infections (InfectionID, InfectionType, InfectionDate, PersonSSN) VALUES
(1, 'COVID-19', '2023-12-28', '987-65-4321'), 
(2, 'Flu', '2024-02-10', '123-45-6789'),
(3, 'COVID-19', '2024-03-30', '222-33-4444'),
(4, 'Flu', '2024-02-20', '111-22-3333'),
(5, 'COVID-19', '2024-04-01', '333-44-5555'),
(6, 'COVID-19', '2024-04-02', '444-55-6666'),
(7, 'COVID-19', '2024-03-10', '666-77-8888'),
(8, 'Flu', '2024-02-15', '555-66-7777'),
(9, 'COVID-19', '2024-04-03', '777-88-9999'),
(10, 'COVID-19', '2024-04-05', '888-99-0000'),
(11, 'COVID-19', '2024-04-05', '987-65-4321'),
(12, 'COVID-19', '2024-04-05', '999-99-9000');

