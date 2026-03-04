let db;
const request = indexedDB.open("MerryWeather", 1);

request.onupgradeneeded = function(event) {
    const database = event.target.result;
    // idTank es la llave primaria en tu script de MySQL
    const storage = database.createObjectStore("tanks", { keyPath: "idTank" });
    storage.createIndex("Descripcion", "description", { unique: false });
    console.log("IndexedDB: Estructura creada.");
};

request.onsuccess = function(event) {
    db = event.target.result;
    console.log("IndexedDB: Conexión establecida.");
    
    // Llamamos a la función de guardado
    saveTanksToIndexedDB();
};

request.onerror = function(event) {
    console.error("IndexedDB Error:", event.target.errorCode);
};

function saveTanksToIndexedDB() {
    // Comprobamos si la variable global existe y tiene datos
    if (typeof tanksFromPHP === 'undefined' || !tanksFromPHP || !db) {
        console.warn("No hay datos disponibles para sincronizar.");
        return;
    }

    const transaction = db.transaction(["tanks"], "readwrite");
    const storage = transaction.objectStore("tanks");

    tanksFromPHP.forEach(tank => {
        const register = {
            idTank: parseInt(tank.idTank),
            description: tank.description,
            capcity: tank.capcity, // Coincide con tu script SQL
            location: tank.location,
            installation_date: tank.installation_date,
            idUser: tank.idUser
        };
        
        const putRequest = storage.put(register);
        
        putRequest.onerror = function() {
            console.error("Error al guardar el tinaco:", tank.idTank);
        };
    });

    transaction.oncomplete = function() {
        console.log("Sincronización MySQL -> IndexedDB exitosa.");
    };
}