<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

require_once "../controller/TanksController.php";
$controller = new TanksController();
$user = $_SESSION['user'];

$tanksSummary = $controller->getTanksSummary($user['idUser']);
$statsByTank = $controller->getStatsByTank($user['idUser']);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - MerryWeather</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        .dashboard-wrapper {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .header-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .kpi-card {
            background: white;
            padding: 24px;
            border-radius: 16px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            border: 1px solid #e2e8f0;
            text-align: left;
        }

        .kpi-card h3 { 
            margin: 0; font-size: 0.85rem; 
            text-transform: uppercase; color: #64748b; 
            letter-spacing: 0.05em;
        }

        .kpi-card .value { 
            font-size: 2rem; font-weight: 700; 
            margin: 10px 0; color: var(--color-principal);
        }

        .main-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 30px;
        }

        .tank-card.dashboard-variant {
            flex-direction: column;
            padding: 25px;
            width: auto;
            position: relative;
        }

        .tank-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .status-badge {
            background: #dcfce7;
            color: #166534;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .visual-container {
            display: flex;
            gap: 20px;
            align-items: center;
            margin-bottom: 20px;
        }

        .tank-visual {
            width: 70px;
            height: 90px;
            border: 3px solid #cbd5e1;
            border-radius: 8px 8px 15px 15px;
            position: relative;
            overflow: hidden;
            background: #f1f5f9;
            flex-shrink: 0;
        }

        .water-level {
            position: absolute;
            bottom: 0;
            width: 100%;
            background: linear-gradient(180deg, var(--color-principal) 0%, var(--color-secundary) 100%);
            transition: height 1s ease-in-out;
        }

        .chart-area {
            flex-grow: 1;
            height: 120px;
        }

        /* Estilos del Botón Detalle */
        .btn-details {
            display: block;
            text-align: center;
            background: #f8fafc;
            color: var(--color-principal);
            text-decoration: none;
            padding: 12px;
            border-radius: 10px;
            font-size: 0.9rem;
            font-weight: 600;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .btn-details:hover {
            background: var(--color-principal);
            color: white;
            border-color: var(--color-principal);
            transform: translateY(-2px);
        }
    </style>
</head>
<body>

<?php include 'layout/header.php'; ?>

<div class="dashboard-wrapper">

    <div class="header-stats">
        <div class="kpi-card">
            <h3>Tanques Activos</h3>
            <div class="value"><?php echo count($tanksSummary); ?></div>
        </div>
        <div class="kpi-card">
            <h3>Calidad Promedio</h3>
            <div class="value">
                <?php 
                $avg = array_column($tanksSummary, 'avg_quality');
                echo count($avg) ? round(array_sum($avg)/count($avg)) : 0; 
                ?>%
            </div>
        </div>
        <div class="kpi-card">
            <h3>Estado General</h3>
            <div class="value" style="color: #22c55e;">Online</div>
        </div>
    </div>

    <div class="main-grid">
        <?php foreach ($tanksSummary as $tank): 
            $porcentaje_real = floatval($tank['current_level']); 
            $litros_reales = ($porcentaje_real / 100) * floatval($tank['capacity']);
        ?>
            <div class="tank-card dashboard-variant">
                <div class="tank-header">
                    <div>
                        <h2 style="margin:0; font-size: 1.2rem; color: var(--color-principal);">
                            <?php echo htmlspecialchars($tank['description']); ?>
                        </h2>
                        <small style="color: #64748b;"><?php echo $tank['location']; ?></small>
                    </div>
                    <span class="status-badge">Hoy <?php echo date('H:i', strtotime($tank['last_update'])); ?></span>
                </div>

                <div class="visual-container">
                    <div class="tank-visual" title="Nivel: <?php echo $porcentaje_real; ?>%">
                        <div class="water-level" style="height: <?php echo $porcentaje_real; ?>%"></div>
                    </div>
                    
                    <div style="flex-grow: 1;">
                        <div style="display:flex; justify-content: space-between; margin-bottom: 5px;">
                            <span style="font-weight: 700;"><?php echo number_format($porcentaje_real, 1); ?>%</span>
                            <span style="color: #64748b; font-size: 0.75rem;"><?php echo number_format($litros_reales, 2); ?>L / <?php echo $tank['capacity']; ?>L</span>
                        </div>
                        <div class="chart-area">
                            <canvas id="chart-<?php echo $tank['idTank']; ?>"></canvas>
                        </div>
                    </div>
                </div>

                <a href="tank_details.php?id=<?php echo $tank['idTank']; ?>" class="btn-details">
                    Ver más detalles
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    const stats = <?php echo json_encode($statsByTank); ?>;
    const primaryColor = getComputedStyle(document.documentElement).getPropertyValue('--color-principal').trim() || '#2d8ceb';
    
    Object.keys(stats).forEach(id => {
        const canvas = document.getElementById(`chart-${id}`);
        if(!canvas) return;
        
        const ctx = canvas.getContext('2d');
        const gradient = ctx.createLinearGradient(0, 0, 0, 150);
        gradient.addColorStop(0, primaryColor + '44'); 
        gradient.addColorStop(1, primaryColor + '00');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: stats[id].dates,
                datasets: [{
                    data: stats[id].levels, 
                    borderColor: primaryColor,
                    borderWidth: 2,
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: { 
                    x: { display: false },
                    y: { 
                        beginAtZero: true, 
                        max: 100, 
                        display: false
                    } 
                }
            }
        });
    });
</script>
</body>
</html>