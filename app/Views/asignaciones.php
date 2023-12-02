<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="resources/img/logo.png">
    <link rel="stylesheet" href="resources/css/dashboard.css">
    <link rel="stylesheet" type="text/css" href="resources/css/registro.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="resources/js/cerrar.js"></script>
    <script defer src="resources/js/validar.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <title>Grupo D'ealy - Asignaciones</title>
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
                <a href="<?php echo base_url();?>/DashboardController" ><i class="fas fa-home"></i> Inicio</a>
                <a href="<?php echo base_url();?>/Proyectos"><i class="fas fa-cogs"></i> Proyectos</a>
                <a href="<?php echo base_url();?>/Personal"><i class="fas fa-users"></i> Personal</a>
                 <a href="<?php echo base_url();?>/Clientes"><i class="fas fa-user-friends"></i> Clientes</a>
                <a href="<?php echo base_url();?>/Recursos"><i class="fas fa-briefcase"></i> Recursos</a>
                <a href="<?php echo base_url();?>/Asignaciones"class="active"><i class="fas fa-calendar-alt"></i> Asignaciones</a>
                <a href="<?php echo base_url();?>/Documentacion"><i class="fas fa-folder"></i> Documentación</a>

            

            </div>
        </div>
    </nav>

    <div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <br> <br>
            <h2>Modulo de Asignaciones</h2>
            <div>
                <div>
                    <div class="buton-container">
                    <button class="recurso-btn" id="recurso-btn" onclick="window.location.href = '<?php echo base_url();?>/AsigRecurso';"><i class="fas fa-plus-circle"></i> Asignar Recurso</button>
                    <button class="personal-btn" id="personal-btn" onclick="window.location.href = '<?php echo base_url();?>/AsigPersonal';"><i class="fas fa-plus-circle"></i> Asignar Personal</button>
                </div>
                    <div class="reporte-btn-container">
                    <a href="<?php echo base_url();?>/Asignaciones/generarPDF " class="reporte-btn" id="reporte-btn" type="submit"><i class="fas fa-file-pdf"></i></a>
                    <a href="# " class="reporte-btn" id="reporte-btn-excel" type="submit"><i class="fas fa-file-excel"></i></a>
                </div>
                </div>
                <div>      
                </div>
                <br>
                <div class="search-bar"><input type="text" id="search-input" placeholder="Buscar..."></div>
<table id="table">
    <tr>
        <th>Proyecto</th>
        <th>Empleado</th>
        <th>Recurso</th>
        <th>Cantidad</th>
        <th>Fecha</th>
    </tr>
    <?php foreach ($combinedData as $asignacion) : ?>
        <tr>
            <td><?php echo $asignacion['proyecto']; ?></td>
            <td>
                <?php if (isset($asignacion['empleado'])) : ?>
                    <ul>
                        <?php foreach ($asignacion['empleado'] as $empleado) : ?>
                            <li><?php echo $empleado; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($asignacion['recurso'])) : ?>
                    <ul>
                        <?php foreach ($asignacion['recurso'] as $recurso) : ?>
                            <li><?php echo $recurso; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($asignacion['Cantidad'])) : ?>
                    <ul>
                        <?php foreach ($asignacion['Cantidad'] as $cantidad) : ?>
                            <li><?php echo $cantidad; ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </td>
            <td>
                <?php if (isset($asignacion['Fecha'])) : ?>
                    <?php $fechaActual = '';
                    foreach ($asignacion['Fecha'] as $fecha) :
                        if ($fecha !== $fechaActual) : ?>
                            <?php echo $fecha; ?>
                            <?php $fechaActual = $fecha; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>







            </div>
        </div>
    </div>
</div>

        <script type="text/javascript" src="resources/js/buscar.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>