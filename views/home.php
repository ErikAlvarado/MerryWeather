<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MW MX</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<?php
include 'layout/header.php';
?>
<!-- HERO PARALLAX -->

<section class="hero">
    <div class="hero-overlay">
        <h1>Monitoreo de Tinacos</h1>
        <p>Sistema inteligente con Arduino y sensores</p>
    </div>
</section>

<!-- CONTENIDO -->
<section class="home-content">
    <h2>Monitoreo Inteligente de Nivel de Agua</h2>
    <p>
        Ofrecemos soluciones tecnológicas para el control y monitoreo del nivel de agua en tinacos y depósitos. 
        Nuestro sistema permite supervisar el nivel de agua en tiempo real y generar alertas automáticas para prevenir 
        desbordamientos, desperdicio de agua o falta de suministro.
        
        Diseñado para hogares, edificios y pequeñas empresas, nuestro sistema optimiza el uso del agua mediante sensores 
        de alta precisión y alertas inteligentes.
    </p>
    <h2>Nuestra solución</h2>
    <p>
        Nuestro sistema de monitoreo utiliza sensores de distancia de alta precisión y un controlador inteligente que analiza 
        constantemente el nivel del agua dentro del depósito.
        
        La información se muestra en una pantalla de monitoreo y el sistema puede activar alertas cuando el nivel alcanza 
        valores críticos.
        
        Esto permite a los usuarios mantener un control constante del suministro de agua sin necesidad de revisiones manuales.
    </p>
    <p>
En muchos hogares y edificios, el control del nivel de agua en los tinacos se realiza de forma manual o no se supervisa 
constantemente, lo que puede ocasionar diversos problemas:
</p>

<ul>
    <li>Desbordamiento del tanque</li> <br>
    <li>Desperdicio de agua</li> <br>
    <li>Falta de agua en momentos críticos</li> <br>
    <li>Daños en infraestructura por exceso de agua</li> <br>
</ul>

<p>
Nuestra tecnología permite prevenir estos problemas mediante monitoreo automático y alertas en tiempo real.
</p>
<img src="../assets/img/Estadisticas.png" alt="Estadísticas del sistema" width="800" >
</section>
<script src="../assets/js/hero-parallax.js"></script>
    <div>
        <!-- AUN ESTA EN CONTSTRUCCION.... -->
    </div>
</body>
</html>