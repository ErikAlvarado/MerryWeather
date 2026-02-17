CREATE DATABASE merryweather;
 
use merryweather;
 
CREATE TABLE gender(
idGender INT PRIMARY KEY IDENTITY(1,1),
description VARCHAR(50) NOT NULL
);

CREATE TABLE role(
idRole INT PRIMARY KEY IDENTITY(1,1),
description VARCHAR(50) NOT NULL
);
 
CREATE TABLE users(
idUser INT PRIMARY KEY IDENTITY(1, 1),
name VARCHAR(50) NOT NULL,
email VARCHAR(150) UNIQUE NOT NULL,
passwordHash VARBINARY(MAX),
dateRegistration DATETIME DEFAULT GETDATE(),
idGender INT,
idRole INT,
 
CONSTRAINT FK_UserGener FOREIGN KEY (idGender)
REFERENCES gender(idGender),

CONSTRAINT FK_UserRole FOREIGN KEY (idRole)
REFERENCES role(idRole)
);