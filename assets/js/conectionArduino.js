let puerto;
let ultimoGuardado = 0; 
const FRECUENCIA_GUARDADO = 30000;

async function conectionArduino(tankId) {
    try {
        if (!("serial" in navigator)) {
            alert("Tu navegador no soporta la API Web Serial. Usa Chrome o Edge.");
            return;
        }

        puerto = await navigator.serial.requestPort();
        await puerto.open({ baudRate: 9600 });
        
        const decodificadorTexto = new TextDecoderStream();
        const flujoLecturaCerrado = puerto.readable.pipeTo(decodificadorTexto.writable);
        const lector = decodificadorTexto.readable.getReader();

        let textoAcumulado = "";

        while (true) {
            const { value, done } = await lector.read();
            if (done) {
                lector.releaseLock();
                break;
            }
            
            textoAcumulado += value;
            let lineas = textoAcumulado.split('\n');
            textoAcumulado = lineas.pop();
            
            for (let linea of lineas) {
                let numero = parseInt(linea.trim());
                
                if (!isNaN(numero)) {
                    actualizarProgreso(tankId, numero);

                    const ahora = Date.now();
                    if (ahora - ultimoGuardado > FRECUENCIA_GUARDADO) {
                        enviarDatosAlServidor(tankId, numero);
                        ultimoGuardado = ahora;
                    }
                }
            }
        }
    } catch (error) {
        console.error("Error en la conexión Serial:", error);
        alert("No se pudo establecer la conexión. Asegúrate de que el Arduino esté conectado y no esté siendo usado por otro programa (como el Monitor Serie de Arduino IDE).");
    }
}

function actualizarProgreso(id, valor) {
    const barra = document.getElementById(`bar-${id}`);
    const texto = document.getElementById(`text-${id}`);
    
    if (barra && texto) {
        valor = Math.max(0, Math.min(100, valor));
        
        barra.style.width = valor + "%";
        texto.innerText = valor;

        if (valor < 20) {
            barra.style.backgroundColor = "#ff4d4d";
        } else if (valor < 60) {
            barra.style.backgroundColor = "#ffcc00";
        } else {
            barra.style.backgroundColor = "#2196F3";
        }
    }
}

async function enviarDatosAlServidor(idTank, level) {
    const formData = new FormData();
    formData.append('idTank', idTank);
    formData.append('level', level);

    try {
        const respuesta = await fetch('save_log.php', {
            method: 'POST',
            body: formData
        });

        if (respuesta.ok) {
            const msj = await respuesta.text();
            console.log(`[Base de Datos] ID: ${idTank} | Nivel: ${level}% | Servidor: ${msj}`);
        } else {
            console.error("Error al guardar: El servidor respondió con error.");
        }
    } catch (error) {
        console.error("Error de red al intentar guardar en BD:", error);
    }
}