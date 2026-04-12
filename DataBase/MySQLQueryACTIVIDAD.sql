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




-- Nuevo codigo

DELIMITER //

CREATE PROCEDURE sp_ObtenerResumenTanques(IN p_idUser INT)
BEGIN
    SELECT 
        t.idTank,
        t.description,
        t.capcity as capacity,
        t.location,
        MAX(l.reading_date) as last_update,
        -- Obtenemos el último nivel registrado
        (SELECT current_level FROM water_level_log WHERE idTank = t.idTank ORDER BY reading_date DESC LIMIT 1) as current_level,
        -- Promedio de calidad
        AVG(l.water_quality_score) as avg_quality,
        -- Usamos tu función para el porcentaje
        fn_calcularPorcentajeAgua(t.capcity, (SELECT current_level FROM water_level_log WHERE idTank = t.idTank ORDER BY reading_date DESC LIMIT 1)) as percentage
    FROM water_tank t
    LEFT JOIN water_level_log l ON t.idTank = l.idTank
    WHERE t.idUser = p_idUser
    GROUP BY t.idTank;
END //

DELIMITER ;


DELIMITER //

CREATE PROCEDURE sp_ObtenerDetalleAnaliticoTanque(IN p_idTank INT)
BEGIN
    -- Declaramos variables para el análisis
    DECLARE v_ultimo_nivel DECIMAL(10,2);
    DECLARE v_penultimo_nivel DECIMAL(10,2);
    DECLARE v_capacidad DECIMAL(10,2);
    DECLARE v_dias_inactivo INT;
    DECLARE v_promedio_consumo_diario DECIMAL(10,2);

    -- 1. Obtener datos básicos y capacidad
    SELECT capcity INTO v_capacidad FROM water_tank WHERE idTank = p_idTank;

    -- 2. Obtener las dos últimas lecturas para ver tendencia inmediata
    SELECT current_level INTO v_ultimo_nivel FROM water_level_log 
    WHERE idTank = p_idTank ORDER BY reading_date DESC LIMIT 1;
    
    SELECT current_level INTO v_penultimo_nivel FROM water_level_log 
    WHERE idTank = p_idTank ORDER BY reading_date DESC LIMIT 1 OFFSET 1;

    -- 3. Calcular días desde la última actualización significativa
    SELECT DATEDIFF(NOW(), MAX(reading_date)) INTO v_dias_inactivo 
    FROM water_level_log WHERE idTank = p_idTank;

    -- 4. Retornar análisis completo
    SELECT 
        t.*,
        v_ultimo_nivel as current_level,
        fn_calcularPorcentajeAgua(t.capcity, v_ultimo_nivel) as percentage,
        -- Lógica de Alertas
        CASE 
            WHEN v_ultimo_nivel < v_penultimo_nivel AND v_ultimo_nivel > 0 AND HOUR(NOW()) BETWEEN 1 AND 5 
                THEN 'Posible Fuga (Consumo Nocturno)'
            WHEN v_ultimo_nivel > v_penultimo_nivel THEN 'Llenado en curso'
            WHEN v_dias_inactivo > 3 THEN 'Inactivo (No hay reportes)'
            WHEN v_ultimo_nivel < (t.capcity * 0.15) THEN 'Nivel Crítico Bajo'
            ELSE 'Normal'
        END as status_eval,
        -- Cálculo de salud del agua (basado en el último log)
        (SELECT water_quality_score FROM water_level_log WHERE idTank = p_idTank ORDER BY reading_date DESC LIMIT 1) as quality
    FROM water_tank t
    WHERE t.idTank = p_idTank;
END //

DELIMITER ;