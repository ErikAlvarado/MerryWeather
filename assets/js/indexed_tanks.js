let db;
const request = indexedDB.open("MerryWeather", 1); 

request.onupgradeneeded = function(event) {
    const DataBase = event.target.result;
    const storage = DataBase.createObjectStore("tanks", { keyPath: "idTank" });
    storage.createIndex("Descripcion", "description", { unique: false });
    
    console.log("Base de datos local preparada");
};

request.onsuccess = function(event) {
    db = event.target.result;
    console.log("Conexión exitosa a IndexedDB");
    
    if (typeof SaveTanks === 'function') {
        SaveTanks();
    }
};

request.onerror = function(event) {
    console.error("Error en IndexedDB:", event.target.errorCode);
};