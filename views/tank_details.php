<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "../controller/TanksController.php";
$controller = new TanksController();

$idTank = isset($_GET['id']) ? intval($_GET['id']) : 0;
$user = $_SESSION['user'];

$db = (new DataBase())->getConnection();
$stmt = $db->prepare("CALL sp_ObtenerDetalleAnaliticoTanque(:idTank)");
$stmt->bindParam(":idTank", $idTank, PDO::PARAM_INT);
$stmt->execute();
$details = $stmt->fetch(PDO::FETCH_ASSOC);
$stmt->closeCursor();

if (!$details) {
    die("Tanque no encontrado.");
}

$allStats = $controller->getStatsByTank($user['idUser']);
$tankStats = $allStats[$idTank] ?? ['levels' => [], 'dates' => []];

$porcentaje_actual = floatval($details['current_level']); 
$capacidad_maxima = floatval($details['capcity']);
$litros_reales = ($porcentaje_actual / 100) * $capacidad_maxima;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles - <?php echo htmlspecialchars($details['description']); ?></title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        :root {
            --primary: #3b82f6;
            --bg-body: #f4f7f6;
            --text-main: #1e293b;
            --text-muted: #64748b;
        }

        .details-container { 
            max-width: 100%; 
            margin: 20px auto; 
            padding: 0 15px; 
            font-family: 'Segoe UI', system-ui, sans-serif; 
        }

        .grid-info { 
            display: grid; 
            max-width: 100%;
            grid-template-columns: 350px 1fr; 
            gap: 20px; 
        }

        @media (max-width: 900px) {
            .grid-info { 
                grid-template-columns: 1fr; 
            }
            .details-container { 
                max-width: 100%; 
            }
            .card { 
                max-width: 100%;
            }
        }

        .card { 
            background: #fff; 
            max-width: 100%;
            padding: 25px; 
            border-radius: 20px; 
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); 
        }

        .text-center { text-align: center; }
        
        /* Badges de Estado */
        .alert-box { 
            padding: 12px; 
            border-radius: 12px; 
            margin-top: 20px; 
            font-weight: 700; 
            font-size: 0.9rem; 
        }
        .status-Normal { background: #dcfce7; color: #166534; }
        .status-Posible { background: #fee2e2; color: #991b1b; }
        .status-Llenado { background: #e0f2fe; color: #075985; }
        .status-Inactivo { background: #f1f5f9; color: #475569; }

        /* Grid de Datos */
        .data-grid { 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 15px; 
            margin: 20px 0; 
        }

        @media (max-width: 480px) {
            .data-grid { 
                grid-template-columns: 1fr;
            }
        }

        .data-item { 
            background: #f8fafc; 
            padding: 15px; 
            border-radius: 12px; 
            border: 1px solid #e2e8f0; 
        }
        .data-item label { 
            display: block; 
            font-size: 0.7rem; 
            color: var(--text-muted); 
            text-transform: uppercase; 
            font-weight: bold;
        }
        .data-item span { 
            font-size: 1.1rem; 
            font-weight: 700; 
            color: var(--text-main); 
        }

        .chart-container { 
            position: relative;
            height: 300px; 
            width: 100%;
            margin-top: 20px; 
        }

        .back-link { 
            text-decoration: none; 
            color: var(--text-muted); 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            margin-bottom: 20px; 
            font-weight: 500;
        }

        /* Tinaco Visual */
        .tank-visual {
            width: 80px; height: 110px; border: 4px solid #cbd5e1;
            margin: 20px auto; border-radius: 8px 8px 18px 18px;
            position: relative; overflow: hidden; background: #f1f5f9;
        }
        .water-level {
            position: absolute; bottom: 0; width: 100%;
            background: linear-gradient(180deg, var(--primary) 0%, #1d4ed8 100%);
            transition: height 1.5s ease-in-out;
        }
    </style>
</head>
<body style="background-color: var(--bg-body);">

<?php include 'layout/header.php'; ?>

<div class="details-container">
    <a href="dashboard.php" class="back-link">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        Volver al Panel
    </a>
    
    <div class="grid-info">
        <div class="card text-center">
            <h2 style="margin:0; color: var(--text-main);"><?php echo htmlspecialchars($details['description']); ?></h2>
            <span style="color: var(--text-muted);"><?php echo $details['location']; ?></span>
            
            <div class="tank-visual">
                <div class="water-level" style="height: <?php echo $porcentaje_actual; ?>%"></div>
            </div>
            
            <div style="font-size: 3rem; font-weight: 800; color: var(--text-main);">
                <?php echo round($porcentaje_actual); ?><small style="font-size: 1.2rem; color: var(--text-muted);">%</small>
            </div>
            
            <div class="alert-box status-<?php echo explode(' ', $details['status_eval'])[0]; ?>">
                <?php echo $details['status_eval']; ?>
            </div>

            <div style="margin-top: 25px; text-align: left; padding: 15px; background: #fff9eb; border-radius: 12px; border-left: 4px solid #f59e0b;">
                <p style="margin: 0; font-size: 0.85rem; color: #78350f;">
                    <strong>Recomendación:</strong><br>
                    <?php 
                    if($details['quality'] < 50) echo "Calidad de agua baja, revise sedimentos.";
                    elseif($porcentaje_actual < 20) echo "Nivel crítico de agua.";
                    elseif(strpos($details['status_eval'], 'Fuga') !== false) echo "Posible fuga detectada de noche.";
                    else echo "Operación normal.";
                    ?>
                </p>
            </div>
        </div>

        <div class="card">
            <h3 style="margin-top: 0;">Análisis de Consumo</h3>
            
            <div class="data-grid">
                <div class="data-item">
                    <label>Litros Actuales</label>
                    <span><?php echo number_format($litros_reales, 1); ?> L</span>
                </div>
                <div class="data-item">
                    <label>Capacidad</label>
                    <span><?php echo number_format($capacidad_maxima); ?> L</span>
                </div>
                <div class="data-item">
                    <label>Calidad</label>
                    <span style="color: <?php echo $details['quality'] > 70 ? '#16a34a' : '#ca8a04'; ?>">
                        <?php echo $details['quality']; ?>%
                    </span>
                </div>
                <div class="data-item">
                    <label>Actualización</label>
                    <span style="font-size: 0.9rem;"><?php echo date('H:i', strtotime($details['last_update'] ?? 'now')); ?></span>
                </div>
            </div>

            <div class="chart-container">
                <canvas id="tankDetailChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const ctx = document.getElementById('tankDetailChart').getContext('2d');
    
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: <?php echo json_encode($tankStats['dates']); ?>,
            datasets: [{
                label: 'Nivel %',
                data: <?php echo json_encode($tankStats['levels']); ?>,
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                fill: true,
                tension: 0.4,
                pointRadius: 3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, max: 100 },
                x: { ticks: { maxRotation: 45, minRotation: 45 } }
            }
        }
    });
</script>
</body>
</html>