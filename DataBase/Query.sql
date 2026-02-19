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
passwordHash VARCHAR(255),
dateRegistration DATETIME DEFAULT GETDATE(),
idGender INT,
idRole INT,
 
CONSTRAINT FK_UserGener FOREIGN KEY (idGender)
REFERENCES gender(idGender),

CONSTRAINT FK_UserRole FOREIGN KEY (idRole)
REFERENCES role(idRole)
);


CREATE TABLE water_tank(
idTank INT PRIMARY KEY IDENTITY(1,1),
description VARCHAR(150),
capcity DECIMAL(10,2),
location VARCHAR(150),
installation_date DATE,
idUser INT NOT NULL,

CONSTRAINT FK_water_tank_users
FOREIGN KEY(idUser) REFERENCES users(idUser)
);