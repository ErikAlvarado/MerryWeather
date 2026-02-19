INSERT INTO dbo.gender (description) VALUES('Hombre'),('Mujer'), ('Otros')
INSERT INTO dbo.role (description) VALUES('admin'), ('Cliente')

SELECT * FROM dbo.users

DROP TABLE dbo.tinacos

CREATE TABLE dbo.tinacos (
idTinaco INT PRIMARY KEY IDENTITY(1,1) NOT NULL,
description VARCHAR(150) NOT NULL,
capacidad INT NOT NULL,
idUsers INT,
CONSTRAINT FK_tinacoUsers FOREIGN KEY (idUsers)
REFERENCES dbo.users(idUser)
)

INSERT INTO dbo.tinacos(description, capacidad, idUsers) VALUES ('Rotoplas mas grande', 550, 2)

SELECT * FROM dbo.tinacos