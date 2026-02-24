<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MW MX</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="../assets/js/sliders.js">
</head>
<?php
include 'layout/header.php';
?>
    <div class="slider">
        <div class="slides">
            <img src="../assets/img/slider.png" alt="image1">
            <img src="../assets/img/slider.png" alt="image2">
            <img src="../assets/img/slider.png" alt="image3">
        </div>
        <button class="prev" onclick="prevSlide()"><</button>
        <button class="next" onclick="nextSlide()">></button>
    </div>
    <script src="../assets/js/sliders.js"></script>
</body>
</html>