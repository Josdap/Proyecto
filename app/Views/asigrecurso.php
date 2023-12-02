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
                <a href="<?php echo base_url();?>/Asignaciones"><i class="fas fa-calendar-alt"></i> Asignaciones</a>
               <a href="<?php echo base_url();?>/Documentacion"><i class="fas fa-folder"></i> Documentación</a>
            

            </div>
        </div>
    </nav>
    <br>  <br>
      <div class="container">
    <div class="row">
        <div class="col-lg-6 offset-lg-3">
            <h2>Asignación de Recursos</h2>
            <div>
                <div>
        <div>
            <a href="<?php echo base_url();?>/Asignaciones" class="regresar-btn" id="regresar-btn"><i class="fas fa-arrow-left"></i> Regresar</a>
         
                <button class="registrar-btn" id="registrar-btn"><i class="fas fa-plus-circle"></i> Asignar Recurso</button>
            
        </div>
             
                </div>
                <br>
                <div class="search-bar"><input type="text" id="search-input" placeholder="Buscar..."></div>
                <table id="table">
                    <tr>
                        <th hidden>ID</th>
                        <th>Proyecto</th>
                        <th>Recurso</th>
                        <th>Cantidad</th>
                        <th>Fecha</th>
                        <th>Editar</th>
                        <th>Eliminar</th>
                    </tr>
                    <?php foreach ($asigrecurso as $asignacion) : ?>
        <tr>
            <td hidden><?= $asignacion['idAsignacionre']; ?></td>
            <td><?= $asignacion['proyecto']; ?></td>
            <td><?= $asignacion['recurso']; ?></td>
            <td><?= $asignacion['Cantidad']; ?></td>
            <td><?php echo date('d/m/Y', strtotime($asignacion['Fecha'])); ?></td>
            <td><a href="#" class="btn-editar" data-id="<?php echo $asignacion['idAsignacionre']; ?>"><i class="fas fa-edit"></i></a></td>
            <td><a href="#" class="btn-eliminar" data-id="<?php echo $asignacion['idAsignacionre']; ?>"><i class="fas fa-trash"></i></a></td>
        </tr>
    <?php endforeach; ?>

                </table>

            </div>
        </div>
    </div>
</div>

<?php if (session()->has('success')): ?>
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '<?= session('success') ?>',
        });
    </script>
<?php elseif (session()->has('error')): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '<?= session('error') ?>',
        });
    </script>
<?php endif; ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        
        document.getElementById("registrar-btn").addEventListener("click", function () {
            
            Swal.fire({
                title: "Asignar Recurso",
                html:`
                    <br>
                    <form id="recurso-form" method="post" action="<?= base_url('/AsigRecurso/Registrar') ?>">
                    <select id="Proyectosre" name="Proyectosre" class="form-control" required>
                    <option value="">Seleccione un Proyecto</option>
                    <?php 
                       $sortedproyectos = array();
                       foreach($proyectos as $proyecto) {
                          $sortedproyectos[$proyecto->nombrep] = $proyecto;
                       }
                       ksort($sortedproyectos);
                       foreach($sortedproyectos as $proyecto) {
                    ?>
                    <option value="<?php echo $proyecto->idProyectos; ?>"><?php echo $proyecto->nombrep; ?></option>
                    <?php 
                       }
                    ?>
                    </select>
                    <br>
                    <select id="Recursosre" name="Recursosre" class="form-control" required>
                    <option value="">Seleccione un Recurso</option>
                    <?php 
                       $sortedrecursos = array();
                       foreach($recursos as $recurso) {
                          $sortedrecursos[$recurso->Nombre] = $recurso;
                       }
                       ksort($sortedrecursos);
                       foreach($sortedrecursos as $recurso) {
                    ?>
                    <option value="<?php echo $recurso->idRecursos; ?>"><?php echo $recurso->Nombre; ?></option>
                    <?php 
                       }
                    ?>
                    </select>
                    <br>
                    <input id="Cantidad" type="number" name="Cantidad" class="form-control" placeholder="Cantidad">
                    </form>`,
                showCancelButton: false,
                confirmButtonText: "Asignar",
                preConfirm: () => {
                const Proyectosre = Swal.getPopup().querySelector('#Proyectosre').value;
                const Recursosre = Swal.getPopup().querySelector('#Recursosre').value;
                const Cantidad = Swal.getPopup().querySelector('#Cantidad').value;
                if (!Proyectosre|| !Recursosre || !Cantidad) {
                    Swal.showValidationMessage('Por favor, completa todos los campos');
                    return false;
                }
                Swal.close();
                document.getElementById('recurso-form').submit();
            }
        });
    });
        });
</script>

        <script type="text/javascript" src="resources/js/buscar.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>

</html>