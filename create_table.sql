CREATE TABLE IF NOT EXISTS converter.currency (
  id int(11) NOT NULL PRIMARY KEY,
  CharCode varchar(250) NOT NULL,
  Name varchar(250) NOT NULL,
  Value float (11) NOT NULL,
  currentDate varchar (250) NOT NULL
);