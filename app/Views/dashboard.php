<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="resources/img/logo.png">
    <link rel="stylesheet" href="resources/css/dashboard.css">
    <link rel="stylesheet" href="resources/css/contenedores.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="resources/js/cerrar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo base_url();?>/public/css/separate/vendor/pnotify.min.css">
    <title>Grupo D'ealy - Dashboard</title>
</head>
<body>
    <nav class="navbar">
        <div class="container-fluid">
            <div class="dropdown ms-auto">
                <button class="btn dropdown-toggle" type="button" id="user-dropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <img id="profile-image" class="img-profile rounded-circle" src="resources/img/logo.png" alt="" style="width: 40px; height: 40px;">
                    Administrador
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="user-dropdown">
                    <li><a class="dropdown-item d-flex align-items-center" href="#" onclick="fntcerrar()"><i class="fas fa-sign-out-alt me-2"></i>Cerrar sesión</a></li>
                </ul>
            </div>
            <div class="sidebar">
                <div class="logo">
                    <img src="resources/img/GrupoealySRL.png" alt="Logo de la empresa">
                </div>
                <a href="<?php echo base_url();?>/DashboardController"class="active" ><i class="fas fa-home"></i> Inicio</a>
                <a href="<?php echo base_url();?>/Proyectos"><i class="fas fa-cogs"></i> Proyectos</a>
                <a href="<?php echo base_url();?>/Personal"><i class="fas fa-users"></i> Personal</a>
                <a href="<?php echo base_url();?>/Clientes"><i class="fas fa-user-friends"></i> Clientes</a>
                <a href="<?php echo base_url();?>/Recursos"><i class="fas fa-briefcase"></i> Recursos</a>
                <a href="<?php echo base_url();?>/Asignaciones"><i class="fas fa-calendar-alt"></i> Asignaciones</a>
                <a href="<?php echo base_url();?>/Documentacion"><i class="fas fa-folder"></i> Documentación</a>

            

            </div>
        </div>
    </nav>



<div class="dashboard-container">
    <a href="<?php echo base_url('/Proyectos'); ?>" class="dashboard-card orange">
        <i class="fas fa-hard-hat card-icon"></i>
        <h3>Proyectos registrados</h3>
        <br>
        <h2><?php echo $numProyectos; ?></h2>
    </a>
    <a href="<?php echo base_url('/Personal'); ?>" class="dashboard-card blue">
        <i class="fas fa-users card-icon"></i>
        <h3>Personal registrado</h3>
        <br>
        <h2><?php echo $numPersonal; ?></h2>
    </a>
    <a href="<?php echo base_url('/Recursos'); ?>" class="dashboard-card green">
        <i class="fas fa-toolbox card-icon"></i>
        <h3>Recursos</h3>
        <br>
        <h2><?php echo $numRecursos; ?></h2>
    </a>
    <a href="<?php echo base_url('/Proyectos'); ?>" class="dashboard-card red">
        <i class="fas fa-check-circle card-icon"></i>
        <h3>Proyectos compleatados</h3>
        <br>
        <h2><?php echo $numProyectosCompletados; ?></h2>
    </a>
   <div class="graficos-container">
        <div class="graficos-card" id="proyectosChartCard">
            <h3 class="chart-title">Estado de Proyectos</h3>
            <canvas id="proyectosChart" width="400" height="400"></canvas>
        </div>
        <div class="graficos-card" id="empleadosProyectosChartCard">
            <h3 class="chart-title">Proyectos por Empleado</h3>
            <canvas id="empleadosProyectosChart" width="400" height="400"></canvas>
        </div>
        <div class="graficos-card" id="stockRecursosChartCard">
            <h3 class="chart-title">Stock de Recursos</h3>
            <canvas id="stockRecursosChart" width="400" height="400"></canvas>
        </div>
        <div class="graficos-card" id="clientesProyectosChartCard">
            <h3 class="chart-title">Documentos por Proyectos</h3>
            <canvas id="clientesProyectosChart" width="400" height="400"></canvas>
        </div>


    </div>
    <div class="btn-container">
    <button class="btn-anterior" onclick="showPrevChart()"><i class="fas fa-arrow-circle-left"></i></button>
    <button class="btn-siguiente" onclick="showNextChart()"><i class="fas fa-arrow-circle-right"></i></button>
</div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        hideAllCharts();
        showChart('proyectosChartCard');
    });

    var currentChartIndex = 0;
    var chartIds = ['proyectosChartCard', 'empleadosProyectosChartCard', 'stockRecursosChartCard', 'clientesProyectosChartCard'];

function hideAllCharts() {
    var charts = document.querySelectorAll('.graficos-card');
    charts.forEach(function (chart) {
        chart.style.position = 'absolute';
        chart.style.left = '-9999px';
    });
}

function showChart(chartId) {
    var chart = document.getElementById(chartId);
    if (chart) {
        chart.style.position = 'dinamic';
        chart.style.left = 'auto';
    }
}


    function showPrevChart() {
        hideAllCharts();
        currentChartIndex = (currentChartIndex - 1 + chartIds.length) % chartIds.length;
        showChart(chartIds[currentChartIndex]);
    }

    function showNextChart() {
        hideAllCharts();
        currentChartIndex = (currentChartIndex + 1) % chartIds.length;
        showChart(chartIds[currentChartIndex]);
    }
</script>

<script>
   
  var proyectosChart = new Chart(document.getElementById('proyectosChart').getContext('2d'), {
        type: 'pie',
        data: {
            labels: ["Iniciados", "No iniciados", "Completados"],
            datasets: [{
                label: 'Proyectos',
                data: [
                    <?php echo $numProyectosIniciados; ?>,
                    <?php echo $numProyectosNoIniciados; ?>,
                    <?php echo $numProyectosCompletados; ?>
                ],
                backgroundColor: ['yellow', 'red', 'green'],
            }]
        },
    });
 
    var empleadosProyectosChart = new Chart(document.getElementById('empleadosProyectosChart').getContext('2d'), {
        type: 'bar',
        data: {
            labels: [
                <?php foreach ($empleadosProyectos as $empleado): ?>
                    "<?php echo $empleado['nombre']; ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Cantidad de Proyectos',
                data: [
                    <?php foreach ($empleadosProyectos as $empleado): ?>
                        <?php echo $empleado['numProyectos']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'blue',
            }]
        },
    });
   
 var stockRecursosChart = new Chart(document.getElementById('stockRecursosChart').getContext('2d'), {
        type: 'line',
        data: {
            labels: [
                <?php foreach ($stockRecursos as $recurso): ?>
                    "<?php echo $recurso['Nombre']; ?>",
                <?php endforeach; ?>
            ],
            datasets: [{
                label: 'Stock de Recursos',
                data: [
                    <?php foreach ($stockRecursos as $recurso): ?>
                        <?php echo $recurso['Stock']; ?>,
                    <?php endforeach; ?>
                ],
                backgroundColor: 'green',
            }]
        },
    });

   
var paletaColores = [
    'orange',
    'blue',
    'green',
    'red',
    'purple',
    
];

var cantidaddoc = <?php echo json_encode(array_column($cantidaddoc, 'documento')); ?>;
var coloresClientes = cantidaddoc.map(function (_, index) {
    return paletaColores[index % paletaColores.length];
});

var clientesProyectosChart = new Chart(document.getElementById('clientesProyectosChart').getContext('2d'), {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(array_column($cantidaddoc, 'proyecto')); ?>,
        datasets: [{
            label: 'Cantidad de documentos',
            data: cantidaddoc,
            backgroundColor: coloresClientes,
        }]
    },
});
</script>


<?php if (session()->getFlashdata('alertaStockBajo')) : ?>
    <script>
        $(document).ready(function () {
            var alerta = new PNotify({
                title: 'Alerta de stock',
                text: '¡Atención! Algunos recursos tienen un stock bajo.',
                type: 'warning',
                delay: 4000
            });
            alerta.get().addClass('clickable-alert');
            alerta.get().click(function () {
                window.location.href = '<?php echo base_url('/Recursos'); ?>';
            });
        });
    </script>
    <style>
        .clickable-alert {
            cursor: pointer;
        }
    </style>
<?php endif; ?>





<?php
$notificationShown = session()->get('notificationShown');
$isLoggedIn = session()->get('isLoggedIn');
$username = session()->get('username');

if ($isLoggedIn && !$notificationShown) :
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            new PNotify({
                title: '¡Bienvenido de nuevo!',
                text: '<?= esc($username) ?>, has iniciado sesión con éxito.',
                type: 'success'
            });

            setTimeout(function () {
                
                welcomeNotification.close();
            }, 500);

            <?php session()->set('notificationShown', true); ?>
        });
    </script>
<?php endif; ?>





     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="<?php echo base_url();?>/public/js/lib/pnotify/pnotify.js"></script>
    <script src="<?php echo base_url();?>/public/js/lib/pnotify/pnotify-init.js"></script>
</body>

</html>
