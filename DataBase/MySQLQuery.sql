CREATE DATABASE IF NOT EXISTS merryweather;
USE merryweather;

CREATE TABLE gender(
    idGender INT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(50) NOT NULL
);

CREATE TABLE role(
    idRole INT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(50) NOT NULL
);

INSERT INTO gender (description) VALUES ('Hombre'), ('Mujer'), ('Otro');
INSERT INTO role (description) VALUES ('User'), ('Admin');

CREATE TABLE users(
    idUser INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(50) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    passwordHash VARCHAR(255),
    dateRegistration DATETIME DEFAULT CURRENT_TIMESTAMP,
    idGender INT,
    idRole INT,
    CONSTRAINT FK_UserGender FOREIGN KEY (idGender) REFERENCES gender(idGender),
    CONSTRAINT FK_UserRole FOREIGN KEY (idRole) REFERENCES role(idRole)
);

CREATE TABLE water_tank(
    idTank INT PRIMARY KEY AUTO_INCREMENT,
    description VARCHAR(150),
    capcity DECIMAL(10,2),
    location VARCHAR(150),
    installation_date DATETIME DEFAULT CURRENT_TIMESTAMP,  
    idUser INT NOT NULL,
    CONSTRAINT FK_water_tank_users FOREIGN KEY(idUser) REFERENCES users(idUser)
);

ALTER TABLE water_tank 
DROP FOREIGN KEY FK_water_tank_users;

ALTER TABLE water_tank 
ADD CONSTRAINT FK_water_tank_users 
FOREIGN KEY (idUser) REFERENCES users(idUser) 
ON DELETE CASCADE;

ALTER TABLE water_tank MODIFY COLUMN installation_date DATETIME DEFAULT CURRENT_TIMESTAMP;

CREATE TABLE water_level_log (
    idLog INT PRIMARY KEY AUTO_INCREMENT,
    current_level DECIMAL(10,2),
    water_quality_score INT,
    reading_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    idTank INT,
    CONSTRAINT FK_log_tank FOREIGN KEY (idTank) REFERENCES water_tank(idTank)
);

-- 1. Primero eliminamos la restricción vieja
ALTER TABLE water_level_log 
DROP FOREIGN KEY FK_log_tank;

-- 2. La volvemos a crear con la instrucción de cascada
ALTER TABLE water_level_log 
ADD CONSTRAINT FK_log_tank 
FOREIGN KEY (idTank) REFERENCES water_tank(idTank) 
ON DELETE CASCADE;