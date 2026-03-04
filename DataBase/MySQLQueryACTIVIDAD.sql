--==========================================================================================
--Procedimiento
--==========================================================================================
DELIMITER //

CREATE PROCEDURE sp_InsertarDatosPrueba()
BEGIN
    DECLARE i INT DEFAULT 1;
    DECLARE idUserActual INT;

    WHILE i <= 40 DO
        -- Insertar Usuario
        INSERT INTO users (name, email, passwordHash, idGender, idRole)
        VALUES (
            CONCAT('Usuario ', i), 
            CONCAT('user', i, '@merryweather.com'), 
            'hash_password_123', 
            (FLOOR(1 + RAND() * 3)), -- Aleatorio entre 1 y 3
            CASE WHEN i <= 2 THEN 2 ELSE 1 END
        );

        SET idUserActual = LAST_INSERT_ID();

        -- Insertar Tinaco
        INSERT INTO water_tank (description, capcity, location, installation_date, idUser)
        VALUES (
            CONCAT('Tinaco ', i),
            CASE WHEN (i % 2 = 0) THEN 1100.00 ELSE 750.00 END,
            'Ubicacion Residencial',
            CURDATE(),
            idUserActual
        );

        SET i = i + 1;
    END WHILE;
END //

DELIMITER ;

-- Ejecutar el procedimiento para llenar los datos
CALL sp_InsertarDatosPrueba();

-- Insertar logs iniciales
INSERT INTO water_level_log (current_level, water_quality_score, idTank, reading_date)
SELECT 
    (capcity * (FLOOR(RAND() * 100) / 100)),
    (FLOOR(80 + RAND() * 21)),
    idTank,
    DATE_SUB(NOW(), INTERVAL FLOOR(RAND() * 24) HOUR)
FROM water_tank;
--==========================================================================================
--Función de Cálculo de Porcentaje
--==========================================================================================
DELIMITER //

CREATE FUNCTION fn_calcularPorcentajeAgua (
    capacidadTotal DECIMAL(10,2),
    lecturaActual DECIMAL(10,2)
)
RETURNS DECIMAL(5,2)
DETERMINISTIC
BEGIN
    DECLARE porcentaje DECIMAL(5,2);
    
    IF capacidadTotal = 0 OR capacidadTotal IS NULL THEN
        SET porcentaje = 0;
    ELSE
        SET porcentaje = (lecturaActual / capacidadTotal) * 100;
    END IF;

    IF porcentaje > 100 THEN SET porcentaje = 100; END IF;
    IF porcentaje < 0 THEN SET porcentaje = 0; END IF;

    RETURN porcentaje;
END //

DELIMITER ;

-- Consulta de prueba
SELECT 
    U.name AS `Nombre Usuario`,
    G.description AS `Genero`,
    R.description AS `Rol`,
    T.description AS `Tinaco`,
    L.current_level AS `Nivel Litros`,
    fn_calcularPorcentajeAgua(T.capcity, L.current_level) AS `Porcentaje %`
FROM users U
JOIN gender G ON U.idGender = G.idGender
JOIN role R ON U.idRole = R.idRole
JOIN water_tank T ON U.idUser = T.idUser
JOIN water_level_log L ON T.idTank = L.idTank;


--==========================================================================================
-- Procedimiento de Monitoreo
--==========================================================================================
DELIMITER //

CREATE PROCEDURE sp_RegistrarMonitoreo (
    IN p_idTank INT,
    IN p_nivel DECIMAL(10,2),
    IN p_calidad INT
)
BEGIN
    DECLARE v_capacidadMax DECIMAL(10,2);

    SELECT capcity INTO v_capacidadMax FROM water_tank WHERE idTank = p_idTank;

    IF v_capacidadMax IS NULL THEN
        SELECT 'Error: El tinaco no existe' AS Mensaje;
    ELSEIF p_nivel < 0 OR p_nivel > v_capacidadMax THEN
        SELECT 'Error: Nivel invalido' AS Mensaje;
    ELSEIF p_calidad < 0 OR p_calidad > 100 THEN
        SELECT 'Error: Calidad invalida' AS Mensaje;
    ELSE
        INSERT INTO water_level_log (current_level, water_quality_score, reading_date, idTank)
        VALUES (p_nivel, p_calidad, NOW(), p_idTank);
        SELECT CONCAT('Lectura registrada para tinaco ', p_idTank) AS Mensaje;
    END IF;
END //

DELIMITER ;

-- Ejemplo de Transacción (Eliminar Usuario)
SET @UserID = 10;

START TRANSACTION;

-- 1. Eliminar logs
DELETE FROM water_level_log 
WHERE idTank IN (SELECT idTank FROM (SELECT idTank FROM water_tank WHERE idUser = @UserID) AS tmp);

-- 2. Eliminar tinacos
DELETE FROM water_tank WHERE idUser = @UserID;

-- 3. Eliminar usuario
DELETE FROM users WHERE idUser = @UserID;

COMMIT;