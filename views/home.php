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
<h2>Sistema inteligente de monitoreo del nivel de agua</h2>
<p>
El agua es uno de los recursos naturales más importantes para la vida y el
desarrollo de las comunidades. Sin embargo, en muchos hogares y edificios el
control del nivel de agua en los tinacos o depósitos se realiza de forma manual
o simplemente no se supervisa constantemente. Esta situación puede provocar
que el tanque continúe llenándose incluso cuando ya alcanzó su capacidad
máxima.
</p>
<p>
Cuando esto ocurre, el agua comienza a desbordarse y se pierde una cantidad
considerable de este recurso. Además del impacto ambiental que representa el
desperdicio de agua, también pueden presentarse problemas en la infraestructura
del lugar, como humedad o deterioro en las instalaciones.
</p>
<p>
Para atender esta problemática se desarrolló un sistema de monitoreo que
permite supervisar el nivel del agua dentro del tinaco de forma automática.
El sistema utiliza tecnología basada en sensores ultrasónicos, un
microcontrolador Arduino y un sistema de alertas que permite advertir
cuando el nivel del agua está cerca de alcanzar su límite.
</p>
<p>
El sistema mide continuamente la distancia entre el sensor y la superficie
del agua para determinar el nivel actual dentro del tanque. Cuando el nivel
alcanza aproximadamente el 85 por ciento de la capacidad del depósito,
se activa un buzzer que funciona como una alerta sonora para evitar que
el tanque se llene en exceso y se produzca un desbordamiento.
</p>
<p>
Una vez que el sistema detecta que el agua ha dejado de moverse dentro
del tinaco durante aproximadamente treinta segundos, la alerta sonora
se desactiva automáticamente, indicando que el proceso de llenado ha
terminado.
</p>
<p>
Además del monitoreo mediante el sistema electrónico, se desarrolló una
página web que permite presentar información del funcionamiento del
sistema, explicar la problemática del desperdicio de agua y mostrar
cómo la tecnología puede utilizarse para mejorar la gestión de los
recursos hídricos.
</p>
<p>
Esta solución tecnológica contribuye al uso responsable del agua y se
relaciona con los esfuerzos internacionales para promover una gestión
sostenible de este recurso, especialmente con el objetivo que busca
garantizar la disponibilidad y el uso eficiente del agua.
</p>
<p style="font-size:14px; color:gray;">
*Datos estimados con fines ilustrativos para mostrar el impacto del desperdicio de agua en sistemas de almacenamiento doméstico.
</p>
<img src="../assets/img/Estadisticas.png" alt="Estadísticas del sistema" width="800" >
<div class="modal-botones">

<button class="btn-modal" data-modal="modalODS">ODS 6</button>
<button class="btn-modal" data-modal="modalProducto">Nuestro sistema</button>
<button class="btn-modal" data-modal="modalBeneficios">Beneficios</button>

</div>


<!-- MODAL ODS -->
<div id="modalODS" class="modal">
<div class="modal-contenido">

<span class="cerrar">&times;</span>

<h2>ODS 6: Agua limpia y saneamiento</h2>

<p>
El Objetivo de Desarrollo Sostenible número 6 busca garantizar la
disponibilidad de agua limpia y una gestión sostenible de este recurso
para todas las personas. El agua es esencial para la vida, la salud
y el desarrollo de las comunidades.
</p>

<p>
Uno de los principales problemas relacionados con el agua es su
desperdicio. En muchos hogares el llenado de tinacos no se supervisa
de forma constante, lo que provoca que el agua continúe fluyendo
incluso cuando el depósito ya alcanzó su capacidad máxima.
</p>

<p>
Nuestro proyecto busca contribuir a este objetivo mediante el uso
de tecnología que permita monitorear el nivel del agua y alertar
cuando el tinaco esté cerca de llenarse completamente, evitando así
el desperdicio de este recurso.
</p>

</div>
</div>



<!-- MODAL PRODUCTO -->
<div id="modalProducto" class="modal">
<div class="modal-contenido">

<span class="cerrar">&times;</span>

<h2>Nuestro sistema tecnológico</h2>

<p>
El sistema desarrollado combina hardware y software para monitorear
el nivel de agua dentro de un tinaco. Utiliza un microcontrolador
Arduino, un sensor ultrasónico y un buzzer que funcionan de manera
conjunta para detectar cuándo el nivel del agua está cerca de su
límite.
</p>

<p>
El sensor ultrasónico mide la distancia entre el sensor y la
superficie del agua para determinar el nivel dentro del tanque.
Cuando el sistema detecta que el nivel alcanza aproximadamente
el 85 por ciento de la capacidad del tinaco, se activa una alarma
sonora.
</p>

<p>
Esta alerta permite que las personas puedan cerrar el flujo de
agua antes de que el tanque se desborde. Cuando el sensor deja
de detectar movimiento en el agua durante aproximadamente
treinta segundos, el sistema desactiva automáticamente la alarma.
</p>

</div>
</div>



<!-- MODAL BENEFICIOS -->
<div id="modalBeneficios" class="modal">
<div class="modal-contenido">

<span class="cerrar">&times;</span>

<h2>Beneficios del proyecto</h2>

<p>
Este sistema ayuda a reducir el desperdicio de agua al alertar
cuando el tinaco está cerca de llenarse completamente. Gracias
a esta advertencia sonora es posible evitar que el agua se
derrame y se pierda innecesariamente.
</p>

<p>
También promueve la conciencia sobre la importancia del cuidado
del agua. La página web permite explicar el problema del
desperdicio del agua y mostrar cómo la tecnología puede
utilizarse para crear soluciones prácticas.
</p>

<p>
Además, el proyecto demuestra que herramientas accesibles como
Arduino y sensores pueden utilizarse para desarrollar soluciones
tecnológicas que beneficien a las personas y al medio ambiente.
</p>

</div>
</div>
</section>

<script src="../assets/js/hero-parallax.js"></script>
</body>
</html>