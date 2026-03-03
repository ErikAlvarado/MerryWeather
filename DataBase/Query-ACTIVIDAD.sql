use merryweather
select * from  dbo.gender
select * from  dbo.role

DECLARE @i INT = 1;
DECLARE @idUserActual INT;

WHILE @i <= 40
BEGIN
    -- Insertar Usuario
    INSERT INTO users (name, email, passwordHash, idGender, idRole)
    VALUES (
        CONCAT('Usuario ', @i), 
        CONCAT('user', @i, '@merryweather.com'), 
        'hash_password_123', 
        (ABS(CHECKSUM(NEWID())) % 3) + 1, -- Aleatorio entre 1, 2 y 3 (Hombre, Mujer, Other)
        CASE WHEN @i <= 2 THEN 2 ELSE 1 END -- Los primeros 2 son admin (ID 2), el resto user (ID 1)
    );

    SET @idUserActual = SCOPE_IDENTITY();

    -- Insertar Tinaco para cada usuario
    INSERT INTO water_tank (description, capcity, location, installation_date, idUser)
    VALUES (
        CONCAT('Tinaco ', @i),
        CASE WHEN (@i % 2 = 0) THEN 1100.00 ELSE 750.00 END,
        'Ubicación Residencial',
        GETDATE(),
        @idUserActual
    );

    SET @i = @i + 1;
END;



INSERT INTO water_level_log (current_level, water_quality_score, idTank, reading_date)
SELECT 
    (T.capcity * (ABS(CHECKSUM(NEWID())) % 100) / 100),
    (ABS(CHECKSUM(NEWID())) % 20) + 80,
    T.idTank,
    DATEADD(HOUR, - (ABS(CHECKSUM(NEWID())) % 24), GETDATE())
FROM water_tank T;

DROP FUNCTION fn_calcularPorcentajeAgua
-- Función para calcular el porcentaje de agua disponible
CREATE FUNCTION fn_calcularPorcentajeAgua (
    @capacidadTotal DECIMAL(10,2),
    @lecturaActual DECIMAL(10,2)
)
RETURNS DECIMAL(5,2)
AS
BEGIN
    DECLARE @porcentaje DECIMAL(5,2);
    
    -- Evitar división por cero si la capacidad no está definida
    IF @capacidadTotal = 0 OR @capacidadTotal IS NULL
        SET @porcentaje = 0;
    ELSE
        -- Cálculo: (Lectura / Capacidad) * 100
        SET @porcentaje = (@lecturaActual / @capacidadTotal) * 100;

    -- Asegurar que el porcentaje no exceda el 100% por errores de sensor
    IF @porcentaje > 100 SET @porcentaje = 100;
    IF @porcentaje < 0 SET @porcentaje = 0;

    RETURN @porcentaje;
END;

SELECT 
    U.name AS [Nombre Usuario],
    G.description AS [Género],
    R.description AS [Rol],
    T.description AS [Tinaco],
    L.current_level AS [Nivel Litros],
    dbo.fn_calcularPorcentajeAgua(T.capcity, L.current_level) AS [Porcentaje %]
FROM users U
JOIN gender G ON U.idGender = G.idGender
JOIN role R ON U.idRole = R.idRole
JOIN water_tank T ON U.idUser = T.idUser
JOIN water_level_log L ON T.idTank = L.idTank;







--================================================================================================================
--                          PROCEUDRE
--================================================================================================================
-- Procedimiento para registrar lecturas de sensores de forma segura
use merryweather
CREATE PROCEDURE sp_RegistrarMonitoreo
    @idTank INT,
    @nivel DECIMAL(10,2),
    @calidad INT
AS
BEGIN
    SET NOCOUNT ON;
    DECLARE @capacidadMax DECIMAL(10,2);

    -- 1. Obtener la capacidad máxima del tinaco para validar
    SELECT @capacidadMax = capcity FROM water_tank WHERE idTank = @idTank;

    -- 2. Validación de existencia del tinaco
    IF @capacidadMax IS NULL
    BEGIN
        PRINT 'Error: El tinaco especificado no existe.';
        RETURN;
    END

    -- 3. Validación de integridad de datos (Reglas de negocio)
    IF @nivel < 0 OR @nivel > @capacidadMax
    BEGIN
        PRINT 'Error: El nivel de agua es inválido (negativo o excede la capacidad).';
        RETURN;
    END

    IF @calidad < 0 OR @calidad > 100
    BEGIN
        PRINT 'Error: El puntaje de calidad debe estar entre 0 y 100.';
        RETURN;
    END

    -- 4. Inserción automatizada si todo es correcto
    INSERT INTO water_level_log (current_level, water_quality_score, reading_date, idTank)
    VALUES (@nivel, @calidad, GETDATE(), @idTank);

    PRINT 'Lectura registrada exitosamente para el tinaco ' + CAST(@idTank AS VARCHAR);
END;   

SELECT * FROM water_tank;
EXEC sp_RegistrarMonitoreo 10, 1000, 95;


--================================================================================================================
--                          TRANSACTION
--================================================================================================================
SELECT * FROM users where idUser = 7
-- Procedimiento para eliminar un usuario y todos sus datos vinculados
DECLARE @UserID INT = 7; -- ID del usuario a eliminar como ejemplo

BEGIN TRY
    BEGIN TRANSACTION;

    -- 1. Eliminar primero los logs de todos los tinacos del usuario
    DELETE FROM water_level_log
    WHERE idTank IN (SELECT idTank FROM water_tank WHERE idUser = @UserID);

    -- 2. Eliminar los tinacos del usuario
    DELETE FROM water_tank WHERE idUser = @UserID;

    -- 3. Eliminar al usuario de la tabla principal
    DELETE FROM users WHERE idUser = @UserID;

    -- Si llegamos aquí sin errores, guardamos los cambios
    COMMIT;
    PRINT 'Transacción completada: Usuario y datos vinculados eliminados.';
END TRY
BEGIN CATCH
    -- Si algo falla (ej. error de conexión o restricción), deshacemos todo
    ROLLBACK;
    PRINT 'Error detectado. Se ha realizado un ROLLBACK para proteger la integridad.';
    SELECT ERROR_MESSAGE() AS [Detalle del Error];
END CATCH