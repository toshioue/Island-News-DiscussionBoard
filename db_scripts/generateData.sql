/* file that has insert statements for our 5 tables */

/* insert into DutySections First with two values*/
/*INSERT INTO DutySections VALUES (1), (2);

/* insert into Midshipmen table second with two rows
    in DB pashword will be hashed using PHP */
/*INSERT INTO Midshipmen (Alpha, Hash, FirstName, LastName, WatchType, Exempt, DutyNumber)
                      VALUES (204824, "samplepswd", "Toshi", "Oue", "ACDO", "No", 1),
                              (204170, "samplepswdha", "Stephane", "Mekoua","CDO", "No", 2);

INSERT INTO Midshipmen (Alpha, Hash, FirstName, LastName, WatchType, Exempt, DutyNumber)
                      Values (204554, "52525rgerg", "Tanner", "Staw", "CMOD", "No", 1),
                              (206111, "76767htbnfhej3o2", "John", "Doe", "CMOD", "No", 2);
/* Insert into Duty_Day Table two rows */
/*INSERT INTO Duty_Day VALUES (DATE '2019-3-28', 1), (DATE '2019-3-29', 2);

/* Insert into UpperWatch and UnderWatch Tables two rows;*/
/*INSERT INTO UpperWatch VALUES (DATE '2019-3-28', 204170, 204824),
                               (DATE '2019-3-29', 204170, 204824);

INSERT INTO UnderWatch VALUES (DATE '2019-3-28','13:00' ,'14:00', 204554 ),
                               (DATE '2019-3-28', '14:00', '15:00', 206111);
*/
INSERT INTO Users (Username, FirstName, LastName, Password) VALUES ('Tosh681', 'Toshi', 'Oue', 'fefefefefefef');
