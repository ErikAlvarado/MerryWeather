let db;
const request = indexedDB.open("MerryWeather", 1);

request.onupgradeneeded = function(event) {
    const database = event.target.result;
    const storage = database.createObjectStore("tanks", { keyPath: "idTank" });
    storage.createIndex("Descripcion", "description", { unique: false });
    console.log("IndexedDB: Estructura creada.");
};

request.onsuccess = function(event) {
    db = event.target.result;
    console.log("IndexedDB: Conexión establecida.");
    saveTanksToIndexedDB();
};

request.onerror = function(event) {
    console.error("IndexedDB Error:", event.target.errorCode);
};

function saveTanksToIndexedDB() {
    if (typeof tanksfrom === 'undefined' || !tanksfrom || !db) {
        console.warn("No hay datos disponibles para sincronizar.");
        return;
    }

    const transaction = db.transaction(["tanks"], "readwrite");
    const storage = transaction.objectStore("tanks");

    tanksfrom.forEach(tank => {
        const register = {
            idTank: parseInt(tank.idTank),
            description: tank.description,
            capcity: tank.capcity,
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